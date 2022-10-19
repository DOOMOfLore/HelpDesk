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

        @switch($data->complaint_status)
        @case('Solved')
        <div class="form-group" style="padding-bottom:20px;">
            <label for="status_code">Status Code : {{$data->complaint_status_code}}</label> <br>
            <input type="hidden" id="old_status_code" name="old_status_code" value="{{$data->complaint_status_code}}">
            <input type="hidden" id="old_status_complaint" name="old_status_complaint" value="{{$data->complaint_status}}">
            <input type="radio" name="status_code" id='status_code' value="{{$data->complaint_status_code}}" checked required> {{$data->complaint_status_code}} <br>
        </div>
        <div class='form-group' id="treatment">
            <label for='treatment'>Treatment:</label>
            <textarea rows='4' cols='50' class='form-control' name='treatment' id='edit_treatment' value='{{$data->treatment}}' placeholder='Enter Treatment' required>{{$data->treatment}}</textarea>
        </div>
        @break
        @break

        @case('Unapproved')
        <div class="form-group" style="padding-bottom:20px;">
            <label for="status_code">Status Code : {{$data->complaint_status_code}}</label> <br>
            <input type="hidden" id="old_status_code" name="old_status_code" value="{{$data->complaint_status_code}}">
            <input type="hidden" id="old_status_complaint" name="old_status_complaint" value="{{$data->complaint_status}}">
            <input type="radio" name="status_code" id='status_code' value="{{$data->complaint_status_code}}" checked required> {{$data->complaint_status_code}} <br>
        </div>
        <div class='form-group' id="treatment">
            <label for='treatment'>Treatment:</label>
            <textarea rows='4' cols='50' class='form-control' name='treatment' id='edit_treatment' value='{{$data->treatment}}' placeholder='Enter Treatment' required>{{$data->treatment}}</textarea>
        </div>
        @break
        @break

        @case('On Progress')
        <div class="form-group" style="padding-bottom:20px;">
            <label for="status_code">Status Code : {{$data->complaint_status_code}}</label> <br>
            <input type="hidden" id="old_status_code" name="old_status_code" value="{{$data->complaint_status_code}}">
            <input type="hidden" id="old_status_complaint" name="old_status_complaint" value="{{$data->complaint_status}}">
            @foreach ($OnProgress as $key => $value)
            <input type="radio" name="status_code" id='status_code' value="{{$value}}" <?php echo ($value == $data->complaint_status_code) ? "checked" : " ";; ?>> {{$value}} <br>
            @endforeach
        </div>
        <div class='form-group' id="treatment" style="display: none;">
            <label for='treatment'>Treatment:</label>
            <textarea rows='4' cols='50' class='form-control' name='treatment' id='edit_treatment' value='{{$data->treatment}}' placeholder='Enter Treatment' required>{{$data->treatment}}</textarea>
        </div>
        @break

        @case('Release')
        <div class="form-group" style="padding-bottom:20px;">
            <label for="status_code">Status Code : {{$data->complaint_status_code}}</label> <br>
            <input type="hidden" id="old_status_code" name="old_status_code" value="{{$data->complaint_status_code}}">
            <input type="hidden" id="old_status_complaint" name="old_status_complaint" value="{{$data->complaint_status}}">
            @foreach ($Release as $key => $value)
            <input type="radio" name="status_code" id='status_code' value="{{$value}}" <?php echo ($value == $data->complaint_status_code) ? "checked" : " ";; ?>> {{$value}} <br>
            @endforeach
        </div>
        @break
        @default
        @endswitch
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="SubmitEditCategoriesForm"> <i class="fa fa-check"></i> Update</button>
        <button type="button" class="btn btn-default modelClose" data-dismiss="modal">Close</button>
    </div>
</form>

<script type="text/javascript">
    var get_status_code = $('#old_status_code').val();
    var get_status_complaint = $('#old_status_complaint').val();

    function show() {
        document.getElementById("#treatment").style.display = "block";
    }

    // $('.form-group treatment').on('mouseenter', function(e) {
    //     $('.form-group treatment').css({
    //         /* 'visibility': 'visible', */
    //         'display': 'block',
    //     })
    // })

    $("input[type='radio']").change(function() {
        get_status_code = $(this).val();
        let result_status_code = get_status_code.toLowerCase();

        switch (result_status_code) {
            case 'solved':
                get_status_complaint = "Solved";
                $('#treatment').css({
                    'display': 'block',
                });
                break;
            case 'unapproved':
                get_status_complaint = "Unapproved";
                $('#treatment').css({
                    'display': 'block',
                });
                break;
            case 'waiting for approval':
                get_status_complaint = "On Progress";
                break;
            case 'on proses':
                get_status_complaint = "On Progress";
                break;
        }
    });

    $("#form_edit").submit(function(e) {
        e.preventDefault();
        id = $('#encrypt_id').val();
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
                filename: $('#filename').val(),
                status_code: get_status_code,
                status_complaint: get_status_complaint,
                treatment: $('#edit_treatment').val(),
            },
            success: function(result) {
                Swal.fire(
                    'Success!',
                    result.message,
                    'success'
                ).then(function() {
                    $('#complaint').DataTable().ajax.reload();
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