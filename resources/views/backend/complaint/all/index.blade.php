@extends('backend.layouts.header')

@section('content')
<div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3>Datatable Complaint</h3>
            </div>
            <div style="padding-top: 10px; padding-right:10px;">
                <button style="float: right; font-weight: 900;" class="btn btn-info btn-sm pr-4" type="button" onclick="resetfilter()">
                    Reset Filter
                </button>
                <button style="float: right; font-weight: 900;" class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#CreateComplaintModal">
                    Create Complaint
                </button>
            </div>
            <div style="padding-top: 10px; padding-right:10px;"></div>
            <div class="panel-body">
                <div class="responsive-table">
                    <table id="complaint" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Complaint ID</th>
                                <th>Complaint Name</th>
                                <th>Code Request</th>
                                <th>Mps User</th>
                                <th>Main Menu</th>
                                <th>Categories</th>
                                <th>Other Categories</th>
                                <th>Description</th>
                                <th>Request</th>
                                <th>Reason</th>
                                <th>Picture</th>
                                <th>Complaint Status</th>
                                <th>Complaint Status Code</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal" id="CreateComplaintModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Complaint Create</h4>
            </div>
            <!-- Modal body -->
            <form id="form_create" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="code_request">Code Request:</label>
                        <input type="text" class="form-control" name="code_request" id="code_request" value="{{$kode}}" placeholder="Enter Code Request" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="complaint_name">Complaint Name:</label>
                        <input type="text" class="form-control" name="complaint_name" id="complaint_name" placeholder="Enter Complaint Name" required>
                    </div>

                    <div class="form-group">
                        <label for="mps_user">Mps User:</label>
                        <input type="text" class="form-control" name="mps_user" id="mps_user" placeholder="Enter Mps User" required>
                    </div>

                    <div class="form-group">
                        <label for="main_menu">Main Menu:</label>
                        <select class="form-control" name="main_menu" id="main_menu" placeholder="Enter Main Menu" required>
                            @foreach ($main_menu as $main_menu)
                            <option value="{{ $main_menu }}">{{ $main_menu }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="categories">Categories:</label>
                        <select class="form-control" name="categories" id="categories" placeholder="Enter Categories" required>
                            @foreach ($categories as $categories)
                            <option value="{{ $categories }}">{{ $categories }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="other_categories">Other Categories:</label>
                        <input type="text" class="form-control" name="other_categories" id="other_categories" placeholder="Enter Other Categories">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea rows="4" cols="50" class="form-control" name="description" id="description" placeholder="Enter Description" required></textarea>
                        <!-- <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description" required> -->
                    </div>

                    <div class="form-group">
                        <label for="request">Request:</label>
                        <input type="text" class="form-control" name="request" id="request" placeholder="Enter Request" required>
                    </div>

                    <div class="form-group">
                        <label for="reason">Reason:</label>
                        <input type="text" class="form-control" name="reason" id="reason" placeholder="Enter Reason" required>
                    </div>

                    <div class="form-group">
                        <label for="file">Picture:</label>
                        <input type="file" class="form-control-file" name="file" id="file" accept="image/*,.pdf" placeholder="Enter Picture" required>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" value="Submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal" id="EditComplaintModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Complaint Edit</h4>
            </div>
            <!-- Modal body -->
            <form id="form_edit" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="EditComplaintModalBody">

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="SubmitEditComplaintForm">Update</button>
                    <button type="button" class="btn btn-default modelClose" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footers')
<script type="text/javascript">
    function resetfilter() {
        // Refresh Datatable
        $('#complaint').DataTable().ajax.reload();

        // Remove all filter
        $('#complaint').dataTable().fnFilter('');
    }

    function resetForm() {
        document.getElementById("form_create").reset();
    }
    //Active Class 
    $("#complaint-menu").show(function() {
        $('#complaint-menu').addClass('active');
        $('#complaints-menu').addClass('active');
    });

    $(document).ready(function() {
        $('#complaint').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get-complaint-all') }}",
            columns: [{
                    data: 'complaint_id',
                    name: 'complaint_id',
                    visible: false
                }, {
                    data: 'complaint_name',
                    name: 'complaint_name'
                },
                {
                    data: 'code_request',
                    name: 'code_request'
                },
                {
                    data: 'mps_user',
                    name: 'mps_user'
                },
                {
                    data: 'main_menu',
                    name: 'main_menu'
                },
                {
                    data: 'categories',
                    name: 'categories'
                },
                {
                    data: 'other_categories',
                    name: 'other_categories'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'request',
                    name: 'request'
                },
                {
                    data: 'reason',
                    name: 'reason'
                },
                {
                    data: 'picture',
                    name: 'picture'
                },
                {
                    data: 'complaint_status',
                    name: 'complaint_status'
                },
                {
                    data: 'complaint_status_code',
                    name: 'complaint_status_code'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'Actions',
                    name: 'Actions',
                    orderable: false,
                    searchable: false,
                    sClass: 'text-center'
                },
            ],
            language: {
                searchPlaceholder: "Search..."
            },
            order: [
                [0, 'asc']
            ]
        });
    });

    // Create Complaiont Ajax request.
    $('#form_create').submit(function(e) {
        var formData = new FormData($(this)[0]);
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('complaint.store') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            // dataType: "json",
            success: function(result) {
                Swal.fire(
                    'Success!',
                    result.message,
                    'success'
                ).then(function() {
                    $('#CreateComplaintModal').modal('hide');
                    location.reload();
                });
            },
            error: function(error) {
                $.each(error.responseJSON.errors, function(key, value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: value,
                        timer: '1500'
                    })
                });
                // console.log(error);
            }
        });
    });

    function modal(id) {
        $('#modal-global').modal('show');
        var id;
        alert(id);
        // $.ajax({
        //     url: "complaint/" + id,
        //     type: "GET",
        //     // data: {
        //     //     id: _id
        //     // },
        //     contentType: 'application/x-www-form-urlencoded',
        //     beforeSend: function(data, v) {
        //         $('#modal-title').html('Edit');
        //         $('#modal-body').html('<div align="center"><p>Loading ...</p></div>');
        //     },
        //     error: function(data, v) {
        //         $('#modal-body').html('Terjadi kesalahan..');
        //     },
        //     success: function(data, v) {
        //         $('#modal-body').html(data);
        //     }
        // });
    };

    $('body').on('click', '#getEdit', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        $.ajax({
            url: "complaint/" + id,
            type: "GET",
            // data: {
            //     id: _id
            // },
            contentType: 'application/x-www-form-urlencoded',
            beforeSend: function(data, v) {
                $('#modal-title').html('Edit');
                $('#modal-body').html('<div align="center"><p>Loading ...</p></div>');
            },
            error: function(data, v) {
                $('#modal-body').html('Terjadi kesalahan..');
            },
            success: function(data, v) {
                $('#modal-body').html(data);
                $('#modal-global').modal('show');
            }
        });
    });

    // Get single User in EditModel
    $('.modelClose').on('click', function() {
        $('#EditComplaintModal').hide();
    });
    var id;
    $('body').on('click', '#getEditData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        $.ajax({
            url: "complaint/" + id,
            method: 'GET',
            // data: {
            //     id: id,
            // },
            success: function(result) {
                $('#EditComplaintModalBody').html(result.html);
                $('#EditComplaintModal').show();
            }
        });
    });

    // Update User Ajax request.
    $('#SubmitEditComplaintForm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "complaint/" + id,
            method: 'PUT',
            data: {
                complaint_name: $('#edit_complaint_name').val(),
                code_request: $('#edit_code_request').val(),
                mps_user: $('#edit_mps_user').val(),
                main_menu: $('#edit_main_menu').val(),
                categories: $('#edit_categories').val(),
                other_categories: $('#edit_other_categories').val(),
                description: $('#edit_description').val(),
                request: $('#edit_request').val(),
                reason: $('#edit_reason').val(),
                file: $('#edit_file').val(),
                filename: $('#filename').val(),
            },
            success: function(result) {
                Swal.fire(
                    'Success!',
                    result.message,
                    'success'
                ).then(function() {
                    $('#complaint').DataTable().ajax.reload();
                    $('#EditComplaintModal').hide();
                });
            },
            error: function(error) {
                $.each(error.responseJSON.errors, function(key, value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: value,
                        timer: '1500'
                    })
                });
            }
        });
    });

    // Delete User Ajax request.
    var deleteID;
    $('body').on('click', '#getDeleteId', function() {
        deleteID = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = deleteID;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "complaint/" + id,
                    method: 'DELETE',
                    success: function(result) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        $('#complaint').DataTable().ajax.reload();
                    }
                });
            }
        })
    })

    function preview(file) {
        var _file = file;
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        // console.log(_file);
        $.ajax({
            url: "{{ route('check') }}",
            type: "GET",
            data: {
                file: _file,
                _token: csrf_token
            },
            contentType: 'application/x-www-form-urlencoded',
            beforeSend: function(data, v) {
                Swal.fire(
                    'Loading!',
                    'Loading....',
                    'info'
                )
            },
            error: function(data, v) {
                console.log(data);
            },
            success: function(data, v) {
                console.log(data);
                window.open(data.data, '_blank');
            }
        });
    };
</script>
@endsection