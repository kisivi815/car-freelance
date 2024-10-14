<?php
namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogService
{
    public static function insertlog($affected_id, $action, $log_message, $module)
    {
        $user = Auth::user();
        Log::create(['user_id'=>$user->id ,'affected_id'=>$affected_id, 'action' => $action, 'log_message' => $log_message,'module' => $module]);
        return true;
    }
}
