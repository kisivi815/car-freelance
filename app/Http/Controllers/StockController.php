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
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
                ['text' => 'Approved', 'value' => 'RECEIVED'],
                ['text' => 'Rejected', 'value' => 'REJECTED'],
                ['text' => 'Stock T/F', 'value' => 'STOCK TF']
            ];
            $query = TransferStock::with(['CarMaster', 'Source', 'Destination']);

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
                $query->whereHas('CarMaster', function ($subQuery) use ($request) {
                    $subQuery->where('PhysicalStatus', $request->status);
                });
            }

            $result = $query->paginate(10);

            $data = ['status' => $status, 'branch' => $branch, 'result' => $result];
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
            $userName = Auth::user()->name;
            $validatedData = $request->validated();

            $car = CarMaster::where('ChasisNo',$validatedData['ChasisNo'])->first();
            $lastTransferStock = TransferStock::with('CarMaster','Destination')->where('ChasisNo',$validatedData['ChasisNo'])->orderBy('id','desc')->first();
            if($car->PhysicalStatus == 'RECEIVED' && $lastTransferStock->DestinationBranch == $validatedData['DestinationBranch']){
                return redirect()->back()->with(['error' => 'Chasis No '.$validatedData['ChasisNo']. 'is already at '.$lastTransferStock->Destination->name.' branch.']);
            }

            if($validatedData['SourceBranch'] == $validatedData['DestinationBranch']){
                $return = ['error' => 'Source and Destination branches cannot be same'];
                return redirect()->back()->with($return);
            }

            $validatedData['DateOfTransfer'] = Carbon::today();
            $validatedData['SendBy'] = $userName;
            $newRecord = TransferStock::create($validatedData);
            $newRecordId = $newRecord->id;
            $data['GatePassId'] = 'TF' . $newRecordId;
            $TransferStock = TransferStock::with('CarMaster','Destination')->find($newRecordId);
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

            CarMaster::where('ChasisNo',$validatedData['ChasisNo'])->update([
                'PhysicalStatus' => 'STOCK TF'
            ]);

            $return = ['message' => 'On '.Carbon::today()->format('d-m-Y').', '.$validatedData['ChasisNo'].' cars were transferred to '.$TransferStock->Destination->name.' Branch', 'gate' => $TransferStock];

            return redirect()->back()->with($return);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Submit error');
        }
    }

    public function getReceiveStock(Request $request)
    {
        try {
            $result = TransferStock::with('CarMaster', 'Source', 'Destination')->findOrFail($request->id);
            return view('receive-stock')->with(['title' => 'Receive Stock', 'data' => $result]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    public function submitReceiveStock(Request $request)
    {
        try {
            $TransferStock = TransferStock::with('CarMaster')->findOrFail($request->id);
            $TransferStock->ReceivedBy = $request->ReceivedBy;
            $TransferStock->DateOfReceive = Carbon::today();
            $TransferStock->ReceiveNote = $request->Note;

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
                $car = CarMaster::where('ChasisNo',$TransferStock->ChasisNo)->update([
                    'PhysicalStatus' => 'RECEIVED'
                ]);
                $message = 'Stock received successfully';
            } else {
                $car = CarMaster::where('ChasisNo',$TransferStock->ChasisNo)->update([
                    'PhysicalStatus' => 'REJECTED'
                ]);
                $message = 'Stock rejected successfully';
            }
           

            return redirect()->route('view-stock')->with(['title' => 'View Stock','message'=> $message]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function getStockDetails(Request $request)
    {
        try {
            $result = TransferStock::with(['CarMaster', 'Source', 'Destination', 'Image'])->findOrFail($request->id);
            return view('stock-details')->with(['title' => 'Stock Details', 'data' => $result]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    public function show(Request $request)
    {
        $car = CarMaster::all();
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
            if($delete){
                return 'success';
            }else{
                return 'failed';
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    public function getCarDetais(Request $request){
        $car = CarMaster::where('ChasisNo',$request->ChasisNo)->first();
        return $car;
    }
}
