@extends('backend.app')
@section('content')
<div class="main-content">

    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add SLider</h3>
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
                            <div class="text-tiny">SLider</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add SLider</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="form-new-product form-style-1" action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Tag Line -->
                <fieldset class="name">
                    <div class="body-title">Tag Line <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Tag Line" name="tagline" value="{{ old('tagline') }}" aria-required="true" required>
                    @error('tagline')
                    <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </fieldset>

                <!-- Title -->
                <fieldset class="name">
                    <div class="body-title">Title <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Title" name="title" value="{{ old('title') }}" aria-required="true" required>
                    @error('title')
                    <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </fieldset>

                <!-- Sub Title -->
                <fieldset class="name">
                    <div class="body-title">Sub Title <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Sub Title" name="subtitle" value="{{ old('subtitle') }}" aria-required="true" required>
                    @error('subtitle')
                    <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </fieldset>

                <!-- Upload Image -->
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="" class="effect8" alt="">
                        </div>
                        <div class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                    @error('image')
                    <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </fieldset>

                <!-- Link -->
                <fieldset class="name">
                    <div class="body-title">Link <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="url" placeholder="Link" name="link" value="{{ old('link') }}" aria-required="true" required>
                    @error('link')
                    <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </fieldset>

                <!-- Status -->
                <fieldset class="category">
                    <div class="body-title">Select category icon</div>
                    <div class="select flex-grow">
                        <select name="status">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    @error('status')
                    <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </fieldset>

                <!-- Submit Button -->
                <div class="bot">
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
        });

    </script>
    @endpush
