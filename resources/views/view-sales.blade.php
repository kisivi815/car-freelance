<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.header')
</head>

<body>
    <div id="app">
        @include('layout.navigation')
        <div id="main">
            @include('layout.title')
            <div class="page-content">
                <section class="section">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <!-- table bordered -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Invoice No</th>
                                                        <th>Date of Sale</th>
                                                        <th>Customer Name</th>
                                                        <th>Car Name</th>
                                                        <th>Chasis No</th>
                                                        <th>Edit</th>
                                                        <th>Submit For Approval / Status</th>
                                                        <th>Status</th>
                                                        <th>Download</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['result'] as $d)
                                                    <tr>
                                                        <td>{{$d->ID}}</td>
                                                        <td>{{$d->InvoiceNo ? $d->InvoiceNo : '-'}}</td>
                                                        <td>{{date("Y-m-d", strtotime($d->DateOfSales))}}</td>
                                                        <td>{{$d->FirstName}} {{$d->LastName}}</td>
                                                        <td>{{$d->carMaster->Model}} {{$d->carMaster->ProductLine}}</td>
                                                        <td>{{$d->ChasisNo}}</td>
                                                        <td>
                                                            @if(!$d->InvoiceNo || $d->status == '2')
                                                            <a href="{{route('salesForm', $d->ID)}}">Edit</a>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!$d->InvoiceNo || $d->status == '0' || $d->status == '2')
                                                            <a href="{{route('sendOfApproval', $d->ID)}}">Send of Approval</a>
                                                            @elseif ($d->status == '1')
                                                            -
                                                            @else
                                                            <a href="{{route('statusForm', $d->ID)}}">Status</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($d->status == '1')
                                                            Approved
                                                            @elseif ($d->status == '2')
                                                            Rejected
                                                            @else
                                                            Pending
                                                            @endif
                                                        </td>
                                                        <td>-</td>
                                                        <td>Delete</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>
    </div>



    @include('layout.script')
</body>

</html>