<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <title>SurfsideMedia</title>
    <meta charset="utf-8">
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/animation.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/font/fonts.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/icon/style.css">
    <link rel="shortcut icon" href="{{ asset('backend') }}/images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('backend') }}/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/sweetalert.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/custom.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('styles')
</head>

<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                <!-- <div id="preload" class="preload-container">
    <div class="preloading">
        <span></span>
    </div>
</div> -->

                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="index.html" id="site-logo-inner">
                            <img class="" id="logo_header" alt="" src="{{ asset('backend') }}/images/logo/logo.png" data-light="{{ asset('backend') }}/images/logo/logo.png" data-dark="{{ asset('backend') }}/images/logo/logo.png">
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    @include('backend.sidebar')
                </div>

                <div class="section-content-right">

                    @include('backend.header')

                    @yield('content')
                    @include('backend.footer')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend') }}/js/jquery.min.js"></script>
    <script src="{{ asset('backend') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend') }}/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('backend') }}/js/sweetalert.min.js"></script>
    <script src="{{ asset('backend') }}/js/apexcharts/apexcharts.js"></script>
    <script src="{{ asset('backend') }}/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        (function($) {

            var tfLineChart = (function() {

                var chartBar = function() {

                    var options = {
                        series: [{
                                name: 'Total'
                                , data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00, 0.00, 0.00, 0.00]
                            }, {
                                name: 'Pending'
                                , data: [0.00, 0.00, 0.00, 0.00, 0.00, 273.22, 208.12, 0.00, 0.00, 0.00, 0.00, 0.00]
                            }
                            , {
                                name: 'Delivered'
                                , data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00]
                            }, {
                                name: 'Canceled'
                                , data: [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00]
                            }
                        ]
                        , chart: {
                            type: 'bar'
                            , height: 325
                            , toolbar: {
                                show: false
                            , }
                        , }
                        , plotOptions: {
                            bar: {
                                horizontal: false
                                , columnWidth: '10px'
                                , endingShape: 'rounded'
                            }
                        , }
                        , dataLabels: {
                            enabled: false
                        }
                        , legend: {
                            show: false
                        , }
                        , colors: ['#2377FC', '#FFA500', '#078407', '#FF0000']
                        , stroke: {
                            show: false
                        , }
                        , xaxis: {
                            labels: {
                                style: {
                                    colors: '#212529'
                                , }
                            , }
                            , categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                        , }
                        , yaxis: {
                            show: false
                        , }
                        , fill: {
                            opacity: 1
                        }
                        , tooltip: {
                            y: {
                                formatter: function(val) {
                                    return "$ " + val + ""
                                }
                            }
                        }
                    };

                    chart = new ApexCharts(
                        document.querySelector("#line-chart-8")
                        , options
                    );
                    if ($("#line-chart-8").length > 0) {
                        chart.render();
                    }
                };

                /* Function ============ */
                return {
                    init: function() {},

                    load: function() {
                        chartBar();
                    }
                    , resize: function() {}
                , };
            })();

            jQuery(document).ready(function() {});

            jQuery(window).on("load", function() {
                tfLineChart.load();
            });

            jQuery(window).on("resize", function() {});
        })(jQuery);

    </script>
    @stack('scripts')
</body>

</html>
