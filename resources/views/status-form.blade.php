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
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Invoice Date :</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    {{date('d-m-Y', strtotime($data->InvoiceDate))}}
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Invoice No :</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    {{$data->InvoiceNo}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <h4 class="card-title">Sales Details</h4>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <label>Customer Details:</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Mobile :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->Mobile}}
                                                        </div>
                                                        <div class="col-md-2">
                                                            Father Name :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->FathersName}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            First Name :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->FirstName}}
                                                        </div>
                                                        <div class="col-md-2">
                                                            Last Name :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->LastName}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Email :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->Email}}
                                                        </div>
                                                        <div class="col-md-2">
                                                            Aadhar :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->Aadhar}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            PAN :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->PAN}}
                                                        </div>
                                                        <div class="col-md-2">
                                                            GST :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->GST}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Permanent Address :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->PermanentAddress}}
                                                        </div>
                                                        <div class="col-md-2">
                                                            Temporary Address:
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->TemporaryAddress}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <label>Car Details:</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Chasis No :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->ChasisNo}}
                                                        </div>
                                                        <div class="col-md-2">
                                                            Model :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->carMaster->Model}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Product Line :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->carMaster->ProductLine}}
                                                        </div>
                                                        <div class="col-md-2">
                                                            Colour :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->carMaster->Colour}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Engine No :
                                                            </div>
                                                            <div class="col text-left">
                                                            {{$data->carMaster->EngineNo}}
                                                            </div>
                                                        <div class="col-md-2">
                                                            Price :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->carMaster->Amount}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label>Bank Details:</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label>Insurance Details:</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Bank :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->bank->Name}}
                                                        </div>
                                                        <div class="col-md-2">
                                                            Insurance Name :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->insurance->Name}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <label>Accessories Details:</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Accessories :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$data->Accessories}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <h4 class="card-title">Rate Details</h4>
                                                </div>
                                                <div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Rate :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$rateDetails['Rate']}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                            <div class="col-md-2">
                                                            Discount :
                                                            </div>
                                                            <div class="col text-left">
                                                            @if ($rateDetails['Discount'] > 0)
                                                                {{ $rateDetails['Discount'] }} ({{ $data->Discount }}%)
                                                            @else
                                                                -
                                                            @endif
                                                            </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Amount :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$rateDetails['Amount']}}
                                                        </div>
                                                    </div>
                                                    @if($data->TypeofGST == '1')
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            CGST :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$rateDetails['CGST']}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            SGST :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$rateDetails['SGST']}}
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            IGST :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$rateDetails['IGST']}}
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Cess :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$rateDetails['CESS']}}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            Total :
                                                        </div>
                                                        <div class="col text-left">
                                                            {{$rateDetails['Total']}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form class="form form-horizontal" id="transfer-stock-form" action="{{ route('submitSatusForm', ['id' => $data->ID]) }}" name="transferstockform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                                @csrf
                                                <div class="col-md-4 mt-2 mb-2">
                                                    <label>Add Note :</label>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="Note">{{ old('Note') }}</textarea>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-sm-12 d-flex justify-content-between" style="max-width: 500px;margin: 0auto;">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1" id="submit-btn" style="width:200px;background-color:green;" name="action" value="approve">Approve</button>
                                                        <button type="submit" class="btn btn-primary me-1 mb-1" id="submit-btn" style="width:200px;background-color:red;" name="action" value="reject">Reject</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @include('layout.datepicker-script')
    @include('layout.script')
    <script>
        $(document).ready(function() {
            flatpickr('.flatpickr-no-config', {
                enableTime: false,
                dateFormat: "Y-m-d",
            })
        });
    </script>
</body>

</html>