@extends('backend.app')
@section('content')
<div class="main-content">

    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add Order</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="index-2.html">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="all-product.html">
                            <div class="text-tiny">Order</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add Order</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-order -->

            <!-- /form-add-order -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    @endsection
    @push('scripts')
    <script>
        $(function() {

        });

    </script>
    @endpush
