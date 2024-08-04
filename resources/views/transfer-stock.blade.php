<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.header')
</head>
<style>
    .select2-container--fake-disabled .select2-selection--single {
        background-color: #e9ecef;
        /* Light gray background to indicate disabled state */
        cursor: not-allowed;
        /* Change cursor to indicate it's not clickable */
        opacity: 0.5;
        /* Reduce opacity to make it look disabled */
    }

    .select2-container--fake-disabled .select2-selection__arrow b {
        display: none;
        /* Hide the dropdown arrow */
    }
</style>

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
                                    <h4 class="card-title">Transfer Stock</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" id="transfer-stock-form" action="{{route('submit-transfer-stock')}}" name="transferstockform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Chasis No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="ChasisNo" id="ChasisNo" required>
                                                            <option value="">Select Chasis No</option>
                                                            @foreach ($data['car'] as $c)
                                                            <option value="{{$c->ChasisNo}}" {{ old('ChasisNo') == $c->ChasisNo ? 'selected' : '' }} data-status="{{$c->PhysicalStatus}}" data-current-location="{{isset($c->TransferStockBranch->DestinationBranch)?$c->TransferStockBranch->DestinationBranch :''}}">{{$c->ChasisNo}}</option>
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
                                                        <label>Mileage</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" id="Mileage" class="form-control" name="MileageSend" placeholder="Mileage" min="1" max="10" value="" oninput="validateMileage(this)" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Source Branch</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="SourceBranch" id="SourceBranch" required>
                                                            <option value="">Select Source Branch</option>
                                                            @foreach ($data['branch'] as $b)
                                                            <option value="{{$b->id}}" {{ old('SourceBranch') == $b->id ? 'selected' : '' }}>{{$b->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Destination Branch</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="DestinationBranch" required>
                                                            <option value="">Select Destination Branch</option>
                                                            @foreach ($data['branch'] as $b)
                                                            <option value="{{$b->id}}" {{ old('DestinationBranch') == $b->id ? 'selected' : '' }}>{{$b->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Driver Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="DriverName" class="form-control" name="DriverName" placeholder="Driver Name" value="{{ old('DriverName')}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Upload Pics</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="file" class="image-preview-filepond" name="photo[]" multiple>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Add Note</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="Note">{{ old('Note') }}</textarea>
                                                    </div>
                                                    <div class="col-sm-12 d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1" id="submit-btn" style="width:200px" value="submit">Submit</button>
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
            $('.form-select').select2();

            $('#DriverName').on('input', function() {
                $(this).val($(this).val().toLowerCase().replace(/\b\w/g, function(letter) {
                    return letter.toUpperCase();
                }));
            });


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

                var status = $(this).find(':selected').data('status');
                var currentLocation = $(this).find(':selected').data('current-location');
                if (status == 'In Transit') {
                    $('#SourceBranch').val('9').trigger('change');
                    $('#SourceBranch').next('.select2-container').addClass('select2-container--fake-disabled');
                } else if (currentLocation) {
                    $('#SourceBranch').val(currentLocation).trigger('change');
                    $('#SourceBranch').next('.select2-container').addClass('select2-container--fake-disabled');
                } else {
                    $('#SourceBranch').prop('disabled', false);
                    $('#SourceBranch').val('').trigger('change');
                    $('#SourceBranch').next('.select2-container').removeClass('select2-container--fake-disabled');
                }
            });

            $('#submit-btn').on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission
                var valid = true;
                var message = '';
                $('#transfer-stock-form').find('.red-border').removeClass("red-border");
                $('.alert-danger').hide();
                var destinationBranchValue = $('select[name="DestinationBranch"]').val();
                var sourceBranchValue = $('select[name="SourceBranch"]').val();


                $('#transfer-stock-form').find('input[required], select[required]').each(function() {
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


                if (destinationBranchValue == sourceBranchValue && (destinationBranchValue !== '' && sourceBranchValue !== '')) {
                    $('.alert-danger').show()
                    message = 'Source and Destination branches cannot be same';
                    $('select[name="DestinationBranch"]').next().find('span > ').addClass("red-border");
                    $('select[name="SourceBranch"]').next().find('span > ').addClass("red-border");
                    valid = false;
                }



                if (!valid) {
                    $('.alert-danger').show()
                    $('#error-text').text(message);
                } else {
                    var form = $('#transfer-stock-form')[0];
                    var formData = new FormData(form);
                    var files = $('.image-preview-filepond .filepond--browser')[0].files;
                    for (var i = 0; i < files.length; i++) {
                        formData.append('photo[]', files[i]);
                    }

                    $.ajax({
                        url: '/submit-transfer-stock',
                        type: 'POST',
                        data: formData,
                        contentType: false, // Important
                        processData: false, // Important
                        success: function(response) {
                            if (response.id) {
                                window.location.href = '/gate-pass/' + response.id + '?from=transfer-stock';
                            } else {
                                $('.alert-danger').show()
                                $('#error-text').text('Submit Failed');
                            }

                        },
                        error: function(xhr, status, error) {
                            $('.alert-danger').show()
                            $('#error-text').text(error);
                            if (xhr.responseJSON.error) {
                                var errorMessage = xhr.responseJSON.error;
                                $('#error-text').text(errorMessage);
                            }

                        }
                    });
                }

            });

        });
    </script>
</body>

</html>