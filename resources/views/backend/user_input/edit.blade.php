<form id="form_edit" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-body">
        <input type='hidden' id='encrypt_id' value='{{$encrypt_id}}'>

        <div class='form-group'>
            <label for='user_input'>User Input:</label>
            <input type='text' class='form-control' name='user_input' id='edit_user_input' value="{{$data->user_input}}" placeholder='Enter User Input' required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="SubmitEdituser_inputForm"> <i class="fa fa-check"></i> Update</button>
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
            url: "user_input/" + id,
            method: 'PUT',
            data: {
                user_input: $('#edit_user_input').val(),
            },
            success: function(result) {
                Swal.fire(
                    'Success!',
                    result.message,
                    'success'
                ).then(function() {
                    $('#user_input').DataTable().ajax.reload();
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