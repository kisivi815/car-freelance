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
                                <div class="card-header" style="display: flex;justify-content: space-between;">
                                    <h4 class="card-title">Quick Sale Gate Pass</h4>
                                    <a href="{{ route('print-quick-sales-gate-pass-pdf',['id'=>$data->ID]) }}" class="btn btn-primary me-1 mb-1" style="width:100px" target="_blank">Print</a>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="first-name-horizontal">Sale ID</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->SalesId}}"  disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Customer Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->CustomerName}}" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="first-name-horizontal">TM Invoice No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->TMInvoiceNo}}"  disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Chasis No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->ChasisNo}}"  disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Model</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->CarMaster->Model}}"  disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Product Line</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->CarMaster->ProductLine}}"  disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Colour</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->CarMaster->Colour}}"  disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="contact-info-horizontal">Date of Booking</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{date('Y-m-d',strtotime($data->DateOfBooking))}}" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="contact-info-horizontal">Sales Person Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->SalesPersonName}}"  disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Customer ID</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->CustomerMobileNo}}" disabled>
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

    @include('layout.uploadimage-script')
    @include('layout.script')
    <script>
        $(document).ready(function() {

        });
    </script>
</body>

</html>