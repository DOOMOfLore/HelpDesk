@extends('backend.layouts.header')

@section('content')
<div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3>Data Table Users</h3>
            </div>
            <div style="padding-top: 10px; padding-right:10px;">
                <button style="float: right; font-weight: 900;" class="btn btn-info btn-sm pr-4" type="button" onclick="resetfilter()">
                    Reset Filter
                </button>
                <button style="float: right; font-weight: 900;" class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#CreateUserModal">
                    Create User
                </button>
            </div>
            <div style="padding-top: 10px; padding-right:10px;"></div>
            <div class="panel-body">
                <div class="responsive-table">
                    <table id="users" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Role</th>
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

<!-- Create User Modal -->
<div class="modal" id="CreateUserModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Users Create</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required>
                </div>

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
                </div>

                <div class="form-group ">
                    <label for="Role">Role:</label>
                    <select class="form-control" id="role" name="role" placeholder="Role" required>
                        <option value="Superadmin">Superadmin</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-1">Password</label>
                    <span class="col-md-6" id="eyeSlash">
                        <button class="btn btn-default reveal" onclick="invisible()" type="button"><i class="fa fa-eye-slash" aria-hidden="true" style="color: #66a1c4"></i></button>
                    </span>
                    <span class="col-md-6" id="eyeShow" style="display: none;">
                        <button class="btn btn-default reveal" onclick="invisible()" type="button"><i class="fa fa-eye" aria-hidden="true" style="color: #66a1c4"></i></button>
                    </span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="SubmitCreateUserForm">Create</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal" id="EditUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Users Edit</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="EditUserModalBody">

                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="SubmitEditUserForm">Update</button>
                <button type="button" class="btn btn-default modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footers')
<script type="text/javascript">
    //Active Class 
    $("#users-menu").show(function() {
        $('#users-menu').addClass('active');
        $('#tables-menu').addClass('active');
    });
    function resetfilter() {
        // Refresh Datatable
        $('#users').DataTable().ajax.reload();

        // Remove all filter
        $('#users').dataTable().fnFilter('');
    }

    $(document).ready(function() {
        $('#users').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get-users') }}",
            columns: [{
                    data: 'username',
                    name: 'username',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'role',
                    name: 'role',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                },
                {
                    data: 'Actions',
                    name: 'Actions',
                    orderable: false,
                    searchable: false,
                    sClass: 'text-center'
                },
            ]
        });
    });

    // Create User Ajax request.
    $('#SubmitCreateUserForm').click(function(e) {
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
                username: $('#username').val(),
                role: $('#role').val(),
                email: $('#email').val(),
                password: $('#password').val(),
            },
            success: function(result) {
                Swal.fire(
                    'Success!',
                    result.message,
                    'success'
                ).then(function() {
                    $('#users').DataTable().ajax.reload();
                    $('#CreateUserModal').modal('hide');
                    $('#name').val();
                    $('#username').val();
                    $('#role').val();
                    $('#email').val();
                    $('#password').val();
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
                console.log(error);
            }
        });
    });

    // Get single User in EditModel
    $('.modelClose').on('click', function() {
        $('#EditUserModal').hide();
    });
    var id;
    $('body').on('click', '#getEditData', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        $.ajax({
            url: "users/" + id,
            method: 'GET',
            // data: {
            //     id: id,
            // },
            success: function(result) {
                $('#EditUserModalBody').html(result.html);
                $('#EditUserModal').show();
            }
        });
    });

    // Update User Ajax request.
    $('#SubmitEditUserForm').click(function(e) {
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
                username: $('#editUsername').val(),
                role: $('#editRole').val(),
            },
            success: function(result) {
                Swal.fire(
                    'Success!',
                    result.message,
                    'success'
                ).then(function() {
                    $('#users').DataTable().ajax.reload();
                    $('#EditUserModal').hide();
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