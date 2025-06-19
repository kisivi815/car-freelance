@php
    function numberToWords($number) {
        // Input validation
        if (!is_numeric($number)) {
            return 'invalid input';
        }

        // Handle negative numbers
        $isNegative = $number < 0;
        $number = abs($number);

        // Define arrays for units, tens, and scales
        $units = [
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
            'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        ];
        $tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
        $scales = ['', 'thousand', 'million', 'billion'];

        // Split integer and decimal parts
        $integerPart = (int)$number;
        $decimalPart = round(($number - $integerPart) * 100); // Two decimal places for cents

        // Initialize words
        $words = '';

        // Handle zero case
        if ($integerPart == 0 && $decimalPart == 0) {
            return 'zero';
        }

        // Convert integer part
        if ($integerPart > 0) {
            $scaleIndex = 0;
            while ($integerPart > 0) {
                $chunk = $integerPart % 1000;
                if ($chunk > 0) {
                    $chunkWords = convertChunk($chunk, $units, $tens);
                    $words = $chunkWords . ' ' . $scales[$scaleIndex] . ($words ? ' ' : '') . $words;
                }
                $integerPart = (int)($integerPart / 1000);
                $scaleIndex++;
            }
        }

        // Handle decimal part (cents)
        if ($decimalPart > 0) {
            $words = trim($words);
            $words .= ($words ? ' and ' : '') . convertChunk($decimalPart, $units, $tens) . ' cents';
        }

        // Add negative prefix if applicable
        if ($isNegative) {
            $words = 'negative ' . $words;
        }

        return trim($words);
    }

    function convertChunk($number, $units, $tens) {
        $words = '';

        // Handle hundreds
        if ($number >= 100) {
            $hundreds = (int)($number / 100);
            $words .= $units[$hundreds] . ' hundred';
            $number %= 100;
            $words .= ($number > 0 ? ' ' : '');
        }

        // Handle tens and units
        if ($number >= 20) {
            $tensDigit = (int)($number / 10);
            $words .= $tens[$tensDigit];
            $number %= 10;
            $words .= ($number > 0 ? '-' : '');
        }

        // Handle units (0-19)
        if ($number > 0) {
            $words .= $units[$number];
        }

        return $words;
    }
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        .container {
            width:100%;
            font-weight: bold;
            font-size:15px;
        }

        td,th{
            border: 1px solid black;
        }

        .text-align-center{
            text-align:center;
        }

        .border-top-none{
            border-top: none;
        }

        .signature-section {
            text-align: center;
            vertical-align: middle;
            border-top: none; /* Remove top border */
            border-bottom: none; /* Remove bottom border */
        }
       
    </style>
</head>
<body>
    <div class="container">
        <table style="width:100%;border-collapse: collapse;border: 1px solid black;table-layout: fixed;">
            <tr>
                <td colspan="16" style="text-align:center;font-size:24px;font-weight:bold;">
                    JP Motors</br>
                    Vill- Anji, PO- Barog, Tehsil & Distt -Solan, HP ,173211</br>
                    Tel: +1792 -228396</br>
                    GSTIN: 02ABXPS6968D1ZI</br>
                </td>
            </tr>
            <tr>
                <td colspan="16" style="text-align:center;font-size:34px;font-weight:bold;border-top: 1px solid black;">
                    Tax Invoice
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Invoice No:
                </td>
                <td colspan="6" class="text-align-center">
                    {{$invoice->InvoiceNo}}
                </td>
                <td colspan="2">
                    Transport Mode:
                </td>
                <td colspan="6" class="text-align-center">
                    NA
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Invoice Date:
                </td>
                <td colspan="6" class="text-align-center">
                    {{date('Y-m-d', strtotime($invoice->InvoiceDate))}}
                </td>
                <td colspan="2">
                    Vehicle number:
                </td>
                <td colspan="6" class="text-align-center">
                    {{$invoice->transferStock->VehicleNo}}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    SO NO:
                </td>
                <td colspan="5" class="text-align-center">
                    IJPMSL2425002090
                </td>
                <td colspan="1" class="text-align-center">
                    NO
                </td>
                <td colspan="2">
                    Date of Supply:
                </td>
                <td colspan="6" class="text-align-center">
                    01.04.2025
                </td>
            </tr>
            <tr>
                <td style="width:10px;">
                    State:
                </td>
                <td style="width:10px;" class="text-align-center">
                    HP
                </td>
                <td>
                    &nbsp;
                </td>
                <td colspan="3" class="text-align-center">
                    DISTT:- {{$invoice->transferStock->DestinationBranch}}
                </td>
                <td class="text-align-center">
                    Code
                </td>
                <td class="text-align-center">
                    02
                </td>
                <td colspan="2">
                    Place of Supply:
                </td>
                <td colspan="6" class="text-align-center">
                    HIMACHAL PRADESH
                </td>
            </tr>
            <tr>
                <td colspan="8" class="text-align-center">
                    Bill to Party
                </td>
                <td colspan="2">
                    Chasis Number:-
                </td>
                <td colspan="6" class="text-align-center">
                    {{$invoice->ChasisNo}}
                </td>
            </tr>
            <tr>
                <td >
                    Name:
                </td>
                <td colspan="7"class="text-align-center">
                    {{$invoice->Saluation}}. {{$invoice->FirstName}} {{$invoice->LastName}} S/O {{$invoice->FathersName}}
                </td>
                <td  colspan="2">
                    Engine Number:-
                </td>
                <td colspan="6" class="text-align-center">
                    {{$invoice->carMaster->EngineNo}}
                </td>
            </tr>
            <tr>
                <td colspan="2" rowspan="5">
                    Address:
                </td>
                <td colspan="6" rowspan="5" class="text-align-center">
                    {{$invoice->PermanentAddress}}
                </td>
                <td>
                    Model:-
                </td>
                <td>
                    &nbsp;
                </td>
                <td colspan="6" class="text-align-center">
                   {{$invoice->carMaster->Model}} {{$invoice->carMaster->ProductLine}}
                </td>
            </tr>
            <tr>
                <td>
                    Colour:-
                </td>
                <td>
                    &nbsp;
                </td>
                <td colspan="6" class="text-align-center">
                    {{$invoice->carMaster->Colour}}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Emission Norm:
                </td>
                <td colspan="6" class="text-align-center">
                    {{$invoice->carMaster->EmissionNorm}}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Type of Fuel:-
                </td>
                <td colspan="6" class="text-align-center">
                    {{$invoice->carMaster->TypeOfFuel}}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Hypo:-
                </td>
                <td colspan="6" class="text-align-center">
                    {{$invoice->Bank}}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    PAN:
                </td>
                <td colspan="6" class="text-align-center">
                    {{$invoice->PAN}}
                </td>
                <td colspan="8" rowspan="3">
                   &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    GSTIN:
                </td>
                <td colspan="6" class="text-align-center">
                    {{$invoice->GST}}
                </td>
            </tr>
            <tr>
                <td>
                    State:
                </td>
                <td class="text-align-center">
                    HP
                </td>
                <td colspan="4">
                    &nbsp;
                </td>
                <td class="text-align-center">
                    Code
                </td>
                <td class="text-align-center">
                    02
                </td>
            </tr>
            <thead>
                <tr>
                    <th rowspan="2" class="text-align-center">S. No.</th>
                    <th rowspan="2" style="font-size:13px">Product Description</th>
                    <th rowspan="2" class="text-align-center">HSN code</th>
                    <th rowspan="2" class="text-align-center">UOM</th>
                    <th rowspan="2" class="text-align-center">Qty</th>
                    <th rowspan="2" class="text-align-center">Rate</th>
                    <th rowspan="2" class="text-align-center">Amount</th>
                    <th rowspan="2" class="text-align-center">Discount</th>
                    <th rowspan="2" class="text-align-center">Taxable Value</th>
                    <th colspan="2" class="text-align-center">CGST</th>
                    <th colspan="2" class="text-align-center">SGST</th>
                    <th colspan="2" class="text-align-center">Cess</th>
                    <th rowspan="2" class="text-align-center">Total</th>
                </tr>
                <tr>
                    <th class="text-align-center">Rate</th>
                    <th class="text-align-center">Amount</th>
                    <th class="text-align-center">Rate</th>
                    <th class="text-align-center">Amount</th>
                    <th class="text-align-center">Rate</th>
                    <th class="text-align-center">Amount</th>
                </tr>
            </thead>
            <tr>
                <td class="text-align-center">1</td>
                <td style="font-size:13px">{{$invoice->carMaster->Model}} {{$invoice->carMaster->ProductLine}}</td>
                <td class="text-align-center">{{$invoice->carMaster->HSNCode}}</td>
                <td class="text-align-center">No.</td>
                <td class="text-align-center">1</td>
                <td class="text-align-center">{{$rateDetails['Rate']}}</td>
                <td class="text-align-center">{{$rateDetails['Rate']}}</td>
                <td class="text-align-center">{{$rateDetails['Discount'] ?? 0}}</td>
                <td class="text-align-center">{{$rateDetails['Rate']}}</td>
                <td class="text-align-center">{{$rateDetails['Taxes_CGST']}}</td>
                <td class="text-align-center">{{$rateDetails['CGST']}}</td>
                <td class="text-align-center">{{$rateDetails['Taxes_SGST']}}</td>
                <td class="text-align-center">{{$rateDetails['SGST']}}</td>
                <td class="text-align-center">{{$rateDetails['Taxes_CESS']}}</td>
                <td class="text-align-center">{{$rateDetails['CESS']}}</td>
                <td class="text-align-center">{{$rateDetails['Total']}}</td>
            </tr>
            <tr>
                <td colspan="9" class="text-align-center">Total</td>
                <td class="text-align-center"></td>
                <td class="text-align-center">{{$rateDetails['CGST']}}</td>
                <td class="text-align-center"></td>
                <td class="text-align-center">{{$rateDetails['SGST']}}</td>
                <td class="text-align-center"></td>
                <td class="text-align-center">{{$rateDetails['CESS']}}</td>
                <td class="text-align-center">{{$rateDetails['Total']}}</td>
            </tr>
            <tr>
                <td colspan="9">
                    Total Invoice amount in words
                </td>
                <td colspan="6">
                    Total Amount before Tax
                </td>
                <td>
                    {{$rateDetails['Amount']}}
                </td>
            </tr>
            <tr>
                <td colspan="9" rowspan="4" class="text-align-center">
                    {{numberToWords($rateDetails['Total'])}}
                </td>
                <td colspan="6" class="text-align-center">
                    Add: CGST
                </td>
                <td class="text-align-center">
                   {{$rateDetails['CGST']}}
                </td>
            </tr>
            <tr>
                <td colspan="6" class="text-align-center">
                    Add: SGST
                </td>
                <td class="text-align-center">
                    {{$rateDetails['SGST']}}
                </td>
            </tr>
            <tr>
                <td colspan="6" class="text-align-center">
                    ADD: Cess
                </td>
                <td class="text-align-center">
                    {{$rateDetails['IGST']}}
                </td>
            </tr>
            <tr>
                <td colspan="6" class="text-align-center">
                    Total Tax Amount
                </td>
                <td class="text-align-center">
                    {{$rateDetails['CGST'] + $rateDetails['SGST'] + $rateDetails['CESS']}}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-align-center">
                    Bank Details
                </td>
                <td colspan="5" class="text-align-center">
                    SBI BANK , The Mall, Solan HP 173212
                </td>
                <td colspan="6" class="text-align-center">
                    Total Amount after Tax:
                </td>
                <td class="text-align-center">
                    {{$rateDetails['Total']}}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-align-center">
                    Bank A/C:
                </td>
                <td colspan="5" class="text-align-center">
                    32076199328
                </td>
                <td colspan="6" class="text-align-center">
                    TCS AMOUNT
                </td>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-align-center">
                    Bank IFSC: 
                </td>
                <td colspan="5" class="text-align-center">
                    SBIN0050127
                </td>
                <td colspan="6" class="text-align-center">
                    TOTAL
                </td>
                <td class="text-align-center">
                    {{$rateDetails['Total']}}
                </td>
            </tr>
            <tr>
                <td colspan="9" rowspan="6">
                    <strong>Terms & conditions</strong>
                    <ol>
                        <li>The vehicle is supplied with the normal warranty given by the manufacturer, and no warranty or guarantee other than that given by the manufacturer shall be applicable to this purchase.</li>
                        <li>All kinds of disputes will be settled under Solan jurisdiction only.</li>
                        <li>Prices prevailing at the time of delivery shall be applicable.</li>
                        <li>Goods once sold will not be returned.</li>
                        <li>Interest @ 18% p.a. will be charged for delayed payments.</li>
                    </ol>
                </td>
                <td colspan="7" class="text-align-center" style="height: 5px;font-size: 13px;">
                    Certified that the particulars given above are true and correct
                </td>
            </tr>
            <tr>
                <td colspan="7" class="text-align-center">
                    For JP Motors
                </td>
            </tr>
            <tr>
                <td colspan="7" class="text-align-center signature-section">
                &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="7" class="text-align-center signature-section">
                &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="7" class="text-align-center signature-section">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="7" class="signature-section" style="vertical-align: bottom; text-align: center;">
                    Authorised Signatory
                </td>
            </tr>
        </table>
    </div>
</body>
</html>