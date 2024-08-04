<?php
namespace App\Services;

use App\Models\CarMasterStatus;

class CarMasterStatusService
{
    public static function insertStatus($chassisNo, $status)
    {
        $insertData['ChasisNo']=$chassisNo;
        $insertData['status']=$status;

        $exist = CarMasterStatus::where('ChasisNo', $chassisNo)->orderBy('id', 'desc')->first();
        if (!$exist || $exist->status != $status) {
            CarMasterStatus::create($insertData);
        }
        return true;
    }
}
