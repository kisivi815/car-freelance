<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class QuickSalesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ChasisNo' => 'required|string|max:50',
            'DateOfBooking' => 'required|string|max:100',
            'Branch' => 'required|string|max:100',
            'SalesPersonName' => 'required|string|max:100',
            'CustomerMobileNo' => 'required|string|max:100',
            'CustomerName' => 'required|string|max:1000',
        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'errors'=>$validator->errors(),
        ],422));
    }
}
