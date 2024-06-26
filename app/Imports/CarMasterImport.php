<?php

namespace App\Imports;

use App\Models\CarMaster;
use App\Models\CarDetails as ModelsCarDetails;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CarMasterImport implements ToModel, WithHeadingRow
{

    protected $missingDetails;

    public function __construct(array &$missingDetails)
    {
        $this->missingDetails = &$missingDetails;
    }
    
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        
        // Fetch the existing car details based on the variant
        $exist = ModelsCarDetails::where('variant', $row['product_line'])->orderBy('id', 'desc')->first();

        // Prepare the query array based on whether the existing car details were found
        $queryArray = [
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
        ];

        // If existing car details are found, merge additional data
        if ($exist) {
            $additionalData = [
                'MakersName' => $exist->MakersName,
                'NoOfCylinders' => $exist->NoOfCylinders,
                'CatalyticConverter' => $exist->CatalyticConverter,
                'UnladenWeight' => $exist->UnladenWeight,
                'SeatingCapacity' => $exist->SeatingCapacity,
                'FrontAxle' => $exist->FrontAxle,
                'RearAxle' => $exist->RearAxle,
                'AnyOtherAxle' => $exist->AnyOtherAxle,
                'TandemAxle' => $exist->TandemAxle,
                'GrossWeight' => $exist->GrossWeight,
                'TypeOfBody' => $exist->TypeOfBody,
                'TypeOfFuel' => $exist->Fuel,
                'HorsePower' => null,
            ];
            $queryArray = array_merge($queryArray, $additionalData);
        }else{
            $this->missingDetails[] = $row['chassis_no'];
        }

        // Update or create the CarMaster record based on multiple conditions
        CarMaster::updateOrCreate(
            [
                'ChasisNo' => $row['chassis_no'],
            ],
            $queryArray
        );
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
}