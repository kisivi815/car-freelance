<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\TransferStockRequest;
use App\Models\Car;
use App\Models\CarMaster;
use App\Models\Branch;
use App\Models\TransferStock;
use App\Models\Image;
use App\Services\CarMasterStatusService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $branch = Branch::all();
            $status = [
                ['text' => 'All', 'value' => ''],
                ['text' => 'Received Approved', 'value' => 'RECEIVED APPROVED'],
                ['text' => 'Received Rejected', 'value' => 'RECEIVED REJECTED'],
                ['text' => 'Stock T/F', 'value' => 'STOCK TF']
            ];
            $car = CarMaster::all();

            $query = TransferStock::with(['CarMaster', 'Source', 'Destination', 'UserSendBy', 'UserApprovedBy', 'UserRejectedBy']);

            if ($request->car) {
                $query->whereHas('CarMaster', function ($subQuery) use ($request) {
                    $subQuery->where('Model', 'like', '%' . $request->car . '%');
                });
            }

            if ($request->source) {
                $query->Where('SourceBranch', $request->source);
            }

            if ($request->destination) {
                $query->Where('DestinationBranch', $request->destination);
            }

            if ($request->status) {
                if ($request->status == 'RECEIVED APPROVED') {
                    $query->WhereNotNull('ApprovedBy');
                }

                if ($request->status == 'RECEIVED REJECTED') {
                    $query->WhereNotNull('RejectedBy');
                }

                if ($request->status == 'STOCK TF') {
                    $query->where('ApprovedBy', null)->where('RejectedBy', null);
                }
            }

            if ($request->name) {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery->orWhere('SendBy', 'like', '%' . $request->name . '%');
                    $subQuery->orWhere('ReceivedBy', 'like', '%' . $request->name . '%');
                });
            }

            if ($request->chasisNo) {
                $query->Where('ChasisNo', 'like', '%' . $request->chasisNo . '%');
            }

            $query->orderBy('id', 'desc');
            $result = $query->paginate(10)->appends($request->all());

            $data = ['status' => $status, 'branch' => $branch, 'car' => $car, 'result' => $result];
            return view('view-stock')->with(['title' => 'View Stock', 'data' => $data]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransferStockRequest $request)
    {
        try {
            $user = Auth::user();
            $validatedData = $request->validated();

            $car = CarMaster::where('ChasisNo', $validatedData['ChasisNo'])->first();
            $lastTransferStock = TransferStock::with('CarMaster', 'Destination')->where('ChasisNo', $validatedData['ChasisNo'])->orderBy('id', 'desc')->first();
            if (in_array($car->PhysicalStatus, ['RECEIVED APPROVED', 'RECEIVED REJECTED'])  && $lastTransferStock->DestinationBranch == $validatedData['DestinationBranch']) {
                $errorMessage = 'Chasis No ' . $validatedData['ChasisNo'] . 'is already at ' . $lastTransferStock->Destination->name . ' branch.';
                return response()->json(["error" => $errorMessage], '409');
            }

            $validatedData['DateOfTransfer'] = Carbon::today();
            $validatedData['SendBy'] = $user->id;
            if($validatedData['SourceBranch'] == '9'){
                $validatedData['ReceivedBy'] = $validatedData['SendBy'];
            }
            $newRecord = TransferStock::create($validatedData);
            $newRecordId = $newRecord->id;
            $data['GatePassId'] = 'TF' . $newRecordId;
            $TransferStock = TransferStock::with('CarMaster', 'Source', 'Destination')->find($newRecordId);
            $TransferStock->GatePassId = 'TF' . $newRecordId;
            $TransferStock->save();
            if ($request->hasfile('photo')) {
                foreach ($request->file('photo') as $index => $file) {
                    $result = Storage::disk('s3')->put("car-images/" . $newRecordId . "_" . $index . ".jpg", file_get_contents($file));
                    if ($result) {
                        $image['imageurl'] = config('constants.image_url') . "/car-images/" . $newRecordId . "_" . $index . ".jpg";
                        $image['transferstockid'] =  $newRecordId;
                        $image['type'] = 'sender';
                        Image::create($image);
                    }
                }
            }

            CarMaster::where('ChasisNo', $validatedData['ChasisNo'])->update([
                'PhysicalStatus' => 'STOCK TF'
            ]);
            CarMasterStatusService::insertStatus($validatedData['ChasisNo'],'STOCK TF');

            return response()->json([
                'id' => $newRecordId
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => $e->getMessage(), '500']);
        }
    }

    public function getReceiveStock(Request $request)
    {
        try {
            $user = Auth::user();
            $result = TransferStock::with('CarMaster', 'Source', 'Destination')->findOrFail($request->id);
            if (!in_array($result->DestinationBranch, array_column($user->UserBranch->toArray(), 'branch_id'))) {
                return redirect()->back()->withInput()->with('error', 'You have no permission to receive at this branch');
            }
            return view('receive-stock')->with(['title' => 'Receive Stock', 'data' => $result]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    public function submitReceiveStock(Request $request)
    {
        try {
            $user = Auth::user();
            $TransferStock = TransferStock::with('CarMaster')->findOrFail($request->id);
            $TransferStock->ReceivedBy = $request->ReceivedBy;
            $TransferStock->DateOfReceive = Carbon::today();
            $TransferStock->ReceiveNote = $request->Note;
            $TransferStock->MileageReceive = $request->MileageReceive;

            if ($request->status == 'approve') {
                $TransferStock->ApprovedBy = $user->id;
            } else {
                $TransferStock->RejectedBy = $user->id;
            }

            if ($request->hasfile('photo')) {
                foreach ($request->file('photo') as $index => $file) {
                    $result = Storage::disk('s3')->put("receive-car-images/" . $request->id . "_" . $index . ".jpg", file_get_contents($file));
                    if ($result) {
                        $image['imageurl'] = config('constants.image_url') . "/receive-car-images/" . $request->id . "_" . $index . ".jpg";
                        $image['transferstockid'] =  $request->id;
                        $image['type'] = 'receiver';
                        Image::create($image);
                    }
                }
            }

            $TransferStock->save();

            if ($request->status == 'approve') {
                $car = CarMaster::where('ChasisNo', $TransferStock->ChasisNo)->update([
                    'PhysicalStatus' => 'RECEIVED APPROVED'
                ]);
                CarMasterStatusService::insertStatus($TransferStock->ChasisNo,'RECEIVED APPROVED');
            } else {
                $car = CarMaster::where('ChasisNo', $TransferStock->ChasisNo)->update([
                    'PhysicalStatus' => 'RECEIVED REJECTED'
                ]);
                CarMasterStatusService::insertStatus($TransferStock->ChasisNo,'RECEIVED REJECTED');
            }
            $message = 'Stock received successfully';
            return redirect()->route('view-stock')->with(['title' => 'View Stock', 'message' => $message]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->withInput()->with('error', 'Record not found.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function getStockDetails(Request $request)
    {
        try {
            $result = TransferStock::with(['CarMaster', 'Source', 'Destination', 'Image', 'UserSendBy', 'UserApprovedBy', 'UserRejectedBy'])->findOrFail($request->id);
            return view('stock-details')->with(['title' => 'Stock Details', 'data' => $result]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    public function show(Request $request)
    {
        $car = CarMaster::with('TransferStockBranch')->whereIn('PhysicalStatus',['In Transit','RECEIVED APPROVED','RECEIVED REJECTED'])->get();
        $branch = Branch::all();
        $data = ['car' => $car, 'branch' => $branch];
        return view('transfer-stock')->with(['title' => 'Transfer Stock', 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $TransferStock = TransferStock::findOrFail($id);
            $delete = $TransferStock->delete();
            if ($delete) {
                return 'success';
            } else {
                return 'failed';
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    public function getCarDetais(Request $request)
    {
        $car = CarMaster::where('ChasisNo', $request->ChasisNo)->first();
        return $car;
    }

    public function getGatePass(Request $request, string $id)
    {
        try {
            $message = '';
            $TransferStock = TransferStock::with(['CarMaster', 'Source', 'Destination', 'UserSendBy', 'UserApprovedBy', 'UserRejectedBy'])->findOrFail($id);
            if (isset($request->input()['from']) == 'transfer-stock') {
                $message = 'On ' . Carbon::today()->format('d-m-Y') . ', ' . $TransferStock->ChasisNo . ' cars were transferred from ' . $TransferStock->Source->name . ' Branch to ' . $TransferStock->Destination->name . ' Branch';
                session(['message' => $message]);
            }
            return view('gate-pass')->with(['title' => 'Gate Pass', 'data' => $TransferStock]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    public function generateGatePassPDF(Request $request, string $id)
    {
        try {
            $TransferStock = TransferStock::with(['CarMaster', 'Source', 'Destination', 'UserSendBy', 'UserApprovedBy', 'UserRejectedBy'])->findOrFail($id);

            $pdf = Pdf::loadView('pdf.gate-pass', ['title' => 'Gate Pass', 'data' => $TransferStock]);

            return $pdf->stream('TF' . $id . '.pdf');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }
}
