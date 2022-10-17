@extends('backend.layouts.header')

@section('content')
<div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3>Datatable Classification</h3>
            </div>
            <div style="padding-top: 10px; padding-right:10px;">
                <button style="float: right; font-weight: 900;" class="btn btn-info btn-sm pr-4" type="button" onclick="resetfilter()">
                    Reset Filter
                </button>
                <button style="float: right; font-weight: 900;" class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#CreateclassificationModal">
                    Create Classification
                </button>
            </div>
            <div style="padding-top: 10px; padding-right:10px;"></div>
            <div class="panel-body">
                <div class="responsive-table">
                    <table id="classification" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Classification</th>
                                <th>Classification</th>
                                <th>Description</th>
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
<div class="modal" id="CreateclassificationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Classification Create</h4>
            </div>
            <!-- Modal body -->
            <form id="form_create" method="POST" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="classification">Classification:</label>
                        <input type="text" class="form-control" name="classification" id="classification" placeholder="Enter Classification" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea rows="4" cols="50" class="form-control" name="description" id="description" placeholder="Enter Description"></textarea>
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

@endsection

@section('footers')
<script type="text/javascript">
    function resetfilter() {
        // Refresh Datatable
        $('#classification').DataTable().ajax.reload();

        // Remove all filter
        $('#classification').dataTable().fnFilter('');
    }

    function resetForm() {
        document.getElementById("form_create").reset();
    }
    //Active Class 
    $("#classification-menu").show(function() {
        $('#classification-menu').addClass('active');
        $('#master-menu').addClass('active');
    });

    $(document).ready(function() {
        $('#classification').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get-classification-all') }}",
            columns: [{
                    data: 'classification_id',
                    name: 'classification_id',
                    visible: false
                },
                {
                    data: 'classification',
                    name: 'classification'
                },
                {
                    data: 'description',
                    name: 'description'
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
            url: "{{ route('classification.store') }}",
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
                    $('#classification').DataTable().ajax.reload();
                    $('#CreateclassificationModal').modal('hide');
                    resetForm();
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

    $('body').on('click', '#getEdit', function(e) {
        // e.preventDefault();
        id = $(this).data('id');
        $.ajax({
            url: "classification/" + id,
            type: "GET",
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
                    url: "classification/" + id,
                    method: 'DELETE',
                    success: function(result) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then(function() {
                            resetfilter();
                        });
                    }
                });
            }
        })
    })
</script>
@endsection