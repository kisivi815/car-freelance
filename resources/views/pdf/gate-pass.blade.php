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
                <td>Stock T/F ID</td>
                <td>{{$data->GatePassId}}</td>
            </tr>
            <tr>
                <td>ChasisNo</td>
                <td>{{$data->ChasisNo}}</td>
            </tr>
            <tr>
                <td>Car Name & Model</td>
                <td>{{$data->CarMaster->Model.' '.$data->CarMaster->ProductLine}}</td>
            </tr>
            <tr>
                <td>Colour</td>
                <td>{{$data->CarMaster->Colour}}</td>
            </tr>
            <tr>
                <td>Date of Transfer</td>
                <td>{{$data->DateOfTransfer}}</td>
            </tr>
            <tr>
                <td>Source Branch</td>
                <td>{{$data->Source->name}}</td>
            </tr>
            <tr>
                <td>Destination Branch</td>
                <td>{{$data->Destination->name}}</td>
            </tr>
            <tr>
                <td>Driver Name</td>
                <td>{{$data->DriverName}}</td>
            </tr>
            <tr>
                <td>Sender Name</td>
                <td>{{ucwords($data->UserSendBy->name)}}</td>
            </tr>
            <tr>
                <td>Receiver Name</td>
                <td>{{$data->ReceivedBy ?? '-'}}</td>
            </tr>
        </table>
        <div class="footer">
            <p>Generated on {{ date('Y-m-d h:i:s A') }} IST</p>
        </div>
    </div>
</body>

</html>