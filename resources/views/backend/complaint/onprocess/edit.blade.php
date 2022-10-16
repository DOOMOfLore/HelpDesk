<form id="form_edit" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-body">
        <input type='hidden' id='encrypt_id' value='{{$encrypt_id}}'>
        <input type="hidden" id="filename" value="{{$data->picture}}">
        <div class='form-group'>
            <label for='code_request'>Code Request:</label>
            <input type='text' class='form-control' name='code_request' id='edit_code_request' value="{{$data->code_request}}" placeholder='Enter Code Request' required readonly>
        </div>

        <div class='form-group'>
            <label for='complaint_name'>Complaint Name:</label>
            <input type='text' class='form-control' name='complaint_name' id='edit_complaint_name' value="{{$data->complaint_name}}" placeholder='Enter Complaint Name' required>
        </div>

        <div class='form-group'>
            <label for='mps_user'>Mps User:</label>
            <input type='text' class='form-control' name='mps_user' id='edit_mps_user' value="{{$data->mps_user}}" placeholder='Enter Mps User' required>
        </div>

        <div class="form-group">
            <label for="main_menu">Main Menu:</label>
            {!! Form::select('main_menu', $main_menu, $selectedIDMainMenu, ['class' => 'form-control' , 'id' => 'edit_main_menu']) !!}
        </div>

        <div class="form-group">
            <label for="categories">Categories:</label>
            {!! Form::select('categories', $categories, $selectedIDCategories, ['class' => 'form-control' , 'id' => 'edit_categories']) !!}
        </div>

        <div class='form-group'>
            <label for='other_categories'>Other Categories:</label>
            <input type='text' class='form-control' name='other_categories' id='edit_other_categories' value="{{$data->other_categories}}" placeholder='Enter Other Categories'>
        </div>

        <div class='form-group'>
            <label for='description'>Description:</label>
            <textarea rows='4' cols='50' class='form-control' name='description' id='edit_description' value="{{$data->description}}" placeholder='Enter Description' required>{{$data->description}}</textarea>
        </div>

        <div class='form-group'>
            <label for='request'>Request:</label>
            <input type='text' class='form-control' name='request' id='edit_request' value="{{$data->request}}" placeholder='Enter Request' required>
        </div>

        <div class='form-group'>
            <label for='reason'>Reason:</label>
            <input type='text' class='form-control' name='reason' id='edit_reason' value="{{$data->reason}}" placeholder='Enter Reason' required>
        </div>

        <div class="form-group">
            <label for="status_code">Status Code:</label>
            {!! Form::select('status_code', $status_code, $selectedComplaint_status_code, ['class' => 'form-control' , 'id' => 'status_code']) !!}
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="SubmitEditComplaintForm"> <i class="fa fa-check"></i> Update</button>
        <button type="button" class="btn btn-default modelClose" data-dismiss="modal">Close</button>
    </div>
</form>

<script type="text/javascript">
    $('body').on('submit', '#form_edit', function(e) {
        e.preventDefault();
        id = $('#encrypt_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "onprocess/" + id,
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
                filename: $('#filename').val(),
                status_code: $('#status_code').val(),
            },
            success: function(result) {
                Swal.fire(
                    'Success!',
                    result.message,
                    'success'
                ).then(function() {
                    $('#onprocess').DataTable().ajax.reload();
                    $('#modal-global').modal('hide');
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
</script>