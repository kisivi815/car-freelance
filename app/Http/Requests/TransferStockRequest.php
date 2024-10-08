<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransferStockRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ChasisNo' => 'required|string|max:50',
            'MileageSend' => 'required|numeric',
            'SourceBranch' => 'required|string|max:100',
            'DestinationBranch' => 'required|string|max:100',
            'DriverName' => 'required|string|max:100',
            'Note' => 'nullable|string|max:1000',
            'VehicleAmt' =>'required',
            'VehicleNo' =>'required'
        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'errors'=>$validator->errors(),
        ],422));
    }
}
