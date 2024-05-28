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
                                                    @foreach ($data as $d)
                                                    <tr>
                                                        <td>{{$d->id}}</td>
                                                        <td>{{$d->DateOfTransfer}}</td>
                                                        <td>{{$d->SourceBranch}}</td>
                                                        <td>{{$d->SendBy}}</td>
                                                        <td><a href="stock-details/{{$d->id}}">Details</td>
                                                        <td>{{$d->DestinationBranch}}</td>
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
</body>

</html>