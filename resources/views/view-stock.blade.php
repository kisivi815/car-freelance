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
                                                        <th>T/F To</th>
                                                        <th>T/F From</th>
                                                        <th>Car Name</th>
                                                        <th>Model</th>
                                                        <th>Chasis No</th>
                                                        <th>Pics</th>
                                                        <th>View Note</th>
                                                        <th>Approve</th>
                                                        <th>Reject</th>
                                                        <th>Receive Stock</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>DD-MM-YYYY</td>
                                                        <td>Branch Name</td>
                                                        <td>Branch Name</td>
                                                        <td>Altroz</td>
                                                        <td>LXI</td>
                                                        <td>MAT6274672LB18081</td>
                                                        <td><a href="#">View Pics</a></td>
                                                        <td><a href="#">View Note</a></td>
                                                        <td><a href="#" data-bs-toggle="modal" data-bs-target="#inlineForm">Approve with note</a></td>
                                                        <td><a href="#">Reject with note</a></td>
                                                        <td><a href="receive-stock/1">Receive Stock</a></td>
                                                    </tr>
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