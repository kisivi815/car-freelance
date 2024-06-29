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

class CarMasterImport implements OnEachRow, WithHeadingRow, WithChunkReading
{

    private $carProcessedCount = 0;
    private $carMasterProcessedCount = 0;
    private $carFailedCount = 0;
    private $carMasterFailedCount = 0;
    private $rowNumber = [];
    private $missingDetails = [];

    public function __construct()
    {
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
                $exist = ModelsCarDetails::where('variant', $row['product_line'])->where('active', '1')->orderBy('id', 'desc')->first();

                if ($exist) {
                    $this->carMasterUpdateInsert($row, $exist);
                } else {
                    $this->carMasterFailedCount++;
                    $this->missingDetails[] = $row['chassis_no'];
                }
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
        if ($date) {
            return Date::excelToDateTimeObject($date)->format('Y-m-d');
        }
        return null;
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
                'active' => $row['active'],
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

    private function carMasterUpdateInsert($rowData, $data)
    {
        try {
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
                'MakersName' => $data->MakersName,
                'NoOfCylinders' => $data->NoOfCylinders,
                'CatalyticConverter' => $data->CatalyticConverter,
                'UnladenWeight' => $data->UnladenWeight,
                'SeatingCapacity' => $data->SeatingCapacity,
                'FrontAxle' => $data->FrontAxle,
                'RearAxle' => $data->RearAxle,
                'AnyOtherAxle' => $data->AnyOtherAxle,
                'TandemAxle' => $data->TandemAxle,
                'GrossWeight' => $data->GrossWeight,
                'TypeOfBody' => $data->TypeOfBody,
                'TypeOfFuel' => $data->Fuel,
                'HorsePower' => null,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];
            

            // Check if a record exists with the given conditions

            if($rowData['physical_status'] != 'Sold'){

                $existingCarMaster = CarMaster::where('ChasisNo', $rowData['chassis_no'])
                ->where('PhysicalStatus', '!=', 'Sold')
                ->where('active', '1')
                ->first();

                if ($existingCarMaster) {
                    // Update the existing record
                    $existingCarMaster->update($queryArray);
                } else {
                    // Create a new record if no existing record is found
                    $carMaster = CarMaster::create($queryArray);
                }

                if ((isset($carMaster) && $carMaster) || (isset($existingCarMaster) && $existingCarMaster)) {
                    $this->carMasterProcessedCount++;
                } else {
                    $this->missingDetails[] = $rowData['chassis_no'];
                    $this->carMasterFailedCount++;
                }
            }
           


            
        } catch (\Exception $e) {
            $this->carMasterFailedCount++;
            Log::error("Failed to process row: " . json_encode($data) . ". Error: " . $e->getMessage());
        }
    }

    public function chunkSize(): int
    {
        return 10000;
    }
}
