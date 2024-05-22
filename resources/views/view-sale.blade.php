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
                                                        <th>Status</th>
                                                        <th style="min-width: 100px">Submit For Approval</th>
                                                        <th>Approve</th>
                                                        <th>Reject</th>
                                                        <th>Download</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-bold-500">Michael Right</td>
                                                        <td>$15/hr</td>
                                                        <td class="text-bold-500">UI/UX</td>
                                                        <td>Remote</td>
                                                        <td>Austin,Taxes</td>
                                                        <td><a href="#"><i class="badge-circle badge-circle-light-secondary font-medium-1" data-feather="mail"></i></a></td>
                                                        <td class="text-bold-500">Michael Right</td>
                                                        <td>$15/hr</td>
                                                        <td class="text-bold-500">UI/UX</td>
                                                        <td>Remote</td>
                                                        <td>Austin,Taxes</td>
                                                        <td><a href="#"><i class="badge-circle badge-circle-light-secondary font-medium-1" data-feather="mail"></i></a></td>
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



    @include('layout.script')
</body>

</html>