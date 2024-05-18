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
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Quick Sale</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="first-name-horizontal">Chasis No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Chasis No">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Date of Booking</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Date of Booking">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="contact-info-horizontal">Sale Person Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Sale Person Name">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Brance of Sales</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Brance of Sales">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Customer Mobile No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Customer Mobile No">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Customer Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Customer Name">
                                                    </div>
                                                    <div class="col-sm-12 d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1" style="width:200px">Submit</button>
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
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Gate Pass</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="first-name-horizontal">Sales ID</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="sales ID">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Car Name & Model</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Car Name & Model">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="contact-info-horizontal">Date of Booking</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Date of Booking">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Sales Person Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Sales Person Name">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Branch of Sales</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Branch of Sales">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Customer Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" name="fname" placeholder="Customer Name">
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
        </div>
    </div>



    @include('layout.script')
</body>

</html>