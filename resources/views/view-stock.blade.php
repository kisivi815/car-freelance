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
                                                        <td>12121221</td>
                                                        <td><a href="#">View Pics</a></td>
                                                        <td><a href="#">View Note</a></td>
                                                        <td><a href="#">Approve with note</a></td>
                                                        <td><a href="#">Reject with note</a></td>
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