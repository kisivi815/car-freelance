<?php

namespace App\Imports;

use App\Models\CarMaster;
use App\Models\CarDetails as ModelsCarDetails;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CarMasterImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        
       $exist = ModelsCarDetails::where('variant',$row['product_line'])->orderBy('id','desc')->first();

       if($exist){
        CarMaster::updateOrCreate(
            ['ChasisNo' => $row['chassis_no']], // Condition to check for existing record
            [
                'ChasisNo' => $row['chassis_no'],
                'Model' => $row['model'],
                'ProductLine' => $row['product_line'],
                'Colour' => $row['chassis_color'],
                'PhysicalStatus' => $row['physical_status'],
                'EnginieNo' => $row['engine_no'],
                'EmissionNorm' => $row['emission_norm'],
                'ManufacturingDate' => $this->dateFormat($row['manufacturing_date']),
                'TMInvoiceDate' => $this->dateFormat($row['tm_invoice_date']),
                'CommercialInvoiceNo' => $row['commercial_invoice'],
                'HSNCode' => $row['hsn_code'],
                'MakersName' => $exist->MakersName,
                'NoOfCylinders' => $exist->NoOfCylinders,
                'CatalyticConverter' => $exist->CatalyticConverter,
                'UnladenWeight' => $exist->UnlandenWeight,
                'SeatingCapaacity' => $exist->SeatingCapacity,
                'FrontAxle' =>  $exist->FrontAxle,
                'RearAxle' => $exist->RearAxle,
                'AnyOtherAxle' => $exist->AnyOtherAxle,
                'TandemAxle' => $exist->TandemAxle,
                'GrossWeight' => $exist->GrossWeight,
                'TypeOfBody' => $exist->TypeOfBody,
                'HorsePower' => null,
                
            ]
        );
       }
        
    }

    private function dateFormat($date){
        $dateField = Date::excelToDateTimeObject($date)->format('Y-m-d');
        return $dateField;
    }
}

