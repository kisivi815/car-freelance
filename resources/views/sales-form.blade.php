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
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal" id="transfer-stock-form"  action="{{ isset($data['data']) ? route('submit-sales', $data['data']->ID) : route('submit-sales') }}" name="transferstockform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <h4 class="card-title">Customer Details</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Mobile</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="Mobile" class="form-control" name="Mobile" placeholder="Mobile" value="{{isset($data['data'])? $data['data']->Mobile : old('Mobile')}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Saluation</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="Saluation" id="Saluation" required>
                                                            <option value="">Select Saluation</option>
                                                            <option value="Mr" {{((isset($data['data']) && $data['data']->Saluation == 'Mr') || old('Saluation') == 'Mr' ) ?'selected' : '' }}>Mr</option>
                                                            <option value="Ms" {{((isset($data['data']) && $data['data']->Saluation == 'Ms') || old('Saluation') == 'Ms' ) ?'selected' : '' }}>Ms</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>First Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="firstName" class="form-control" name="FirstName" placeholder="First Name" value="{{isset($data['data'])? $data['data']->FirstName : old('FirstName')}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Last Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="lastName" class="form-control" name="LastName" placeholder="Last Name" value="{{isset($data['data'])? $data['data']->LastName : old('LastName')}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Father Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="fatherName" class="form-control" name="FathersName" placeholder="Father Name" value="{{isset($data['data'])? $data['data']->FathersName : old('FathersName')}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Email</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="email" class="form-control" name="Email" placeholder="Email" value="{{isset($data['data'])? $data['data']->Email : old('Email')}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Aadhar</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="aadhar" class="form-control" name="Aadhar" placeholder="Aadhar" value="{{isset($data['data'])? $data['data']->Aadhar : old('Aadhar')}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>PAN</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="pan" class="form-control" name="PAN" placeholder="PAN" value="{{isset($data['data'])? $data['data']->PAN : old('PAN')}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>GST</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="gst" class="form-control" name="GST" placeholder="GST" value="{{isset($data['data'])? $data['data']->GST : old('GST')}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Permanent Address</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="permanentAddress" rows="3" name="PermanentAddress">{{isset($data['data'])? $data['data']->PermanentAddress : old('PermanentAddress')}}</textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Temporary Address</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="temporaryAddress" rows="3" name="TemporaryAddress">{{isset($data['data'])? $data['data']->TemporaryAddress : old('TemporaryAddress')}}</textarea>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <h4 class="card-title">Car Details</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Chasis No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="ChasisNo" id="ChasisNo" required>
                                                            @foreach ($data['car'] as $c)
                                                            <option value="{{ $c->ChasisNo }}"
                                                                {{ old('ChasisNo') == $c->ChasisNo ? 'selected' : '' }}
                                                                {{ isset($data['data']) && $data['data']->ChasisNo == $c->ChasisNo ? 'selected' : '' }}>
                                                                {{ $c->ChasisNo }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Car Details</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <div>
                                                            <label>Model :</label> <span id="Model">{{isset($data['data']->CarMaster->Model)? $data['data']->CarMaster->Model : '-'}}</span><br>
                                                            <label>Product Line :</label> <span id="ProductLine">{{isset($data['data']->CarMaster->ProductLine)? $data['data']->CarMaster->ProductLine : '-'}}</span><br>
                                                            <label>Colour :</label> <span id="Colour">{{isset($data['data']->CarMaster->Colour)? $data['data']->CarMaster->Colour : '-'}}</span><br>
                                                            <label>Price :</label> <span id="Price">{{isset($data['data']->CarMaster->Amount)? $data['data']->CarMaster->Amount : '-'}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <h4 class="card-title">Bank Details</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Bank & Branch</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="Bank" required>
                                                            <option value="">Select Bank & Branch</option>
                                                            @foreach ($data['bank'] as $b)
                                                            <option value="{{$b->ID}}" {{((isset($data['data']) && $data['data']->Bank == $b->ID) || old('Bank') == $b->ID ) ?'selected' : '' }}>{{$b->Name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <h4 class="card-title">Insurance Details</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Insurance Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="InsuranceName" required>
                                                            <option value="">Select Insurance</option>
                                                            @foreach ($data['insurance'] as $i)
                                                            <option value="{{$i->ID}}" {{((isset($data['data']) && $data['data']->InsuranceName == $i->ID) || old('InsuranceName') == $b->ID ) ?'selected' : '' }}>{{$i->Name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <h4 class="card-title">Discount Details</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Discount Type</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="DiscountType" required>
                                                            <option value="">Select Discount</option>

                                                            @foreach ($data['discount'] as $d)
                                                            <option value="{{$d->ID}}" {{((isset($data['data']) && $data['data']->DiscountType == $d->ID) || old('DiscountType') == $d->ID ) ?'selected' : '' }}>{{$d->value}}%</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <h4 class="card-title">Accessories Details</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Accessories</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="accessories" rows="3" name="Accessories"></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Upload</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="file" class="image-preview-filepond" name="accesoriesFile[]" multiple>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <h4 class="card-title">GST Details</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Type of GST</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="TypeofGST" required>
                                                            <option value="1" selected>CGST + SGST</option>
                                                            <option value="2">IGST</option>
                                                        </select>
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
            $('#ChasisNo').trigger('change');
            
            $('#ChasisNo').on('change', function() {
                $('#Model').text('-');
                $('#ProductLine').text('-');
                $('#Colour').text('-');
                $('#Price').text('-');
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
                        $('#Price').text(response.Amount);

                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + error);
                    }
                });


            });
        });
    </script>
</body>

</html>