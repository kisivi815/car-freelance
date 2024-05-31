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
                                            <form class="form form-horizontal" id="stock-filter" method="GET" action="{{route('view-stock')}}">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="">Source</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <select class="form-select" name="source">
                                                                <option value="">All</option>
                                                                @foreach ($data['branch'] as $b)
                                                                <option value="{{$b->id}}" {{ $b->id == request('source') ? 'selected' : '' }}>{{$b->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="">Destination</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <select class="form-select" name="destination">
                                                                <option value="">All</option>
                                                                <@foreach ($data['branch'] as $b) <option value="{{$b->id}}" {{ $b->id == request('destination') ? 'selected' : '' }}> {{$b->name}}</option>
                                                                    @endforeach
                                                            </select>
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
                                                            <label>Car</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <input type="text" class="form-control" name="car" placeholder="Car" value="{{ old('car',request('car')) }}">
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
                                                        <th>Date of Transfer</th>
                                                        <th>T/F From</th>
                                                        <th>Sender Name</th>
                                                        <th>Sender Details</th>
                                                        <th>T/F To</th>
                                                        <th>Receiver Name</th>
                                                        <th>Receiver Detail</th>
                                                        <th>Car Name</th>
                                                        <th>Model</th>
                                                        <th>Chasis No</th>
                                                        <th>Approve</th>
                                                        <th>Reject</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['result'] as $d)
                                                    <tr>
                                                        <td>{{$d->id}}</td>
                                                        <td>{{$d->DateOfTransfer}}</td>
                                                        <td>{{$d->Source->name}}</td>
                                                        <td>{{$d->SendBy}}</td>
                                                        <td><a href="stock-details/{{$d->id}}">Details</td>
                                                        <td>{{$d->Destination->name}}</td>
                                                        <td>{{ $d->ReceivedBy ? $d->ReceivedBy : '-' }}</td>
                                                        <td><a href="stock-details/{{$d->id}}">{{ $d->ReceivedBy ? 'Details' : '-' }}</td>
                                                        <td>{{$d->Car->Model}}</td>
                                                        <td>{{$d->Car->ProductLine}}</td>
                                                        <td>{{$d->ChasisNo}}</td>
                                                        <!-- <td><a href="#" data-bs-toggle="modal" data-bs-target="#inlineForm">Approve with note</a></td> -->
                                                        <td>
                                                            @if (!$d->ReceivedBy)
                                                            <a href="receive-stock/{{$d->id}}?status=approve">Approve with note</a>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (!$d->ReceivedBy)
                                                            <a href="receive-stock/{{$d->id}}?status=reject">Reject with note</a>
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                        <td><a href="#">Delete</a></td>
                                                    </tr>
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
                    <h4 class="modal-title" id="myModalLabel33">Login Form </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <label for="email">Email: </label>
                        <div class="form-group">
                            <input id="email" type="text" placeholder="Email Address" class="form-control">
                        </div>
                        <label for="password">Password: </label>
                        <div class="form-group">
                            <input id="password" type="password" placeholder="Password" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">login</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layout.script')
    <script>
        $(document).ready(function() {
            $('#reset').on('click', function() {
                $('#stock-filter input').removeAttr('value');
                $('#stock-filter select option:selected').removeAttr('selected');
            });
        });
    </script>
</body>

</html>