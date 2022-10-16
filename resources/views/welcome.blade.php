<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="description" content="HD">
    <meta name="keyword" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help Desk</title>

    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="assets/backend/css/bootstrap.min.css">

    <!-- plugins -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/plugins/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/plugins/simple-line-icons.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/plugins/fullcalendar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/style.css') }}" />
    <!-- end: Css -->

    <link rel="shortcut icon" href="asset/img/logomi.png">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body id="mimin" class="dashboard">
    <!-- start: Header -->
    <nav class="navbar navbar-default header navbar-fixed-top">
    </nav>
    <!-- end: Header -->

    <div class="container-fluid mimin-wrapper">

        <!-- start:Left Menu -->
        <div id="left-menu">
            <div class="sub-left-menu scroll">
                <ul class="nav nav-list">
                    <li>
                        <div class="left-bg"></div>
                    </li>
                    <li class="time">
                        <h1 class="animated fadeInLeft">21:00</h1>
                        <p class="animated fadeInRight">Sat,October 1st 2029</p>
                    </li>

                </ul>
            </div>
        </div>
        <!-- end: Left Menu -->


        <!-- start: Content -->
        <div id="content">
            <div class="panel box-shadow-none content-header">
                <div class="panel-body">
                    <div class="col-md-12">
                        <h3 class="animated fadeInLeft">Form Element</h3>
                        <p class="animated fadeInDown">
                            Form <span class="fa-angle-right fa"></span> Form Element
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 panel">
                <div class="col-md-12 panel-heading">
                    <h4>Form Validation</h4>
                </div>
                <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                    <div class="col-md-12">
                        <!-- <form class="cmxform" id="signupForm" method="POST" enctype="multipart/form-data"> -->

                        <form class="cmxform" id="form_create" method="POST" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <input type="hidden" class="form-text" name="code_request" id="code_request" value="{{$kode}}" placeholder="Enter Code Request" required readonly>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" name="complaint_name" id="complaint_name" required>
                                    <span class="bar"></span>
                                    <label>Name</label>
                                </div>

                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" name="mps_user" id="mps_user" required>
                                    <span class="bar"></span>
                                    <label>MPS Username</label>
                                </div>

                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <span class="bar"></span>
                                    <select class="form-text" name="main_menu" id="main_menu" placeholder="Enter Main Menu" required>
                                        @foreach ($main_menu as $main_menu)
                                        <option value="{{ $main_menu }}">{{ $main_menu }}</option>
                                        @endforeach
                                    </select>
                                    <label>Main Menu</label>
                                </div>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <span class="bar"></span>
                                    <select class="form-text" name="categories" id="categories" placeholder="Enter Categories" required>
                                        @foreach ($categories as $categories)
                                        <option value="{{ $categories }}">{{ $categories }}</option>
                                        @endforeach
                                    </select>
                                    <label>Categories</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" name="other_categories" id="other_categories">
                                    <span class="bar"></span>
                                    <label>Other Categories</label>
                                </div>

                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <textarea rows="4" cols="50" class="form-text" name="description" id="description" required></textarea>
                                    <span class="bar"></span>
                                    <label>Description</label>
                                </div>

                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" name="request" id="request" required>
                                    <span class="bar"></span>
                                    <label>Request</label>
                                </div>

                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="text" class="form-text" name="reason" id="reason" required>
                                    <span class="bar"></span>
                                    <label>Reason</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>File yang berkaitan</label>
                                <span class="bar"></span>
                                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                                    <input type="file" class="form-text" name="file" id="file" accept="image/*,.pdf" placeholder="Enter Picture" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input class="submit btn btn-danger" type="submit" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: content -->


        <!-- start: right menu -->
        <div id="right-menu"></div>
        <!-- end: right menu -->

    </div>

    <!-- start: Mobile -->
    <div id="mimin-mobile" class="reverse"></div>
    <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
        <span class="fa fa-bars"></span>
    </button>
    <!-- end: Mobile -->

    <!-- start: Javascript -->
    <script src="{{ asset('assets/backend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/jquery.ui.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/bootstrap.min.js') }}"></script>

    <!-- plugins -->
    <script src="{{ asset('assets/backend/js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/jquery.vmap.sampledata.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/chart.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/plugins/datatables.bootstrap.min.js') }}"></script>


    <!-- custom -->
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/backend/js/main.js') }}"></script>

    <!-- custom -->
    <script src="asset/js/main.js"></script>
    <script type="text/javascript">
        function resetForm() {
            document.getElementById("form_create").reset();
        }

        $(document).ready(function() {
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
        });
    </script>
    <!-- end: Javascript -->
</body>

</html>