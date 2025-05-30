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
                                        <form class="form form-horizontal" action="{{route('submit-receive-stock', ['id' => $currentId])}}" id="receive-stock-form" name="receivestockform" method="POST" enctype="multipart/form-data">
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
                                                        <label for="first-name-horizontal">Mileage(S)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" value="{{$data->MileageSend}}" disabled>
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
                                                        <label for="horizontal">Sender Note</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="Note" disabled>{{$data->Note}}</textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Sender Pics</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <div class="image-container">
                                                            @php
                                                            $receiverCount = $data->Image->where('type', 'sender')->count();
                                                            @endphp
                                                            @if($receiverCount > 0)
                                                            @foreach ($data->Image as $image)
                                                            @if($image->type=='sender')
                                                            <img src=" {{$image->imageurl}}" alt="image" width="200" height="200">
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            NO SENDER PICS
                                                            @endif
                                                        </div>
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
                                                        <input type="text" id="ReceivedBy" class="form-control" placeholder="Received By" name="ReceivedBy" value="{{$data->manager ? $data->manager->id : $data->ReceivedBy}}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="first-name-horizontal">Mileage(R)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="number" id="first-name-horizontal" class="form-control" name="MileageReceive" min="1" max="10" value="" oninput="validateMileage(this)" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Add Note</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="Note" {{(request()->query('status') === 'reject') ? 'required' : ''}}></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Upload Pics</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="file" class="image-preview-filepond" name="photo[]"  multiple>
                                                    </div>
                                                    <div class="col-sm-12 d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1" id="submit-btn" style="width:200px">Submit</button>
                                                    </div>
                                                    <input type="hidden" name="status" value="{{ request()->query('status') }}">
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
                $(this).val($(this).val().toLowerCase().replace(/\b\w/g, function(letter) {
                    return letter.toUpperCase();
                }));
            });
        });

        $('#submit-btn').on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission
                var valid = true;
                var message = '';
                $('#receive-stock-form').find('.red-border').removeClass("red-border");
                $('.alert-danger').hide();


                $('#receive-stock-form').find('input[required], select[required], textarea[required]').each(function() {
                    if ($(this).is(':checkbox')) {
                        if (!$(this).is(':checked')) {
                            valid = false;
                        }
                    }else if ($(this).is('textarea')) {
                        if (!$(this).val().trim()) {
                            valid = false;
                            $(this).addClass("red-border");
                        }
                    }else if (!$(this).val()) {
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
                    document.receivestockform.submit()
                }

            });
    </script>
</body>

</html>