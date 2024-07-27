<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubmitSalesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Mobile' => 'required|string|max:50',
            'Saluation' => 'required|string|max:50',
            'FirstName' => 'required|string|max:50',
            'LastName' => 'required|string|max:50',
            'FathersName' => 'nullable|string|max:50',
            'Email' => 'nullable|string|max:50',
            'Aadhar' => 'nullable|string|max:50',
            'PAN' => 'nullable|string|max:50',
            'GST' => 'nullable|string|max:50',
            'PermanentAddress' => 'nullable|string|max:500',
            'TemporaryAddress' => 'nullable|string|max:500',
            'ChasisNo' => 'nullable|string|max:50',
            'Bank' => 'nullable|string|max:50',
            'InsuranceName' => 'nullable|string|max:50',
            'DiscountType' => 'nullable|string|max:50',
            'Accessories' => 'nullable|string|max:50',
            'TypeofGST' => 'nullable|string|max:50',
        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'errors'=>$validator->errors(),
        ],422));
    }
}
