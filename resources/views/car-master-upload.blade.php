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
                                                <form class="form form-horizontal col-lg-6 col-md-12" id="upload-stock-form" action="{{route('upload-car-sheets')}}" name="uploadstockform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                                    @csrf
                                                    <div>
                                                        <label for="formFile" class="form-label">Upload Stock</label>
                                                        <div class="row">
                                                            <div class="col-lg-8 col-md-10 col-sm-8">
                                                                <input class="form-control" type="file" name="file" id="formFile">
                                                            </div>
                                                            <div class="col-lg-4 col-md-2 col-sm-4">
                                                                <button type="submit" class="btn btn-primary me-1 mb-1" id="submit-btn" style="width:100px" value="submit">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form class="form form-horizontal col-lg-6 col-md-12" id="upload-stock-form" action="{{route('upload-car-details-sheets')}}" name="uploadstockform" method="POST" enctype="multipart/form-data" autocomplete="off">
                                                @csrf
                                                <div>
                                                    <label for="formFile" class="form-label">Upload Car Details</label>
                                                    <div class="row">
                                                        <div class="col-lg-8 col-md-10 col-sm-8">
                                                            <input class="form-control" type="file" name="file" id="formFile">
                                                        </div>
                                                        <div class="col-lg-4 col-md-2 col-sm-4">
                                                            <button type="submit" class="btn btn-primary me-1 mb-1" id="submit-btn" style="width:100px" value="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
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


        @include('layout.script')
        <script>
            $(document).ready(function() {


            });
        </script>
</body>

</html>