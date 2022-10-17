<form id="form_edit" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-body">
        <input type='hidden' id='encrypt_id' value='{{$encrypt_id}}'>

        <div class='form-group'>
            <label for='status'>Status:</label>
            <input type='text' class='form-control' name='status' id='edit_status' value="{{$data->status}}" placeholder='Enter Status' required>
        </div>

        <div class='form-group'>
            <label for='description'>Description:</label>
            <textarea rows='4' cols='50' class='form-control' name='description' id='edit_description' value="{{$data->description}}" placeholder='Enter Description'>{{$data->description}}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="SubmitEditstatusForm"> <i class="fa fa-check"></i> Update</button>
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
            url: "status/" + id,
            method: 'PUT',
            data: {
                status: $('#edit_status').val(),
                description: $('#edit_description').val(),
            },
            success: function(result) {
                Swal.fire(
                    'Success!',
                    result.message,
                    'success'
                ).then(function() {
                    $('#status').DataTable().ajax.reload();
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