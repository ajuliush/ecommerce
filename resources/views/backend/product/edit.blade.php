@extends('backend.app')
@section('content')
<div class="main-content">

    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Product</h3>
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
                            <div class="text-tiny">Products</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Product</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('product.update', $product->id) }}">
                @csrf
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0" value="{{ old('name',$product->name) }}" aria-required="true">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('name')
                    <span class="alert alert-danger text-center">{{ $message}}</span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0" value="{{ old('slug', $product->slug) }}" aria-required="true">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('slug')
                    <span class="alert alert-danger text-center">{{ $message}}</span>
                    @enderror
                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="select2" name="category_id">
                                    <option value="">Choose category</option>
                                    @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" {{ old('category_id', isset($product) ? $product->category_id : '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('category_id')
                        <span class="alert alert-danger text-center">{{ $message}}</span>
                        @enderror
                        <fieldset class="brand">
                            <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="select2" name="brand_id">
                                    <option value="">Choose Brand</option>
                                    @foreach ($brands as $item)
                                    <option value="{{ $item->id }}" {{ old('brand_id', isset($product) ? $product->brand_id : '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('brand_id')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                    </div>

                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0" aria-required="true">{{ old('short_description', $product->short_description) }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('short_description')
                    <span class="alert alert-danger text-center">{{ $message}}</span>
                    @enderror
                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                        </div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true">{{ old('description', $product->description) }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('description')
                    <span class="alert alert-danger text-center">{{ $message}}</span>
                    @enderror
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span>
                        </div>
                        <div class="upload-image flex-grow">
                            @if ($product->image)
                            <div class="item" id="imgpreview">
                                <img src="{{ asset('uploads/products/' . $product->image) }}" class="effect8" alt="">
                            </div>
                            @else
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="../../../localhost_8000/images/upload/upload-1.png" class="effect8" alt="">
                            </div>
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16">
                            <div id="existingImages" class="item up-load">
                                @if ($product->images)
                                @foreach (explode(',', $product->images) as $item)
                                <div class="item">
                                    <img src="{{ asset('uploads/products/' . trim($item)) }}" alt="">
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('images')
                    <span class="alert alert-danger text-center">{{ $message}}</span>
                    @enderror
                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter regular price" name="regular_price" tabindex="0" value="{{ old('regular_price', $product->regular_price) }}" aria-required="true">
                        </fieldset>
                        @error('regular_price')
                        <span class="alert alert-danger text-center">{{ $message}}</span>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price" tabindex="0" value="{{ old('sale_price', $product->sale_price) }}" aria-required="true">
                        </fieldset>
                        @error('sale_price')
                        <span class="alert alert-danger text-center">{{ $message}}</span>
                        @enderror
                    </div>


                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU" tabindex="0" value="{{ old('SKU', $product->SKU) }}" aria-required="true">
                        </fieldset>
                        @error('SKU')
                        <span class="alert alert-danger text-center">{{ $message}}</span>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter quantity" name="quantity" tabindex="0" value="{{ old('quantity', $product->quantity) }}" aria-required="true">
                        </fieldset>
                        @error('quantity')
                        <span class="alert alert-danger text-center">{{ $message}}</span>
                        @enderror
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="instock" {{ old('stock_status', isset($product) ? $product->stock_status : '') == 'instock' ? 'selected' : '' }}>InStock</option>
                                    <option value="outofstock" {{ old('stock_status', isset($product) ? $product->stock_status : '') == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('stock_status')
                        <span class="alert alert-danger text-center">{{ $message}}</span>
                        @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select name="featured" class="">
                                    <option value="0" {{ old('featured', isset($product) ? $product->featured : '') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('featured', isset($product) ? $product->featured : '') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('featured')
                        <span class="alert alert-danger text-center">{{ $message}}</span>
                        @enderror
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Add product</button>
                    </div>
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
