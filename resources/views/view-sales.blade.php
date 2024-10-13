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



    @include('layout.script')
    <script>
        $(document).ready(function() {

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