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
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Filter
                </button>
                </p>
                <div class="collapse show" id="collapseExample">
                    <section>
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal" id="stock-filter" method="GET" action="{{route('view-sales')}}">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="">From Date of Sales</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <input type="text" class="form-control flatpickr-no-config" name="FromDateOfSales" value="{{ old('FromDateOfSales',request('FromDateOfSales')) }}" placeholder="From Date of Sales">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">To Date of Sales</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <input type="text" class="form-control flatpickr-no-config" name="ToDateOfSales" value="{{ old('ToDateOfSales',request('ToDateOfSales')) }}" placeholder="To From Date of Sales">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="contact-info-horizontal">Name</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <input type="text" class="form-control" name="name" value="{{ old('name',request('name')) }}" placeholder="Name">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="horizontal">Status</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <select class="form-select" name="status">
                                                                @foreach ($data['status'] as $s)
                                                                <option value="{{$s['value']}}" {{ $s['value'] == request('status') ? 'selected' : '' }}>{{$s['text']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Invoice No</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <input type="text" class="form-control" name="invoiceNo" placeholder="Invoice No" value="{{ old('invoiceNo',request('invoiceNo')) }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Chasis No</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <select class="form-select chasisNo-select" name="chasisNo">
                                                                <option value="">Chasis No</option>
                                                                @foreach ($data['car'] as $c)
                                                                <option value="{{$c['ChasisNo']}}" {{ $c['ChasisNo'] == request('chasisNo') ? 'selected' : '' }}>{{$c['ChasisNo']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary me-1 mb-1">Search</button>
                                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1" id="reset">Reset</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
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
                                                        <td>{{isset($d->carMaster->Model) ? $d->carMaster->Model : '' }} {{ isset($d->carMaster->ProductLine) ? $d->carMaster->ProductLine : '-'}}</td>
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
                                                        <td><a href="#" class="delete-sales" data-id="{{ $d->ID }}" data-bs-toggle="modal" data-bs-target="#inlineForm">Delete</a></td>
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

    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <p class="modal-text">
                            Are you sure you want to delete this sales?
                        </p>
                    </div>
                    <div class="modal-button-div">
                        <button type="button" id="delete-sales-confirm" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Yes</span>
                        </button>
                        <button type="button" id="delete-sales-cancel" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">No</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @include('layout.datepicker-script')
    @include('layout.script')
    <script>
        $(document).ready(function() {
            flatpickr('.flatpickr-no-config', {
                enableTime: false,
                dateFormat: "Y-m-d",
            })

            $('.chasisNo-select').select2()

            $('#reset').on('click', function() {
                $('#stock-filter input').removeAttr('value');
                $('#stock-filter select option:selected').removeAttr('selected');
                $('.chasisNo-select').val(null).trigger('change');

            });

            $('.delete-sales').click(function() {
                var id = $(this).data('id');
                $('#delete-sales-confirm').data('id', id);
            });

            $('#delete-sales-cancel').click(function() {
                $('#delete-sales-confirm').data('id', '');
            });

            $('#delete-sales-confirm').click(function() {
                var id = $(this).data('id');
                if (id) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/delete-sales/" + id, // Change to your server URL
                        type: 'DELETE',
                        success: function(response) {
                            if (response == 'success') {
                                window.location.href = '/view-sales';
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error occurred:', error);
                            window.location.href = '/view-sales';
                        }
                    });

                }
            });
        });
    </script>
</body>

</html>