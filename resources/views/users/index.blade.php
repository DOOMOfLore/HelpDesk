@extends('layouts.header')

@section('content')
<div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3>Data Tables Users</h3>
            </div>
            <div style="padding-top: 10px; padding-right:10px;">
                <button style="float: right; font-weight: 900;" class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#CreateUsersModal">
                    Create Article
                </button>
            </div>
            <div class="panel-body">
                <div class="responsive-table">
                    <table id="users" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
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

<!-- Create Users Modal -->
<div class="modal" id="CreateUsersModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Users Create</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitCreateUsersForm">Create</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Users Modal -->
<div class="modal" id="EditUsersModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Users Edit</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="EditUsersModalBody">

                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitEditUsersForm">Update</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footers')
<script type="text/javascript">
    $(document).ready(function() {
        $('#users').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get-users') }}",
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
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
                    serachable: false,
                    sClass: 'text-center'
                },
            ]
        });
    });

    // Create article Ajax request.
    $('#SubmitCreateUsersForm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('users.store') }}",
            method: 'post',
            data: {
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
            },
            success: function(result) {
                if (result.errors) {
                    $.each(result.errors, function(key, value) {
                        // swal("Failed!", value, "error");
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: value,
                        })
                    });
                } else {
                    $('#users').DataTable().ajax.reload();
                    $('#CreateUsersModal').modal('hide');
                    // swal("Good job!", "Data saved successfully!", "success");
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data Saved successfully!',
                    })
                }
            }
        });
    });

    // Get single article in EditModel
    $('.modelClose').on('click', function() {
        $('#EditUsersModal').hide();
    });
    var id;
    $('body').on('click', '#getEditData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        $.ajax({
            url: "users/" + id + "/edit",
            method: 'GET',
            // data: {
            //     id: id,
            // },
            success: function(result) {
                $('#EditUsersModalBody').html(result.html);
                $('#EditUsersModal').show();
            }
        });
    });

    // Update article Ajax request.
    $('#SubmitEditUsersForm').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "users/" + id,
            method: 'PUT',
            data: {
                name: $('#editName').val(),
                email: $('#editEmail').val(),
            },
            success: function(result) {

                if (result.errors) {
                    $.each(result.errors, function(key, value) {
                        // swal("Failed!", value, "error");
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: value,
                        })
                    });
                } else {
                    $('#users').DataTable().ajax.reload();
                    $('#EditUsersModal').hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data Updated successfully!',
                    })
                }
            }
        });
    });

    // Delete article Ajax request.
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
                    url: "users/" + id,
                    method: 'DELETE',
                    success: function(result) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        $('#users').DataTable().ajax.reload();
                    }
                });
            }
        })
    })
</script>
@endsection