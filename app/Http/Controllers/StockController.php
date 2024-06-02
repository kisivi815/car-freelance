<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\TransferStockRequest;
use App\Models\Car;
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
                ['text' => 'Approved', 'value' => '1'],
                ['text' => 'Rejected', 'value' => '2'],
                ['text' => 'No Status', 'value' => '3'],
            ];
            $query = TransferStock::with(['Car', 'Source', 'Destination']);

            if ($request->car) {
                $query->whereHas('Car', function ($subQuery) use ($request) {
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
                if (in_array($request->status, ['1', '2'])) {
                    $query->Where('Status', $request->status);
                } else {
                    $query->Where('Status', null);
                }
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
            $validatedData['DateOfTransfer'] = Carbon::today();
            $validatedData['SendBy'] = $userName;
            $newRecord = TransferStock::create($validatedData);
            $newRecordId = $newRecord->id;
            $data['GatePassId'] = 'TF' . $newRecordId;
            $TransferStock = TransferStock::with('Car')->find($newRecordId);
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

            $return = ['message' => 'Form submitted successfully!', 'gate' => $TransferStock];

            return redirect()->back()->with($return);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Submit error');
        }
    }

    public function getReceiveStock(Request $request)
    {
        try {
            $result = TransferStock::with('Car', 'Source', 'Destination')->findOrFail($request->id);
            return view('receive-stock')->with(['title' => 'Receive Stock', 'data' => $result]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    public function submitReceiveStock(Request $request)
    {
        try {
            $TransferStock = TransferStock::with('Car')->findOrFail($request->id);
            $TransferStock->ReceivedBy = $request->ReceivedBy;
            $TransferStock->DateOfReceive = Carbon::today();
            $TransferStock->ReceiveNote = $request->Note;

            if ($request->status == 'approve') {
                $TransferStock->status = '1';
            } else {
                $TransferStock->status = '0';
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
            return redirect()->route('view-stock')->with(['title' => 'View Stock']);
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
            $result = TransferStock::with(['Car', 'Source', 'Destination', 'Image'])->findOrFail($request->id);
            return view('stock-details')->with(['title' => 'Stock Details', 'data' => $result]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    public function show(Request $request)
    {
        $car = Car::all();
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
}
