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

class CarDetailsImport implements OnEachRow, WithHeadingRow, WithChunkReading
{

    private $carDetailsProcessedCount = 0;
    private $carMasterProcessedCount = 0;
    private $carDetailsFailedCount = 0;
    private $carMasterFailedCount = 0;
    private $rowNumber = [];
    private $updatedChasisNumber = [];

    public function __construct()
    {
    }

    /**
     * @param array $row
     * @param int $rowNumber
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function onRow(Row $dataRow)
    {
        try {
            $rowNumber = $dataRow->getIndex();
            $row = $dataRow->toArray();
            $carDetailsInsert = $this->carDetailsInsert($row, $rowNumber);
            if ($carDetailsInsert) {
                // Fetch the existing car details based on the variant
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
        if ($date) {
            return Date::excelToDateTimeObject($date)->format('Y-m-d');
        }
        return null;
    }

    public function getCounts()
    {
        return [
            'carDetailsProcessedCount' => $this->carDetailsProcessedCount,
            'carMasterProcessedCount' => $this->carMasterProcessedCount,
            'carDetailsFailedCount' => $this->carDetailsFailedCount,
            'carMasterFailedCount' => $this->carMasterFailedCount,
            'rowNumber' => $this->rowNumber,
            'updatedChasisNumber' => $this->updatedChasisNumber
        ];
    }

    private function carDetailsInsert($row, $rowNumber)
    {
        try {
            $active = 1;
            ModelsCarDetails::where('variant', $row['variant'])->update(['active'=>'0','updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);

            $ModelsCarDetails = ModelsCarDetails::create([
                'PPL' => $row['ppl'],
                'Fuel' => $row['fuel'],
                'Variant' => $row['variant'],
                'EmissionNorm' => $row['emission_norm'],
                'MakersName' => $row['makers_name'],
                'HSNCode' => $row['hsn_code'],
                'NoOfCylinders' => $row['no_of_cyclinders'],
                'SeatingCapacity' => $row['seating_capacity'],
                'CatalyticConverter' => $row['catalytic_converter'],
                'UnladenWeight' => $row['unladen_weight'],
                'FrontAxle' => $row['front_axle_wtkg'],
                'RearAxle' => $row['rear_axle_wtkg'],
                'AnyOtherAxle' => $row['any_other_axel_wtkg'],
                'TandemAxle' => $row['tandem_axle_wtkg'],
                'GrossWeight' => $row['gross_weight'],
                'TypeOfBody' => $row['type_of_body'],
                'active' => $active

            ]);

            if ($ModelsCarDetails) {
                $this->carDetailsProcessedCount++;
                return true;
            } else {
                $this->rowNumber[] = $rowNumber;
                $this->carDetailsFailedCount++;
                return false;
            }
        } catch (\Exception $e) {
            $this->rowNumber[] = $rowNumber;
            $this->carDetailsFailedCount++;
            Log::error("Failed to process row: " . json_encode($row) . ". Error: " . $e->getMessage());
            return false;
        }
        return false;
    }

    private function carMasterUpdateInsert($row)
    {
        try {
            $data = ModelsCarDetails::where('variant', $row['variant'])->where('active', '1')->orderBy('id', 'desc')->first();

            if(!$data){
                return false;
            }

            $cardetails = [
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

            $existingCarMaster = CarMaster::where('ProductLine', $data->Variant)
            ->where('PhysicalStatus', '!=', 'Sold')
            ->where('active', '1')
            ->first();

            if ($existingCarMaster) {
                // Update the existing record
                $carExist = Car::where('ChasisNo', $existingCarMaster->ChasisNo)->where('active', '1')->orderBy('ID', 'desc')->first();
                if($carExist){
                    $updatedRow = $existingCarMaster->update($cardetails);
                }
            }

            if ((isset($updatedRow) && $updatedRow)) {
                $this->carMasterProcessedCount += $updatedRow;
                $this->updatedChasisNumber[] = $existingCarMaster->ChasisNo;
            }
  
        } catch (\Exception $e) {
            $this->carDetailsFailedCount++;
            Log::error("Failed to process row: " . json_encode($data) . ". Error: " . $e->getMessage());
        }
    }

    public function chunkSize(): int
    {
        return 10000;
    }
}
