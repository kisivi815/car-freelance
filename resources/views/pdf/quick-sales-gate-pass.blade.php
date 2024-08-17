<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Gate Pass</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            width: 100%;
            border-collapse: collapse;
        }

        .content td,
        .content th {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .content th {
            background-color: #f2f2f2;
        }

        .content td {
            vertical-align: top;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
    <div class="image-container" style="text-align: center; margin-bottom: 20px;">
            <img src="{{ public_path('image/logo.jpeg') }}" alt="image" style="max-width: 50%; height: auto;">
        </div>
        <div class="header">
            <h1>Quick Gate Pass</h1>
        </div>
        <table class="content">
            <tr>
                <td>Sale ID</td>
                <td>{{$data->SalesId}}</td>
            </tr>
            <tr>
                <td>TM Invoice No</td>
                <td>{{$data->TMInvoiceNo}}</td>
            </tr>
            <tr>
                <td>ChasisNo</td>
                <td>{{$data->ChasisNo}}</td>
            </tr>
            <tr>
                <td>Model</td>
                <td>{{$data->CarMaster->Model}}</td>
            </tr>
            <tr>
                <td>Product Line</td>
                <td>{{$data->CarMaster->ProductLine}}</td>
            </tr>
            <tr>
                <td>Colour</td>
                <td>{{$data->CarMaster->Colour}}</td>
            </tr>
            <tr>
                <td>Date of Booking</td>
                <td>{{date('Y-m-d',strtotime($data->DateOfBooking))}}</td>
            </tr>
            <tr>
                <td>Sales Person Name</td>
                <td>{{$data->SalesPersonName}}</td>
            </tr>
            <tr>
                <td>Branch of Sales</td>
                <td>{{$data->SalesBranch->name}}</td>
            </tr>
            <tr>
                <td>Customer Name</td>
                <td>{{$data->CustomerName}}</td>
            </tr>
        </table>
        <div class="footer">
            <p>Generated on {{ date('Y-m-d h:i:s A') }} IST</p>
        </div>
    </div>
</body>

</html>