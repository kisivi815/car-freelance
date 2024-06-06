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
                                    <h4 class="card-title">Stock Details</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        @php
                                        $currentId = request()->route('id');
                                        @endphp
                                        <form class="form form-horizontal" action="{{route('submit-receive-stock', ['id' => $currentId])}}" method="POST">
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
                                                    @if(in_array($data->CarMaster->PhysicalStatus, ['APPROVED','REJECTED']))
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Received By</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="first-name-horizontal" class="form-control" placeholder="Received By" name="ReceivedBy" value="{{$data->ReceivedBy}}" disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Received Note</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="Note" value="{{$data->SendBy}}" disabled>{{$data->ReceiveNote}}</textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="horizontal">Receiver Pics</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <div class="image-container">
                                                            @php
                                                            $receiverCount = $data->Image->where('type', 'receiver')->count();
                                                            @endphp
                                                            @if($receiverCount > 0)
                                                            @foreach ($data->Image as $image)
                                                            @if($image->type=='receiver')
                                                            <img src=" {{$image->imageurl}}" alt="image" width="200" height="200">
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            NO RECIEVER PICS
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endif
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
    <script>
        $(document).ready(function() {
            $('.form-select').select2();
        });
    </script>
</body>

</html>