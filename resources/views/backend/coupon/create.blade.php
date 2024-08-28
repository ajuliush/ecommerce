@extends('backend.app')
@section('content')
<div class="main-content">

    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add Product</h3>
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
                            <div class="text-tiny">Coupons</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add Coupon</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="form-new-product form-style-1" method="POST" action="#">
                <fieldset class="name">
                    <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Coupon Code" name="code" tabindex="0" value="" aria-required="true" required="">
                </fieldset>
                <fieldset class="category">
                    <div class="body-title">Coupon Type</div>
                    <div class="select flex-grow">
                        <select class="select2" name="type">
                            <option value="">Select</option>
                            <option value="fixed">Fixed</option>
                            <option value="percent">Percent</option>
                        </select>
                    </div>
                </fieldset>
                <fieldset class="name">
                    <div class="body-title">Value <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Coupon Value" name="value" tabindex="0" value="" aria-required="true" required="">
                </fieldset>
                <fieldset class="name">
                    <div class="body-title">Cart Value <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Cart Value" name="cart_value" tabindex="0" value="" aria-required="true" required="">
                </fieldset>
                <fieldset class="name">
                    <div class="body-title">Expiry Date <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="date" placeholder="Expiry Date" name="expiry_date" tabindex="0" value="" aria-required="true" required="">
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    @endsection
    @push('scripts')
    <script>
        $(function() {
            $("#myFile").on("change", function(e) {
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });
            $("#gFile").on("change", function(e) {
                const gphotos = this.files;
                $.each(gphotos, function(key, val) {
                    const imgURL = URL.createObjectURL(val);
                    const imageItem = `
            <div class="item gitems" style="position: relative; display: inline-block; margin: 5px;">
                <img src="${imgURL}" style="width: 104px; height: 104px;" />
                <span class="remove-image" style="position: absolute; top: 0; right: 0; background: rgba(255, 0, 0, 0.7); color: white; padding: 5px; cursor: pointer;">&times;</span>
            </div>
        `;
                    $("#galUpload").prepend(imageItem);
                });

                // Event delegation for removing images
                $("#galUpload").on("click", ".remove-image", function() {
                    $(this).parent().remove();
                });
            });



            $("input[name='name']").on("change", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w]+/g, "") // Fixed the regular expression
                .replace(/\s+/g, "-"); // Fixed the replacement for spaces
        }
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Choose category"
                , allowClear: true
            });
        });

    </script>
    @endpush
