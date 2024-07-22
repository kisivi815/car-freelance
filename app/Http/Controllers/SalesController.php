<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuickSalesRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\QuickSales;
use App\Models\CarMaster;
use App\Models\Branch;
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
}
