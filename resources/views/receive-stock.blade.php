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
                @if(session('message'))
                <div class="alert alert-success alert-dismissible show fade">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Receive Stock</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        @php
                                        $currentId = request()->route('id');
                                        @endphp
                                        <form class="form form-horizontal" action="{{route('submit-receive-stock', ['id' => $currentId])}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="first-name-horizontal">Chasis No</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->ChasisNo}}" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="first-name-horizontal">TF ID</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->GatePassId}}" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email-horizontal">Source Branch</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->Source->name}}" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="contact-info-horizontal">Destination Branch</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->Destination->name}}" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="first-name-horizontal">Sent By</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->SendBy}}" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Received By</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="ReceivedBy" class="form-control" placeholder="Received By" name="ReceivedBy" value="">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Add Note</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="Note"></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Upload Pics</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="file" class="image-preview-filepond" name="photo[]"  multiple>
                                                    </div>
                                                    <div class="col-sm-12 d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1" style="width:200px">Submit</button>
                                                    </div>
                                                    <input type="hidden" name="status" value="{{request()->query('status')}}">
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
            $('#ReceivedBy').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });
        });
    </script>
</body>

</html>