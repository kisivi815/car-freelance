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
                <button class="btn btn-primary" style="float:right;display:block;" type="button" onclick="window.location.href='{{ route("quick-booking") }}'">
                    Add Quick Booking
                </button>
                </p>
                <div class="collapse show" id="collapseExample">
                    <section>
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal" id="stock-filter" method="GET" action="{{route('quickSalesIndex')}}">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="">Source</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <select class="form-select" name="branch">
                                                                <option value="">Branch</option>
                                                                @foreach ($data['branch'] as $b)
                                                                <option value="{{$b->id}}" {{ $b->id == request('branch') ? 'selected' : '' }}>{{$b->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="contact-info-horizontal">Customer Name</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <input type="text" class="form-control" name="name" value="{{ old('name',request('name')) }}" placeholder="Name">
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
                                                        <th>Sales ID</th>
                                                        <th>ChasisNo</th>
                                                        <th>Sales Person Name</th>
                                                        <th>Branch</th>
                                                        <th>Customer Name</th>
                                                        <th>Customer Contact</th>
                                                        <th>Date of Booking</th>
                                                        <th>TM Invoice No</th>
                                                        <th>Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['result'] as $r)
                                                    <tr>
                                                        <td>{{$r->SalesId}}</td>
                                                        <td>{{$r->ChasisNo}}</td>
                                                        <td>{{$r->SalesPersonName}}</td>
                                                        <td>{{$r->Branch}}</td>
                                                        <td>{{$r->CustomerName}}</td>
                                                        <td>{{$r->CustomerMobileNo}}</td>
                                                        <td>{{date("Y-m-d", strtotime($r->DateOfBooking))}}</td>
                                                        <td>{{$r->TMInvoiceNo}}</td>
                                                        <td><a href="{{route('quick-booking', $r->ID)}}">Edit</a></td>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pagination-div">
                                            {{$data['result']->links('vendor.pagination.bootstrap-4')}}
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
                            Are you sure you want to delete this stock?
                        </p>
                    </div>
                    <div class="modal-button-div">
                        <button type="button" id="delete-stock-confirm" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Yes</span>
                        </button>
                        <button type="button" id="delete-stock-cancel" class="btn btn-light-secondary" data-bs-dismiss="modal">
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

            $('.chasisNo-select').select2()

            $('#reset').on('click', function() {
                $('#stock-filter input').removeAttr('value');
                $('#stock-filter select option:selected').removeAttr('selected');
                $('.chasisNo-select').val(null).trigger('change');

            });


            $('.delete-stock').click(function() {
                var id = $(this).data('id');
                $('#delete-stock-confirm').data('id', id);
            });

            $('#delete-stock-cancel').click(function() {
                $('#delete-stock-confirm').data('id', '');
            });

            $('#delete-stock-confirm').click(function() {
                var id = $(this).data('id');
                if (id) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/delete-transfer-stock/" + id, // Change to your server URL
                        type: 'DELETE',
                        success: function(response) {
                            if (response == 'success') {
                                window.location.href = '/view-stock';
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error occurred:', error);
                            window.location.href = '/view-stock';
                        }
                    });

                }
            });
        });
    </script>
</body>

</html>