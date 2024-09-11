<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\QuickSales;

class SalesMobileNoCheck implements Rule
{
    public function passes($attribute, $value)
    {
        return !QuickSales::where('ChasisNo', request()->input('ChasisNo'))->where('CustomerMobileNo', $value)->exists();
    }

    public function message()
    {
        return 'Mobile No already exists in this chasis number. Please enter a different mobile no.';
    }
}



