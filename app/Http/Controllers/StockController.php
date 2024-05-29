<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\TransferStockRequest;
use App\Models\Car;
use App\Models\Branch;
use App\Models\TransferStock;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $result = TransferStock::with('Car')->get();
            return view('view-stock')->with(['title' => 'View Stock', 'data' => $result]);
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
    
            $return = ['message' => 'Form submitted successfully!', 'gate' => $TransferStock];
    
            return redirect()->back()->with($return);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Submit error');
        }
        
    }

    public function getReceiveStock(Request $request)
    {
        try {
            $result = TransferStock::with('Car')->findOrFail($request->id);
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

            if($request->status == 'approve'){
                $TransferStock->status = '1';
            }else{
                $TransferStock->status = '0';
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
            $result = TransferStock::with('Car')->findOrFail($request->id);
            return view('stock-details')->with(['title' => 'Stock Details', 'data' => $result]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-stock')->with('error', 'Record not found.');
        }
    }

    public function show(Request $request){
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
        //
    }
}
