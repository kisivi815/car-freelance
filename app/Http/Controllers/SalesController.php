<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuickSalesRequest;
use App\Http\Requests\SubmitSalesRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\QuickSales;
use App\Models\CarMaster;
use App\Models\Branch;
use App\Models\Sales;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
        } catch (ModelNotFoundException $e) {
        }
    }

    public function show(Request $request)
    {
        $car = CarMaster::where('PhysicalStatus', 'RECEIVED APPROVED')->get();
        $branch = Branch::all();
        $data = ['car' => $car, 'branch' => $branch];
        return view('quick-sale')->with(['title' => 'Quick Sale', 'data' => $data]);
    }

    public function store(QuickSalesRequest $request)
    {
        try {
            $user = Auth::user();
            $validatedData = $request->validated();
            $branch = Branch::where('id', $request->input('Branch'))->first();
            $count = QuickSales::where('Branch', $request->input('Branch'))->count();
            $salesId = strtoupper(substr($branch->name, 0, 3)).$count+1;
            $validatedData['SalesId'] = $salesId;
            $newRecord = QuickSales::create($validatedData);

            return redirect()->route('quick-sale')->with('message', 'Submitted successfully!');


        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('quick-sale')->with('error', 'Error occurred while submitting!');
        }
    }

    public function getQuickSalesGatePass(Request $request, string $id){
        try {
            $message = '';
            $quickSales = QuickSales::findOrFail($id);
            if (isset($request->input()['from']) == 'quick-sales') {
                $message = 'On ' . Carbon::today()->format('d-m-Y') . ', ' . $quickSales->ChasisNo . ' cars were sold from ' . $quickSales->Source->name ;
                session(['message' => $message]);
            }
            return view('quick-sale-gate-pass')->with(['title' => 'Quick Sales Gate Pass', 'data' => $quickSales]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-sale')->with('error', 'Record not found.');
        }
    }

    public function salesForm(Request $request, string $id = null)
    {
        $car = CarMaster::where('PhysicalStatus','In Transit')->get();
        $branch = Branch::all();

        if($id){
            $sales = Sales::where('id', $id)->first();
        }
        
        $data = ['car' => $car, 'branch' => $branch,'data'=>(isset($sales))?$sales:null];
        return view('sales-form')->with(['title' => 'Transfer Stock', 'data' => $data]);
    }

    public function submitSalesForm(SubmitSalesRequest $request,string $id = null){
        try {
            if(!$id){
                $validatedData = $request->validated();
                $newRecord = Sales::create($validatedData);
                return redirect()->route('view-sale')->with('message', 'Submitted successfully!');
            }
            
        } catch (ModelNotFoundException $e) {
            return redirect()->route('view-sale')->with('error', 'Record not found.');
        }
    }
}
