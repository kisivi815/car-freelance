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
            'Email' => 'nullable|email|max:50',

            // Aadhar: 16-digit number
            'Aadhar' => ['nullable', 'regex:/^\d{16}$/'],

            // PAN: 5 uppercase letters, 4 digits, 1 uppercase letter
            'PAN' => ['nullable', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],

            // GSTIN: 15 characters — 2 digits (state code) + 10 characters (PAN) + 1 character (entity number) + 1 character (Z) + 1 check digit
            'GST' => ['nullable', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/'],

            'PermanentAddress' => 'nullable|string|max:500',
            'TemporaryAddress' => 'nullable|string|max:500',
            'ChasisNo' => 'nullable|string|max:50',
            'Bank' => 'nullable|string|max:50',
            'InsuranceName' => 'nullable|string|max:50',
            'Discount' => 'nullable|string|max:50',
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
