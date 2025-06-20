<?php

namespace App\Imports;

use App\Models\Car;
use App\Models\CarMaster;
use App\Models\CarDetails as ModelsCarDetails;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\PhysicalStatus;
use App\Services\CarMasterStatusService;

class CarMasterImport implements OnEachRow, WithHeadingRow, WithChunkReading
{

    private $carProcessedCount = 0;
    private $carMasterProcessedCount = 0;
    private $carFailedCount = 0;
    private $carMasterFailedCount = 0;
    private $rowNumber = [];
    private $missingDetails = [];
    private $phyicalStatus;

    public function __construct()
    {
        $this->phyicalStatus = PhysicalStatus::pluck('name')->toArray();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function onRow(Row $dataRow)
    {
        try {
            $rowNumber = $dataRow->getIndex();
            $row = $dataRow->toArray();
            $carInsert=$this->carInsert($row, $rowNumber);
            if($carInsert){
                $this->carMasterUpdateInsert($row);
            }

        } catch (\Exception $e) {
            Log::error("Failed to process row: " . json_encode($row) . ". Error: " . $e->getMessage());
        }
    }

    /**
     * Format the date from Excel format to Y-m-d.
     *
     * @param mixed $date
     * @return string|null
     */
    private function dateFormat($date)
{
    // Return null if date is empty or null
    if (empty($date)) {
        return null;
    }

    try {
        // Check if the input is numeric (Excel serial date)
        if (is_numeric($date)) {
            return Date::excelToDateTimeObject($date)->format('Y-m-d');
        }

        // Try parsing as d/m/Y
        $carbonDate = Carbon::createFromFormat('d/m/Y', $date);
        if ($carbonDate && $carbonDate->format('d/m/Y') === $date) {
            return $carbonDate->format('Y-m-d');
        }

        // Return null if the date doesn't match d/m/Y format
        return null;
    } catch (\Exception $e) {
        // Log the error for debugging (optional)
        \Log::error("Date format error for input '$date': " . $e->getMessage());
        return null;
    }
}

    public function getCounts()
    {
        return [
            'carProcessedCount' => $this->carProcessedCount,
            'carFailedCount' => $this->carFailedCount,
            'carMasterProcessedCount' => $this->carMasterProcessedCount,
            'carMasterFailedCount' => $this->carMasterFailedCount
        ];
    }

    public function getMissingDetails()
    {
        return $this->missingDetails;
    }

    private function carInsert($row, $rowNumber)
    {
        try {
            $active = 1;
            Car::where('ChasisNo',$row['chassis_no'])->update(['active'=>'0','updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);

            $car = Car::create([
                'ChasisNo' => $row['chassis_no'],
                'Model' => $row['model'],
                'ProductLine' => $row['product_line'],
                'Colour' => $row['chassis_color'],
                'PhysicalStatus' => $row['physical_status'],
                'EngineNo' => $row['engine_no'],
                'EmissionNorm' => $row['emission_norm'],
                'ManufacturingDate' => $this->dateFormat($row['manufacturing_date']),
                'TMInvoiceDate' => $this->dateFormat($row['tm_invoice_date']),
                'CommercialInvoiceNo' => $row['commercial_invoice'],
                'HSNCode' => $row['hsn_code'],
                'active' => $active,
            ]);

            if ($car) {
                $this->carProcessedCount++;
                return true;
            } else {
                $this->rowNumber[] = $rowNumber;
                $this->carFailedCount++;
                return false;
            }
        } catch (\Exception $e) {
            $this->rowNumber[] = $rowNumber;
            $this->carFailedCount++;
            Log::error("Failed to process row: " . json_encode($row) . ". Error: " . $e->getMessage());
            return false;
        }
        return false;
    }

    private function carMasterUpdateInsert($rowData)
    {
        try {

            $carDetailsExist = ModelsCarDetails::where('variant', $rowData['product_line'])->where('active','1')->orderBy('id', 'desc')->first();
            $carExist = Car::where('ChasisNo',$rowData['chassis_no'])->where('active', '1')->orderBy('ID','desc')->first();

            if($rowData['dealer_purchase_order_price']){
                $rowData['dealer_purchase_order_price'] = str_replace(',', '', $rowData['dealer_purchase_order_price']);
                $rowData['dealer_purchase_order_price'] = str_replace('Rs.', '', $rowData['dealer_purchase_order_price']);
            }

            if($carExist){
                $queryArray = [
                    'ChasisNo' => $rowData['chassis_no'],
                    'Model' => $rowData['model'],
                    'ProductLine' => $rowData['product_line'],
                    'Colour' => $rowData['chassis_color'],
                    'PhysicalStatus' => $rowData['physical_status'],
                    'EngineNo' => $rowData['engine_no'],
                    'EmissionNorm' => $rowData['emission_norm'],
                    'ManufacturingDate' => $this->dateFormat($rowData['manufacturing_date']),
                    'TMInvoiceDate' => $this->dateFormat($rowData['tm_invoice_date']),
                    'CommercialInvoiceNo' => $rowData['commercial_invoice'],
                    'HSNCode' => $rowData['hsn_code'],
                    'Amount' => $rowData['dealer_purchase_order_price'],
                    'HorsePower' => null,
                    'active' => '1',
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ];
               
                if($carDetailsExist){
                   $carDetails = [
                        'MakersName' => $carDetailsExist->MakersName,
                        'NoOfCylinders' => $carDetailsExist->NoOfCylinders,
                        'CatalyticConverter' => $carDetailsExist->CatalyticConverter,
                        'UnladenWeight' => $carDetailsExist->UnladenWeight,
                        'SeatingCapacity' => $carDetailsExist->SeatingCapacity,
                        'FrontAxle' => $carDetailsExist->FrontAxle,
                        'RearAxle' => $carDetailsExist->RearAxle,
                        'AnyOtherAxle' => $carDetailsExist->AnyOtherAxle,
                        'TandemAxle' => $carDetailsExist->TandemAxle,
                        'GrossWeight' => $carDetailsExist->GrossWeight,
                        'TypeOfBody' => $carDetailsExist->TypeOfBody,
                        'TypeOfFuel' => $carDetailsExist->Fuel,
                   ];
    
                  $queryArray = array_merge($queryArray,$carDetails);
                }

                // Check if a record exists with the given conditions
    

                    $existingCarMaster = CarMaster::where('ChasisNo', $rowData['chassis_no'])
                    ->where(function($query){
                        $query->whereNotIn('PhysicalStatus',$this->phyicalStatus)->orWhereNull('PhysicalStatus');
                    })
                    ->where('active', '1')
                    ->first();

                    if ($existingCarMaster) {
                        // Update the existing record
                        $existingCarMaster->update($queryArray);
                        CarMasterStatusService::insertStatus($queryArray['ChasisNo'],$queryArray['PhysicalStatus']);
                    } else {
                        $existingSystemCarMaster = CarMaster::where('ChasisNo', $rowData['chassis_no'])
                        ->whereIn('PhysicalStatus',$this->phyicalStatus)
                        ->where('active', '1')
                        ->first();

                        if(!$existingSystemCarMaster){
                            // Create a new record if no existing record is found
                            $carMaster = CarMaster::create($queryArray);
                            CarMasterStatusService::insertStatus($queryArray['ChasisNo'],$queryArray['PhysicalStatus']);
                        }
                    }
    
                    if ((isset($carMaster) && $carMaster) || (isset($existingCarMaster) && $existingCarMaster)) {
                        $this->carMasterProcessedCount++;
                    }
                
            }
           
        } catch (\Exception $e) {
            $this->carMasterFailedCount++;
            Log::error("Failed to process row: " . json_encode($rowData) . ". Error: " . $e->getMessage());
        }
    }

    public function chunkSize(): int
    {
        return 10000;
    }
}
