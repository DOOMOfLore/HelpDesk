<!doctype html>
<html lang="en">

<head>
    <title>HD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/login/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url(assets/login/images/bg-1.jpg);">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Sign In</h3>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="Role">Role</label>
                                <select class="form-control" id="role" name="role" placeholder="Role" required>
                                    <option value="Superadmin">Superadmin</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label class="label" for="password">Password</label>
                                <span class="input-group-btn" id="eyeSlash">
                                    <button class="btn btn-default reveal" onclick="invisible()" type="button"><i class="fa fa-eye-slash" aria-hidden="true" style="color: #66a1c4"></i></button>
                                </span>
                                <span class="input-group-btn" id="eyeShow" style="display: none;">
                                    <button class="btn btn-default reveal" onclick="invisible()" type="button"><i class="fa fa-eye" aria-hidden="true" style="color: #66a1c4"></i></button>
                                </span>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3" id="SignIn">Sign In</button>
                            </div>
                            <p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script src="{{ asset('assets/login/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/login/js/popper.js') }}"></script>
<script src="{{ asset('assets/login/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/login/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function invisible() {
        var x = document.getElementById('password');
        if (x.type === 'password') {
            x.type = "text";
            $('#eyeShow').show();
            $('#eyeSlash').hide();
        } else {
            x.type = "password";
            $('#eyeShow').hide();
            $('#eyeSlash').show();
        }
    };
    // Create article Ajax request.
    $('#SignIn').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('authenticate') }}",
            method: 'post',
            data: {
                username: $('#username').val(),
                role: $('#role').val(),
                password: $('#password').val(),
            },
            success: function(data) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    timer: '3000'
                }).then(function() {
                    window.location.href = "{{ route('dashboard.index') }}";
                });
            },
            error: function(error) {
                Swal.fire({
                    title: 'Oops...',
                    text: error.responseJSON.message,
                    icon: 'error',
                    timer: '1500'
                })
            }
        });
    });
</script>

</html>