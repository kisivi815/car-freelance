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
use App\Services\LogService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
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
                ['text' => 'In Transit', 'value' => 'In Transit'],
                ['text' => 'Received - OK', 'value' => 'Received - OK'],
                ['text' => 'Received Approved', 'value' => 'RECEIVED APPROVED'],
                ['text' => 'Received Rejected', 'value' => 'RECEIVED REJECTED'],
                ['text' => 'Stock T/F', 'value' => 'STOCK TF'],
                ['text' => 'Test Drive Vehicle', 'value' => 'Test Drive Vehicle'],
                ['text' => 'Sold', 'value' => 'Sold']
                
            ];

            $query = CarMaster::query()->with(['TrasnferStock','Sales']);

            if ($request->branch) {
                $query->whereHas('TrasnferStock',function($q) use($request){
                    $q->where(function($q) use($request){
                        $q->orWhere('SourceBranch', $request->branch);
                        $q->orWhere('DestinationBranch', $request->branch);
                    });
                });
            }

            if ($request->status) {
                if ($request->status == 'In Transit') {
                    $query->where('PhysicalStatus','In Transit');
                }

                if ($request->status == 'Received - OK') {
                    $query->where('PhysicalStatus','Received - OK');
                }

                if ($request->status == 'RECEIVED APPROVED') {
                    $query->where('PhysicalStatus','RECEIVED APPROVED');
                }

                if ($request->status == 'RECEIVED REJECTED') {
                    $query->where('PhysicalStatus','RECEIVED REJECTED');
                }

                if ($request->status == 'STOCK TF') {
                    $query->where('PhysicalStatus','STOCK TF');
                }

                if ($request->status == 'Test Drive Vehicle') {
                    $query->where('PhysicalStatus','Test Drive Vehicle');
                }

                if ($request->status == 'Sold') {
                    $query->where('PhysicalStatus','Sold');
                }
            }

            if ($request->startDate) {
                $query->Where('created_at', '>=', $request->startDate);
            }

            if($request->endDate){
                $query->Where('created_at', '<=', $request->endDate);
            }

            $query->orderBy('created_at', 'asc');
            $result = $query->paginate(10)->appends($request->all());

            $data = ['status' => $status, 'result' => $result];
            return view('report')->with(['title' => 'Report','branch'=> $branch, 'data' => $data]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('report')->with('error', 'Record not found.');
        }
    }

}
