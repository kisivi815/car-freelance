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
                                    <h4 class="card-title">Gate Pass</h4>
                                    <a href="{{ route('print-gate-pass-pdf',['id'=>str_replace('TF','',$data->GatePassId)]) }}" class="btn btn-primary me-1 mb-1" style="width:100px" target="_blank">Print</a>
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
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->GatePassId}}" placeholder="Stock T/F ID" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Chasis No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->ChasisNo}}" placeholder="Chasis No" disabled>
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
                                                        <label for="contact-info-horizontal">Mileage(S)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->MileageSend}}" placeholder="Mileage(S)" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="contact-info-horizontal">Mileage(R)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->MileageReceive ?? '-'}}" placeholder="Mileage(R)" disabled>
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
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Sender Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{ucwords($data->UserSendBy->name)}}" placeholder="Driver Name" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Sender Note</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="Note" disabled>{{$data->Note}}</textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Receiver Name</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->ReceivedBy ?? '-'}}" placeholder="Receiver Name" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Receiver Note</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="Note" disabled>{{$data->ReceiveNote ?? '-'}}</textarea>
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