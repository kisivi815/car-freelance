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
            <h1>Gate Pass</h1>
        </div>
        <table class="content">
            <tr>
                <td>Sale ID</td>
                <td>{{$data->ID}}</td>
            </tr>
            <tr>
                <td>Customer Name</td>
                <td>{{$data->FirstName .' '. $data->LastName}}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{$data->PermanentAddress}}</td>
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
                <td>HSN Code</td>
                <td>{{$data->CarMaster->HSNCode}}</td>
            </tr>
            <tr>
                <td>Date of Sales</td>
                <td>{{date('Y-m-d',strtotime($data->DateOfSales))}}</td>
            </tr>
            <tr>
                <td>Value</td>
                <td>{{$data->CarMaster->Amount}}</td>
            </tr>
            <tr>
                <td>Seating Capacity</td>
                <td>{{$data->CarMaster->SeatingCapacity}}</td>
            </tr>
            <tr>
                <td>Cubic Capacity</td>
                <td>{{$data->CarMaster->CatalyticConverter}}</td>
            </tr>
            <tr>
                <td>Manufacturing Date</td>
                <td>{{date('Y-m-d',strtotime($data->CarMaster->ManufacturingDate))}}</td>
            </tr>
        </table>
        <div class="footer">
            <p>Generated on {{ date('Y-m-d h:i:s A') }} IST</p>
        </div>
    </div>
</body>

</html>