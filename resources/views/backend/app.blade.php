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
    <style>
        .product-item {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 15px;
            transition: all 0.3s ease;
            padding: 10px 15px;
            /* Adjusted padding for better spacing */
            border-radius: 8px;
            background-color: #fff;
            /* Added a white background */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Added subtle shadow */
            cursor: pointer;
            /* Pointer cursor to indicate clickable item */
        }

        .product-item:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
            /* Elevate shadow on hover */
            transform: translateY(-2px);
            /* Slight lift on hover */
        }

        .product-item .image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            /* Slightly increased size */
            height: 60px;
            /* Slightly increased size */
            gap: 10px;
            flex-shrink: 0;
            padding: 5px;
            border-radius: 12px;
            /* Slightly more rounded corners */
            background: #EFF4F8;
        }

        .product-item .name {
            font-size: 16px;
            /* Improved font size */
            font-weight: 500;
            /* Increased font weight */
            color: #333;
            /* Darker text color for readability */
        }

        #box-content-search li {
            list-style: none;
        }

        #box-content-search .product-item {
            margin-bottom: 15px;
            /* Increased spacing between items */
        }

        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 10px 0;
            /* Added spacing around the divider */
        }
    </style>
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
    <script>
        $(function() {
            $('#search-input').on("keyup", function() {
                var searchQuery = $(this).val();

                if (searchQuery.length > 2) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('search') }}", // Correct Blade syntax for route
                        data: {
                            query: searchQuery
                        },
                        dataType: "json", // Corrected dataType to a string
                        success: function(data) {
                            $('#box-content-search').html(''); // Clear previous results
                            $.each(data, function(index, item) {
                                // console.log(item);

                                var url = "{{ route('product.edit', ['id' => ':product_id']) }}"; // Use route helper
                                var link = url.replace(':product_id', item.id); // Replace slug placeholder with actual slug

                                $('#box-content-search').append(`
                        <li>
                            <ul>
                                <li class="product-item gap14 mb-10">
                                    <div>${index + 1}</div>
                                    <div class="image no-bg">
                                        <img src="{{ asset('uploads/products/thumbnails/') }}/${item.image}" alt="${item.name}">
                                    </div>
                                    <div class="flex items-center justify-between gap20 flex-grow">
                                        <div class="name">
                                            <a href="${link}" class="body-text">${item.name}</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-10">
                                    <div class="divider"></div>
                                </li>
                            </ul>
                        </li>
                    `);
                            });
                        }
                    });
                } else {
                    // If search query is less than 3 characters, clear the search results
                    $('#box-content-search').html('');
                }
            });

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('scripts')
</body>

</html>