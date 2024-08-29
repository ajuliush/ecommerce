@extends('backend.app')
@section('content')
<div class="main-content">

    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Coupon</h3>
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
                        <div class="text-tiny">Edit Coupon</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="form-new-product form-style-1" method="POST" action="{{ route('coupon.update', $coupon->id) }}">
                @csrf
                <fieldset class="name">
                    <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Coupon Code" name="code" tabindex="0" value="{{ old('code', $coupon->code) }}" aria-required="true" required="">
                </fieldset>
                @error('code')
                <span class="alert alert-danger text-center">{{ $message}}</span>
                @enderror
                <fieldset class="category">
                    <div class="body-title">Coupon Type</div>
                    <div class="select flex-grow">
                        <select class="select2" name="type" name="type" id="type">
                            <option value="">Select</option>
                            <option value="fixed" {{ old('type', isset($coupon) ? $coupon->type : '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="percent" {{ old('type', isset($coupon) ? $coupon->type : '') == 'percent' ? 'selected' : '' }}>Percent</option>
                        </select>
                    </div>
                </fieldset>
                @error('type')
                <span class="alert alert-danger text-center">{{ $message}}</span>
                @enderror
                <fieldset class="name">
                    <div class="body-title">Value <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Coupon Value" name="value" tabindex="0" value="{{ old('value', $coupon->value) }}" aria-required="true" required="">
                </fieldset>
                @error('value')
                <span class="alert alert-danger text-center">{{ $message}}</span>
                @enderror
                <fieldset class="name">
                    <div class="body-title">Cart Value <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Cart Value" name="cart_value" tabindex="0" value="{{ old('cart_value', $coupon->cart_value) }}" aria-required="true" required="">
                </fieldset>
                @error('cart_value')
                <span class="alert alert-danger text-center">{{ $message}}</span>
                @enderror
                <fieldset class="name">
                    <div class="body-title">Expiry Date <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="date" placeholder="Expiry Date" name="expiry_date" tabindex="0" value="{{ old('expiry_date', $coupon->expiry_date) }}" aria-required="true" required="">
                </fieldset>
                @error('expiry_date')
                <span class="alert alert-danger text-center">{{ $message}}</span>
                @enderror
                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update</button>
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
                // Hide existing images when a new image is uploaded
                $("#existingImages").hide();

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
