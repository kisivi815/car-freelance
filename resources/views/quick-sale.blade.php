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
                                        <form class="form form-horizontal" method="POST" action="{{ route('submit-quick-sales') }}" name="quickSaleForm">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="first-name-horizontal">Chasis No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="ChasisNo" id="ChasisNo" required>
                                                            <option value="">Select Chasis No</option>
                                                            @foreach ($data['car'] as $c)
                                                            <option value="{{$c->ChasisNo}}" {{ old('ChasisNo') == $c->ChasisNo ? 'selected' : '' }}>{{$c->ChasisNo}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Car Details</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <div>
                                                            <label>Model :</label> <span id="Model">-</span><br>
                                                            <label>Product Line :</label> <span id="ProductLine">-</span><br>
                                                            <label>Colour :</label> <span id="Colour">-</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Date of Booking</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="date" class="form-control flatpickr-no-config" name="DateOfBooking" placeholder="Date of Booking">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="contact-info-horizontal">Sale Person Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="salesPersonName" class="salesPersonName form-control" name="SalesPersonName" placeholder="Sales Person Name">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Branch of Sales</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="Branch" required>
                                                            <option value="">Select Destination Branch</option>
                                                            @foreach ($data['branch'] as $b)
                                                            <option value="{{$b->id}}" {{ old('DestinationBranch') == $b->id ? 'selected' : '' }}>{{$b->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Customer Mobile No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="textInput" class="customerMobileNo form-control" name="CustomerMobileNo" onkeypress="return isNumberKey(event)" oninput="validateInput(this)" placehodler="Customer Mobile No">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Customer Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="customerName" class="customerName form-control" name="CustomerName" placeholder="Customer Name">
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
                <!-- <section id="basic-horizontal-layouts">
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
                                                        <input type="text" id="salesPersonName" class="salesPersonName form-control" name="salesPersonName" placeholder="Sales Person Name">
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
                                                        <input type="text" id="customerName" class="customerName form-control" name="customerName" placeholder="Customer Name">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
            </div>
        </div>
    </div>



    @include('layout.script')
    @include('layout.datepicker-script')
    <script>
        $(document).ready(function() {
            $('.form-select').select2();

            flatpickr('.flatpickr-no-config', {
                enableTime: false,
                dateFormat: "Y-m-d",
            })

            $('#ChasisNo').on('change', function() {
                $('#Model').text('-');
                $('#ProductLine').text('-');
                var selectedValue = $(this).val();
                $.ajax({
                    url: '/car-details',
                    type: 'GET',
                    data: {
                        'ChasisNo': selectedValue
                    },
                    success: function(response) {
                        $('#Model').text(response.Model);
                        $('#ProductLine').text(response.ProductLine);
                        $('#Colour').text(response.Colour);

                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + error);
                    }
                });
            });
        });

        $('#salesPersonName,#customerName').on('input', function() {
            $(this).val($(this).val().toLowerCase().replace(/\b\w/g, function(letter) {
                return letter.toUpperCase();
            }));
        });

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function validateInput(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }
    </script>
</body>

</html>