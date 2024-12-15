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
                <div class="collapse show" id="collapseExample">
                    <section>
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal" id="stock-filter" method="GET" action="{{route('exportCsv')}}">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label>Branch</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <select class="form-select" name="branch">
                                                                <option value="">All</option>
                                                                @foreach ($branch as $b)
                                                                <option value="{{$b->id}}" {{ $b->id == request('source') ? 'selected' : '' }}>{{$b->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="horizontal">Status</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <select class="form-select" name="status">
                                                                @foreach ($data['status'] as $s)
                                                                <option value="{{$s['value']}}" {{ $s['value'] == request('status') ? 'selected' : '' }}>{{$s['text']}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="email-horizontal">Start Date</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <input type="date" class="form-control flatpickr-no-config" name="startDate" placeholder="Start Date" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="email-horizontal">End Date</label>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <input type="date" class="form-control flatpickr-no-config" name="endDate" placeholder="End Date" required>
                                                        </div>
                                                        <div class="col-sm-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary me-1 mb-1">Generate</button>
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
    </div>

    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <p class="modal-text">
                            Are you sure you want to delete this stock?
                        </p>
                    </div>
                    <div class="modal-button-div">
                        <button type="button" id="delete-stock-confirm" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Yes</span>
                        </button>
                        <button type="button" id="delete-stock-cancel" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">No</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layout.script')
    @include('layout.datepicker-script')

    <script>
        $(document).ready(function() {

            flatpickr('.flatpickr-no-config', {
                enableTime: false,
                dateFormat: "Y-m-d",
            })

            $('.chasisNo-select').select2()

            $('#reset').on('click', function() {
                $('#stock-filter input').removeAttr('value');
                $('#stock-filter select option:selected').removeAttr('selected');
                $('.chasisNo-select').val(null).trigger('change');

            });


            $('.delete-stock').click(function() {
                var id = $(this).data('id');
                $('#delete-stock-confirm').data('id', id);
            });

            $('#delete-stock-cancel').click(function() {
                $('#delete-stock-confirm').data('id', '');
            });

            $('#delete-stock-confirm').click(function() {
                var id = $(this).data('id');
                if (id) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/delete-transfer-stock/" + id, // Change to your server URL
                        type: 'DELETE',
                        success: function(response) {
                            if (response == 'success') {
                                window.location.href = '/view-stock';
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error occurred:', error);
                            window.location.href = '/view-stock';
                        }
                    });

                }
            });
        });
    </script>
</body>

</html>