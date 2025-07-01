<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        .container {
            width: 100%;
            font-size:19px;
            font-weight: bold;
        }
        td{
            padding:5px 0 5px 0;
            vertical-align: top;
        }
        .value{
            padding-left:200px;
            width: 500px;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <table style = 'border: 1px solid black; border-collapse: collapse; width: 100%;'>
            <tr>
                <td colspan="4" style="text-align: center; font-size: 20px; font-weight: bold;">Form 21 ( see rule 47( a ) & ( d ) )</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center; font-size: 20px; font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">Sale Certificate</td>
            </tr>
            <tr>
                <td colspan="2" style="width:800px;">Sale Certificate No.: {{ $invoice->InvoiceNo }} </td>
                <td colspan="2" style="width:20%;">Date: {{date('d.m.Y', strtotime($invoice->DateOfSales))}}</td>
            </tr>
            <tr>
                <td colspan="4">
                Certified that {{ $invoice->carMaster->Model }} {{ $invoice->carMaster->ProductLine }} {{ $invoice->carMaster->EmissionNorm }} , {{ $invoice->carMaster->Colour }} has been deliverd by us to {{ $invoice->Saluation }}.{{ $invoice->FirstName }} {{ $invoice->LastName }} on {{ date('d.m.Y', strtotime($invoice->DateOfSales)) }}.
                </td>
            </tr>
            <tr>
                <td colspan="2" style="">Name of the buyer  {{ $invoice->Saluation }}.{{ $invoice->FirstName }}</td>
                <td colspan="2" style="">SO NO: IJPMSL2425002090</td>
            </tr>
            <tr>
                <td colspan="4">Son/Wife/Daughter of  S/O {{ $invoice->Saluation }}.{{ $invoice->FirstName }} {{ $invoice->LastName }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;width:10%;">Permanent Address:</td>
                <td style="vertical-align: top;">{{ $invoice->PermanentAddress }}</td>
                <td style="vertical-align: top;width:10%;">Temporay Address:</td>
                <td style="vertical-align: top;padding-bottom: 150px;">{{ $invoice->TemporaryAddress }}</td>
            </tr>
            <tr>
                <td colspan="4" style="padding-bottom: 50px;">
                    <table>
                        <tr>
                            <td style="width:350px;">Phone: {{$invoice->Mobile}}</td>
                            <td style="width:350px;">Fax: -</td>
                            <td style="width:350px;">E-mail: {{$invoice->Email}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-bottom:30px;">
                    The vehicle is held under agreement of Hire Purchase / Lease / Hypothecation with:- <br>
                    {{ $invoice->bank }}
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;padding-bottom:30px;">
                    The details of the vehicle are given below
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding:0 100px 100px 100px;">
                    <table >
                        <tr>
                            <td>1)</td>
                            <td>Class Of the Vehicle</td>
                            <td class="value">CAR</td>
                        </tr>
                        <tr>
                            <td>2)</td>
                            <td>Maker's Name</td>
                            <td class="value">{{$invoice->carMaster->MakersName}}</td>
                        </tr>
                        <tr>
                            <td>3)</td>
                            <td>Chassis Number</td>
                            <td class="value">{{$invoice->ChasisNo}}</td>
                        </tr>
                        <tr>
                            <td>4)</td>
                            <td>Engine Number</td>
                            <td class="value">{{$invoice->carMaster->EngineNo}}</td>
                        </tr>
                        <tr>
                            <td>5)</td>
                            <td>Horse Power or Cubic Capacity</td>
                            <td class="value">{{$invoice->carMaster->HorsePower ? $invoice->carMaster->HorsePower.'CC' : ''}} </td>
                        </tr>
                        <tr>
                            <td>6)</td>
                            <td>Fuel Used</td>
                            <td class="value">{{$invoice->carMaster->TypeOfFuel}}</td>
                        </tr>
                        <tr>
                            <td>7)</td>
                            <td>No. Of Cylinders</td>
                            <td class="value">{{$invoice->carMaster->NoOfCylinders}}</td>
                        </tr>
                        <tr>
                            <td>8)</td>
                            <td style="width:300px;">Month and Year of Manufacture</td>
                            <td class="value">{{date(date('d.m.Y'),$invoice->carMaster->ManafacturingDate)}}</td>
                        </tr>
                        <tr>
                            <td>9)</td>
                            <td>Seating Capacity ( incl. driver )</td>
                            <td class="value">{{$invoice->carMaster->SeatingCapacity}}</td>
                        </tr>
                        <tr>
                            <td>10)</td>
                            <td>Unladen Weight ( Kg )</td>
                            <td class="value">{{$invoice->carMaster->UnladenWeight}}</td>
                        </tr>
                        <tr>
                            <td colspan="3">11) Maximum axle weight and description of tyre ( in case of transport vehicles )</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>11a) Front Axle ( Wt / Kg )</td>
                            <td class="value">{{$invoice->carMaster->FrontAxle}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>11b) Rear Axle ( Wt / Kg )</td>
                            <td class="value">{{$invoice->carMaster->RearAxle}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>11c) Any Other Axle ( Wt / Kg )</td>
                            <td class="value">{{$invoice->carMaster->AnyOtherAxle}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>11d) Tandem Axle ( Wt / Kg )</td>
                            <td class="value">{{$invoice->carMaster->TandemAxle}}</td>
                        </tr>
                        <tr>
                            <td>12)</td>
                            <td>Colour</td>
                            <td class="value">{{$invoice->carMaster->Colour}}</td>
                        </tr>
                        <tr>
                            <td>13)</td>
                            <td>Gross Weight ( Kg )</td>
                            <td class="value">{{$invoice->carMaster->GrossWeight}}</td>
                        </tr>
                        <tr>
                            <td>14)</td>
                            <td>Type of Body</td>
                            <td class="value">{{$invoice->carMaster->TypeOfBody}}</td>
                        </tr>
                        <tr>
                            <td>15)</td>
                            <td>Catalytic Connverter</td>
                            <td class="value">{{$invoice->carMaster->CatalyticConverter}}</td>
                        </tr>
                        <tr>
                            <td>16)</td>
                            <td>Manufacture's invoice number</td>
                            <td class="value">{{$invoice->carMaster->CommercialInvoiceNo}}/{{date('d.m.Y',strtotime($invoice->carMaster->TMInvoiceDate))}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right;">
                    For J . P.  MOTORS
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    GSTIN: 02ABXPS6968D1ZI
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align:right;">
                    Authorised signatory
                </td>
            </tr>
        </table>
    </div>
</body>
</html>