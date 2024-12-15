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
    public function index()
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

            $data = ['status' => $status];
            return view('report')->with(['title' => 'Report','branch'=> $branch, 'data' => $data]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('report')->with('error', 'Record not found.');
        }
    }
    
    public function exportCsv(Request $request)
    {

        $query = CarMaster::query()->with([
            'TrasnferStock' => function ($q) {
                $q->orderBy('id','desc');
            },
            'Sales'
        ]);

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
            $result = $query->get();
            $data = [
                $headers = [
                    'ChasisNo',
                    'Model',
                    'ProductLine',
                    'Colour',
                    'PhysicalStatus',
                    'EngineNo',
                    'EmissionNorm',
                    'ManufacturingDate',
                    'TMInvoiceDate',
                    'CommercialInvoiceNo',
                    'HSNCode',
                    'TypeOfFuel',
                    'MakersName',
                    'NoOfCylinders',
                    'SeatingCapacity',
                    'CatalyticConverter',
                    'UnladenWeight',
                    'FrontAxle',
                    'RearAxle',
                    'AnyOtherAxle',
                    'TandemAxle',
                    'GrossWeight',
                    'TypeOfBody',
                    'HorsePower',
                    'Rate',
                    'TaxableValue',
                    'Amount',
                    'VehicleAmt',
                    'VehicleNo',
                    'MileageSend',
                    'MileageReceive',
                    'SourceBranch',
                    'DestinationBranch',
                    'DriverName',
                    'Note',
                    'SendBy',
                    'GatePassId',
                    'DateOfTransfer',
                    'ReceivedBy',
                    'DateOfReceive',
                    'ReceiveNote',
                    'ApprovedBy',
                    'RejectedBy',
                    'created_at',
                    'updated_at'
                ], // Header row
            ];
            foreach ($result as $key => $d) {
                $row = [
                        $d->ChasisNo,
                        $d->Model,
                        $d->ProductLine,
                        $d->Colour,
                        $d->PhysicalStatus,
                        $d->EngineNo,
                        $d->EmissionNorm,
                        $d->ManufacturingDate,
                        $d->TMInvoiceDate,
                        $d->CommercialInvoiceNo,
                        $d->HSNCode,
                        $d->TypeOfFuel,
                        $d->MakersName,
                        $d->NoOfCylinders,
                        $d->SeatingCapacity,
                        $d->CatalyticConverter,
                        $d->UnladenWeight,
                        $d->FrontAxle,
                        $d->RearAxle,
                        $d->AnyOtherAxle,
                        $d->TandemAxle,
                        $d->GrossWeight,
                        $d->TypeOfBody,
                        $d->HorsePower,
                        $d->Rate,
                        $d->TaxableValue,
                        $d->Amount,
                ];


                    $row = array_merge($row, [
                        $d->TrasnferStock->VehicleAmt ?? '',
                        $d->TrasnferStock->VehicleNo ?? '',
                        $d->TrasnferStock->MileageSend ?? '',
                        $d->TrasnferStock->MileageReceive ?? '',
                        $d->TrasnferStock->Source->name ?? '',
                        $d->TrasnferStock->Destination->name ?? '',
                        $d->TrasnferStock->DriverName ?? '',
                        $d->TrasnferStock->Note ?? '',
                        $d->TrasnferStock->SendBy ?? '',
                        $d->TrasnferStock->UserSendBy->name ?? '',
                        $d->TrasnferStock->GatePassId ?? '',
                        $d->TrasnferStock->DateOfTransfer ?? '',
                        $d->TrasnferStock->ReceivedBy ?? '',
                        $d->TrasnferStock->ReceiveNote ?? '',
                        $d->TrasnferStock->ApprovedBy ?? '',
                        $d->TrasnferStock->RejectedBy ?? '',
                    ]);
                
                        
                $row = array_merge($row, [  
                        $d->created_at,
                        $d->updated_at,
                    ]);
                    
                    $data[] = $row;
            }

           /*  <td><a href="gate-pass/{{$d->id}}">{{$d->id}}</a></td>
                                                        <td>{{$d->DateOfTransfer}}</td>
                                                        <td>{{$d->Source->name}}</td>
                                                        <td>{{ucwords($d->UserSendBy->name)}}</td>
                                                        <td><a href="stock-details/{{$d->id}}">Details</td>
                                                        <td>{{$d->Destination->name}}</td>
                                                        <td>{{ $d->ReceivedBy ? $d->ReceivedBy : '-' }}</td>
                                                        <td><a href="stock-details/{{$d->id}}">{{ $d->ReceivedBy ? 'Details' : '-' }}</td>
                                                        <td>{{$d->CarMaster->Model}}</td>
                                                        <td>{{$d->CarMaster->ProductLine}}</td>
                                                        <td>{{$d->CarMaster->Colour}}</td>
                                                        <td>{{$d->ChasisNo}}</td>
                                                        <td>{{($d->ReceivedBy)?$d->Destination->name:$d->Source->name}}</td>
                                                        <td>{{$d->MileageSend}}</td>
                                                        <td>{{$d->MileageReceive}}</td>
                                                        <td>{{$d->CarMaster->TMInvoiceDate}}</td>
                                                        <td>{{$d->CarMaster->TMInvoiceDate ? floor(Carbon\Carbon::parse($d->CarMaster->TMInvoiceDate)->diffInDays()) : '-'}}</td>
                                                        <td>{{$d->CarMaster->EmissionNorm}}</td>
                                                        <td>
                                                            @if (!$d->DateOfReceive && in_array(Auth::user()->role_id,['1','6']))
                                                            <a href="receive-stock/{{$d->id}}?status=approve">Approve with note</a>
                                                            @elseif($d->UserApprovedBy)
                                                            {{ucwords($d->UserApprovedBy->name)}}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (!$d->DateOfReceive && in_array(Auth::user()->role_id,['1','6']))
                                                            <a href="receive-stock/{{$d->id}}?status=reject">Reject with note</a>
                                                            @elseif($d->UserRejectedBy)
                                                            {{ucwords($d->UserRejectedBy->name)}}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{$d->DateOfReceive}}
                                                        </td>
                                                        <td>
                                                            @if(in_array(Auth::user()->role_id,['1']))
                                                            <a href="#" class="delete-stock" data-id="{{ $d->id }}" data-bs-toggle="modal" data-bs-target="#inlineForm">Delete</a>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody> */

        $fileName = 'data.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
