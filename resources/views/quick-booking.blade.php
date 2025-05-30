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
                                    <h4 class="card-title">Quick Booking</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="POST" id="quickSaleForm" name="quickSaleForm">
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
                                                            <option value="{{$c->ChasisNo}}" 
                                                            {{ old('ChasisNo') == $c->ChasisNo ? 'selected' : '' }} >
                                                            {{$c->ChasisNo}}
                                                            </option>
                                                            @endforeach
                                                            @if (isset($data['result']) && $data['result']['ChasisNo'])
                                                            <option value="{{$data['result']['ChasisNo']}}" selected> {{ $data['result']['ChasisNo'] }} </option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Car Details</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <div>
                                                            <label>Model :</label> <span id="Model">-</span><br>
                                                            <label>Product Line :</label> <span id="ProductLine">-</span><br>
                                                            <label>Colour :</label> <span id="Colour">-</span><br>
                                                            <label>TM Invoice No :</label> <span id="TMInvoiceNo">-</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Date of Booking</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="date" class="form-control flatpickr-no-config" name="DateOfBooking" placeholder="Date of Booking"  required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="contact-info-horizontal">Sale Person Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="salesPersonName" class="salesPersonName form-control" name="SalesPersonName" oninput="removeNumbers(this)" placeholder="Sales Person Name" value="{{isset($data['result']) && $data['result']['SalesPersonName'] ? $data['result']['SalesPersonName'] :''}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Branch of Sales</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="Branch" required>
                                                            <option value="">Select Branch</option>
                                                            @foreach ($data['branch'] as $b)
                                                            <option value="{{$b->id}}" {{ old('Branch') == $b->id ? 'selected' : '' }}
                                                              {{isset($data['result']) && $data['result']['Branch'] == $b->id ?'selected' : '' }}  >
                                                                {{$b->name}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Customer Mobile No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="textInput" class="customerMobileNo form-control" name="CustomerMobileNo" onkeypress="return isNumberKey(event)" oninput="validateInput(this);" placehodler="Customer Mobile No" value="{{isset($data['result']) && $data['result']['CustomerMobileNo'] ? $data['result']['CustomerMobileNo'] :''}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Customer Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="customerName" class="customerName form-control" name="CustomerName" oninput="removeNumbers(this)" placeholder="Customer Name" value="{{isset($data['result']) && $data['result']['CustomerName'] ? $data['result']['CustomerName'] :''}}" required>
                                                    </div>
                                                    <div class="col-sm-12 d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1" id="submit-btn" style="width:200px">Submit</button>
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
    @include('layout.datepicker-script')
    <script>
        $(document).ready(function() {
            $('.form-select').select2();

            flatpickr('.flatpickr-no-config', {
                enableTime: false,
                dateFormat: "Y-m-d",
                defaultDate: "{{ isset($data['result']) && $data['result']['DateOfBooking'] ? $data['result']['DateOfBooking'] :'' }}"
            })

            $('#ChasisNo').on('change', function() {
                $('#Model').text('-');
                $('#ProductLine').text('-');
                $('#Colour').text('-');
                $('#TMInvoiceNo').text('-');
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
                        $('#TMInvoiceNo').text(response.CommercialInvoiceNo);

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

        $('#submit-btn').on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission
                var valid = true;
                var message = '';
                $('#receive-stock-form').find('.red-border').removeClass("red-border");
                $('.alert-danger').hide();


                $('#quickSaleForm').find('input[required], select[required]').each(function() {
                    if ($(this).is(':checkbox')) {
                        if (!$(this).is(':checked')) {
                            valid = false;
                        }
                    } else if (!$(this).val()) {
                        if ($(this).is('select')) {
                            $(this).next().find('span > ').addClass("red-border");
                        } else {
                            $(this).addClass("red-border"); // Add the red-border class
                        }

                        valid = false;

                    }

                    message = 'Please fill in all required fields.'
                });


                if (!valid) {
                    $('.alert-danger').show()
                    $('#error-text').text(message);
                } else {
                    var form = $('#quickSaleForm')[0];
                    var formData = new FormData(form);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/submit-quick-sales/{{isset($data['result']) && $data['result']['ID'] ? $data['result']['ID'] :''}}",
                        type: 'POST',
                        data: formData,
                        contentType: false, // Important
                        processData: false, // Important
                        success: function(response) {
                            if (response.id) {
                                window.location.href = '/view-quick-booking';
                            } else {
                                $('.alert-danger').show()
                                $('#error-text').text('Submit Failed');
                            }

                        },
                        error: function(xhr, status, error) {
                            $('.alert-danger').show()
                            var response = JSON.parse(xhr.responseText); // Parse JSON response
                            for (const key in response.errors) {
                                if (response.errors.hasOwnProperty(key)) {
                                    const messages = response.errors[key];
                                    messages.forEach(message => {
                                        if(message){
                                            $('#error-text').text(message);
                                        }
                                        
                                    });
                                }
                            }
                            
                            if (xhr.responseJSON.error) {
                                var errorMessage = xhr.responseJSON.error;
                                $('#error-text').text(xhr.responseJSON);
                            }

                        }
                    });
                }

            });

            $(window).on('load', function() {
                $('#ChasisNo').select2();
                $('#ChasisNo').trigger('change');
            });
    </script>
</body>

</html>