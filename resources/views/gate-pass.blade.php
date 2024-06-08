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
            border: 1px solid #dce7f1 !important;
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
                                <div class="card-header" style="display: flex;justify-content: space-between;">
                                    <h4 class="card-title">Gate Pass</h4>
                                    <a href="{{ route('print-gate-pass-pdf') }}"  class="btn btn-primary me-1 mb-1" style="width:100px" target="_blank">Print</a>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="first-name-horizontal">Stock T/F ID</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control"  value="{{$data->GatePassId}}" placeholder="Stock T/F ID" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Chasis No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control"  value="{{$data->ChasisNo}}" placeholder="Chasis No" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="contact-info-horizontal">Car Name & Model</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->CarMaster->Model.' '.$data->CarMaster->ProductLine}}" placeholder="Car Name & Model" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="contact-info-horizontal">Colour</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->CarMaster->Colour}}" placeholder="Colour" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Date of Transfer</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->DateOfTransfer}}" placeholder="Date of Transfer" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Source Branch</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->Source->name}}" placeholder="Source Branch" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Destination Branch</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->Destination->name}}" placeholder="Destination Branch" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Driver Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->DriverName}}" placeholder="Driver Name" disabled>
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