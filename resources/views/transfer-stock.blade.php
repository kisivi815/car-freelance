<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.header')
    <style>
        /* Custom CSS for Select2 */
        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            --bs-form-select-bg-img: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            display: block;
            width: 100%;
            height: 38px;
            padding: .375rem 0 .375rem 0 !important;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #607080;
            -webkit-appearance: none;
            appearance: none;
            background-color: #fff;
            background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 16px 12px;
            border: 1px solid #dce7f1;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #607080;
            font-weight: 400;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #4CAF50 transparent transparent transparent;
            /* Green arrow */
            display: none;
        }

        .select2-dropdown.select2-dropdown--below {
            border: 1px solid #dce7f1 !important;
        }
    </style>
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
                                                        <label>Source Branch</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="SourceBranch" required>
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
                    $.ajax({
                        url: '/submit-transfer-stock',
                        type: 'POST',
                        data: $('#transfer-stock-form').serialize(),
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