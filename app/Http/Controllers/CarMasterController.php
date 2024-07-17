<?php

namespace App\Http\Controllers;

use App\Events\ImportCompleted;
use App\Imports\CarDetailsImport;
use App\Models\CarDetails;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CarMasterImport;
use App\Models\Car;
use App\Models\CarMaster;
use App\Models\PhysicalStatus;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Exception;
use Illuminate\Support\Facades\Log;

class CarMasterController extends Controller
{

    private $carMasterProcessedCount = 0;
    private $carMasterFailedCount = 0;
    private $updatedChasisNumber = [];
    private $phyicalStatus;

    public function __construct()
    {
        $this->phyicalStatus = PhysicalStatus::pluck('name')->toArray();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Car Master Upload';
        return view('car-master-upload')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            $today = Carbon::today()->format('dmY');
            $message = '';
            $missingDetails = [];

            if ($request->file('file')) {
                $import = new CarMasterImport();
                Excel::import($import, $request->file('file'));
                $counts = $import->getCounts();
                $missingDetail = $import->getMissingDetails();
                $extension = $request->file('file')->getClientOriginalExtension();
                // Get all files from a specific directory (or root directory)
                $allFiles = Storage::disk('s3')->allFiles('car-inventory');

                // Filter files that include the keyword
                $filteredFiles = array_filter($allFiles, function ($filename) use ($today) {
                    return stripos($filename, $today) !== false;
                });

                $version = count($filteredFiles) + 1;
                //$result = Storage::disk('s3')->put("car-inventory/" . $today . "_car_inventory_v" . $version . ".".$extension, file_get_contents($request->file('file')));

                if (count($missingDetail) > 0) {
                    $message .= implode(',', $missingDetail) . '<br> ';
                    $message .= 'not found in product details. <br>';
                }
            }

            $message .= 'Car : ( ' . $counts['carProcessedCount'] . ' row processed / ' . $counts['carFailedCount'] . ' row failed ) <br>';
            $message .= 'Car Master :( ' . $counts['carMasterProcessedCount'] . ' row processed / ' . $counts['carMasterFailedCount'] . ' row failed ) <br>';
            return back()->with('message', 'Data imported successfully. <br>' . $message);
        } catch (Exception $e) {
            return back()->with('error', 'Error occurred while importing data. Please try again later.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function storeCarDetails(Request $request)
    {
        try {

            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            $today = Carbon::today()->format('dmY');
            $message = '';

            if ($request->file('file')) {
                $import = new CarDetailsImport();
                Excel::import($import, $request->file('file'));
                $this->carMasterUpdateInsert();
                $counts = $import->getCounts();

                $extension = $request->file('file')->getClientOriginalExtension();
                // Get all files from a specific directory (or root directory)
                $allFiles = Storage::disk('s3')->allFiles('car-details');

                // Filter files that include the keyword
                $filteredFiles = array_filter($allFiles, function ($filename) use ($today) {
                    return stripos($filename, $today) !== false;
                });

                $version = count($filteredFiles) + 1;
                //$result = Storage::disk('s3')->put("car-details/" . $today . "_car_details_v" . $version . ".".$extension, file_get_contents($request->file('file')));

            }
            if (count($counts['rowNumber']) > 0) {
                $message .= implode(',', $counts['rowNumber']) . '<br> data not correct. <br>';
            }

            $message .= 'Car Details : ( ' . $counts['carDetailsProcessedCount'] . ' row processed / ' . $counts['carDetailsFailedCount'] . ' row failed ) <br>';
            $message .= 'Car Master :( ' . $this->carMasterProcessedCount. ' row processed / ' . $this->carMasterFailedCount . ' row failed ) <br>';

            return back()->with('message', 'Data imported successfully. <br>' . $message);
        } catch (Exception $e) {
            Log::error( "Error: " . $e->getMessage());
            return back()->with('error', 'Error occurred while importing data. Please try again later.');
        }
    }

    private function carMasterUpdateInsert()
    {

        $data = CarDetails::where('active', '1')->orderBy('id', 'desc')->get();

        if (count($data) == 0) {
            return false;
        }

        foreach ($data as $d) {
            try {
                $cardetails = [
                    'MakersName' => $d->MakersName,
                    'NoOfCylinders' => $d->NoOfCylinders,
                    'CatalyticConverter' => $d->CatalyticConverter,
                    'UnladenWeight' => $d->UnladenWeight,
                    'SeatingCapacity' => $d->SeatingCapacity,
                    'FrontAxle' => $d->FrontAxle,
                    'RearAxle' => $d->RearAxle,
                    'AnyOtherAxle' => $d->AnyOtherAxle,
                    'TandemAxle' => $d->TandemAxle,
                    'GrossWeight' => $d->GrossWeight,
                    'TypeOfBody' => $d->TypeOfBody,
                    'TypeOfFuel' => $d->Fuel,
                    'HorsePower' => null,
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ];

                $existingCarMaster = CarMaster::where('ProductLine', $d->Variant)
                    ->where(function($query){
                        $query->whereNotIn('PhysicalStatus',$this->phyicalStatus)->orWhereNull('PhysicalStatus');
                    })
                    ->where('active', '1')
                    ->get();

                if (count($existingCarMaster) > 0) {
                    // Update the existing record
                    $carExist = Car::whereIn('ChasisNo',$existingCarMaster->pluck('ChasisNo'))->where('active', '1')->orderBy('ID', 'desc')->first();
                    if ($carExist) {
                        $updatedRow = CarMaster::where('ProductLine', $d->Variant)
                        ->where('PhysicalStatus', '!=', 'Sold')
                        ->where('active', '1')
                        ->update($cardetails);
                    }

                    if ((isset($updatedRow) && $updatedRow)) {
                        $this->carMasterProcessedCount += $updatedRow;
                        $this->updatedChasisNumber[] = $existingCarMaster->pluck('ChasisNo');
                    }
                }

                
            } catch (\Exception $e) {
                Log::error("Failed to process row: " . json_encode($d) . ". Error: " . $e->getMessage());
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
