{{-- modal global --}}
<div id="modal-global" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Large modal</h4>
            </div>
            <div class="modal-body" id="modal-body">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

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

<!-- sambungan -->
@yield('footers')
<script type="text/javascript">
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

    // Logout Ajax request.
    $('#logout-form').click(function(e) {
        deleteID = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('logout') }}",
                    method: 'GET',
                    success: function(result) {
                        Swal.fire(
                            'Success!',
                            result.message,
                            'success'
                        ).then(function() {
                            window.location.href = "{{ route('login') }}";
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Oops...',
                            text: 'Anda Gagal Logout',
                            icon: 'error',
                            timer: '1500'
                        })
                    }
                });
            }
        })
    })

    // (function(jQuery) {

    //     // start: Chart =============

    //     Chart.defaults.global.pointHitDetectionRadius = 1;
    //     Chart.defaults.global.customTooltips = function(tooltip) {

    //         var tooltipEl = $('#chartjs-tooltip');

    //         if (!tooltip) {
    //             tooltipEl.css({
    //                 opacity: 0
    //             });
    //             return;
    //         }

    //         tooltipEl.removeClass('above below');
    //         tooltipEl.addClass(tooltip.yAlign);

    //         var innerHtml = '';
    //         if (undefined !== tooltip.labels && tooltip.labels.length) {
    //             for (var i = tooltip.labels.length - 1; i >= 0; i--) {
    //                 innerHtml += [
    //                     '<div class="chartjs-tooltip-section">',
    //                     '   <span class="chartjs-tooltip-key" style="background-color:' + tooltip.legendColors[i].fill + '"></span>',
    //                     '   <span class="chartjs-tooltip-value">' + tooltip.labels[i] + '</span>',
    //                     '</div>'
    //                 ].join('');
    //             }
    //             tooltipEl.html(innerHtml);
    //         }

    //         tooltipEl.css({
    //             opacity: 1,
    //             left: tooltip.chart.canvas.offsetLeft + tooltip.x + 'px',
    //             top: tooltip.chart.canvas.offsetTop + tooltip.y + 'px',
    //             fontFamily: tooltip.fontFamily,
    //             fontSize: tooltip.fontSize,
    //             fontStyle: tooltip.fontStyle
    //         });
    //     };
    //     var randomScalingFactor = function() {
    //         return Math.round(Math.random() * 100);
    //     };
    //     var lineChartData = {
    //         labels: ["January", "February", "March", "April", "May", "June", "July"],
    //         datasets: [{
    //             label: "My First dataset",
    //             fillColor: "rgba(21,186,103,0.4)",
    //             strokeColor: "rgba(220,220,220,1)",
    //             pointColor: "rgba(66,69,67,0.3)",
    //             pointStrokeColor: "#fff",
    //             pointHighlightFill: "#fff",
    //             pointHighlightStroke: "rgba(220,220,220,1)",
    //             data: [18, 9, 5, 7, 4.5, 4, 5, 4.5, 6, 5.6, 7.5]
    //         }, {
    //             label: "My Second dataset",
    //             fillColor: "rgba(21,113,186,0.5)",
    //             strokeColor: "rgba(151,187,205,1)",
    //             pointColor: "rgba(151,187,205,1)",
    //             pointStrokeColor: "#fff",
    //             pointHighlightFill: "#fff",
    //             pointHighlightStroke: "rgba(151,187,205,1)",
    //             data: [4, 7, 5, 7, 4.5, 4, 5, 4.5, 6, 5.6, 7.5]
    //         }]
    //     };

    //     var doughnutData = [{
    //             value: 300,
    //             color: "#129352",
    //             highlight: "#15BA67",
    //             label: "Alfa"
    //         },
    //         {
    //             value: 50,
    //             color: "#1AD576",
    //             highlight: "#15BA67",
    //             label: "Beta"
    //         },
    //         {
    //             value: 100,
    //             color: "#FDB45C",
    //             highlight: "#15BA67",
    //             label: "Gamma"
    //         },
    //         {
    //             value: 40,
    //             color: "#0F5E36",
    //             highlight: "#15BA67",
    //             label: "Peta"
    //         },
    //         {
    //             value: 120,
    //             color: "#15A65D",
    //             highlight: "#15BA67",
    //             label: "X"
    //         }

    //     ];


    //     var doughnutData2 = [{
    //             value: 100,
    //             color: "#129352",
    //             highlight: "#15BA67",
    //             label: "Alfa"
    //         },
    //         {
    //             value: 250,
    //             color: "#FF6656",
    //             highlight: "#FF6656",
    //             label: "Beta"
    //         },
    //         {
    //             value: 100,
    //             color: "#FDB45C",
    //             highlight: "#15BA67",
    //             label: "Gamma"
    //         },
    //         {
    //             value: 40,
    //             color: "#FD786A",
    //             highlight: "#15BA67",
    //             label: "Peta"
    //         },
    //         {
    //             value: 120,
    //             color: "#15A65D",
    //             highlight: "#15BA67",
    //             label: "X"
    //         }

    //     ];

    //     var barChartData = {
    //         labels: ["January", "February", "March", "April", "May", "June", "July"],
    //         datasets: [{
    //                 label: "My First dataset",
    //                 fillColor: "rgba(21,186,103,0.4)",
    //                 strokeColor: "rgba(220,220,220,0.8)",
    //                 highlightFill: "rgba(21,186,103,0.2)",
    //                 highlightStroke: "rgba(21,186,103,0.2)",
    //                 data: [65, 59, 80, 81, 56, 55, 40]
    //             },
    //             {
    //                 label: "My Second dataset",
    //                 fillColor: "rgba(21,113,186,0.5)",
    //                 strokeColor: "rgba(151,187,205,0.8)",
    //                 highlightFill: "rgba(21,113,186,0.2)",
    //                 highlightStroke: "rgba(21,113,186,0.2)",
    //                 data: [28, 48, 40, 19, 86, 27, 90]
    //             }
    //         ]
    //     };

    //     // window.onload = function() {
    //     //     var ctx = $(".doughnut-chart")[0].getContext("2d");
    //     //     window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {
    //     //         responsive: true,
    //     //         showTooltips: true
    //     //     });

    //     //     var ctx2 = $(".line-chart")[0].getContext("2d");
    //     //     window.myLine = new Chart(ctx2).Line(lineChartData, {
    //     //         responsive: true,
    //     //         showTooltips: true,
    //     //         multiTooltipTemplate: "<%= value %>",
    //     //         maintainAspectRatio: false
    //     //     });

    //     //     var ctx3 = $(".bar-chart")[0].getContext("2d");
    //     //     window.myLine = new Chart(ctx3).Bar(barChartData, {
    //     //         responsive: true,
    //     //         showTooltips: true
    //     //     });

    //     //     var ctx4 = $(".doughnut-chart2")[0].getContext("2d");
    //     //     window.myDoughnut2 = new Chart(ctx4).Doughnut(doughnutData2, {
    //     //         responsive: true,
    //     //         showTooltips: true
    //     //     });

    //     // };

    //     //  end:  Chart =============

    //     // start: Calendar =========
    //     $('.dashboard .calendar').fullCalendar({
    //         header: {
    //             left: 'prev,next today',
    //             center: 'title',
    //             right: 'month,agendaWeek,agendaDay'
    //         },
    //         defaultDate: '2015-02-12',
    //         businessHours: true, // display business hours
    //         editable: true,
    //         events: [{
    //                 title: 'Business Lunch',
    //                 start: '2015-02-03T13:00:00',
    //                 constraint: 'businessHours'
    //             },
    //             {
    //                 title: 'Meeting',
    //                 start: '2015-02-13T11:00:00',
    //                 constraint: 'availableForMeeting', // defined below
    //                 color: '#20C572'
    //             },
    //             {
    //                 title: 'Conference',
    //                 start: '2015-02-18',
    //                 end: '2015-02-20'
    //             },
    //             {
    //                 title: 'Party',
    //                 start: '2015-02-29T20:00:00'
    //             },

    //             // areas where "Meeting" must be dropped
    //             {
    //                 id: 'availableForMeeting',
    //                 start: '2015-02-11T10:00:00',
    //                 end: '2015-02-11T16:00:00',
    //                 rendering: 'background'
    //             },
    //             {
    //                 id: 'availableForMeeting',
    //                 start: '2015-02-13T10:00:00',
    //                 end: '2015-02-13T16:00:00',
    //                 rendering: 'background'
    //             },

    //             // red areas where no events can be dropped
    //             {
    //                 start: '2015-02-24',
    //                 end: '2015-02-28',
    //                 overlap: false,
    //                 rendering: 'background',
    //                 color: '#FF6656'
    //             },
    //             {
    //                 start: '2015-02-06',
    //                 end: '2015-02-08',
    //                 overlap: true,
    //                 rendering: 'background',
    //                 color: '#FF6656'
    //             }
    //         ]
    //     });
    //     // end : Calendar==========

    //     // start: Maps============

    //     jQuery('.maps').vectorMap({
    //         map: 'world_en',
    //         backgroundColor: null,
    //         color: '#fff',
    //         hoverOpacity: 0.7,
    //         selectedColor: '#666666',
    //         enableZoom: true,
    //         showTooltip: true,
    //         values: sample_data,
    //         scaleColors: ['#C8EEFF', '#006491'],
    //         normalizeFunction: 'polynomial'
    //     });

    //     // end: Maps==============

    // })(jQuery);
</script>
<!-- end: Javascript -->
</body>

</html>