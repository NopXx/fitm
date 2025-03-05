@extends('layout.master-new')
@section('title', __('translation.add_new'))
@section('css')

    <!-- filepond css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/image-preview.min.css') }}">

    <!-- editor css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">

    <!-- flatpickr css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datepikar/flatpickr.min.css') }}">

    <!-- slick css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick-theme.css') }}">

@endsection
@section('main-content')
    <style>
        .fade-a-nav .slider-1,
        .fade-a-nav .slider-2,
        .fade-a-nav .slider-3 {
            text-align: center;
            padding: 20px;
            display: flex !important;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 50px;
            /* Adjust this value as needed */
        }

        .fade-a-nav .card-title {
            margin-bottom: 1rem;
        }

        .fade-a-nav .card-text {
            max-width: 80%;
            margin: 0 auto;
        }
    </style>
    <div class="container-fluid">

        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">@lang('new.title')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="#" class="f-s-14 f-w-500">DataTable</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">@lang('translation.add_new')</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Blog Details start -->
        <div class="col-xl-12">
            <div class="card add-blog">
                <div class="card-body">
                    <form action="{{ route('news.store') }}" id="addNewForm" class="app-form" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="content">
                        @csrf
                        <h5>Display New</h5>
                        <div class="row">
                            <!-- Style 1 -->
                            <div class="col-md-4 col-sm-12">
                                <div class="card select-card">
                                    <div class="card-header d-flex align-items-center">
                                        <h5 class="mb-0">Style 1</h5>
                                        <input type="radio" name="display_type" value="1"
                                            class="ms-2 form-check-input" required>
                                    </div>
                                    <div class="card">
                                        <img id="previewStyle1Cover" src="{{ asset('../assets/images/size/600x400.png') }}"
                                            class="card-img-top" alt="Cover Preview">
                                        <div class="card-body">
                                            <h5 class="card-title" id="previewTitle1">@lang('translation.title')</h5>
                                            <p class="card-text" id="previewDetail1">@lang('translation.description')</p>
                                            <p class="card-text"><small class="text-body-secondary">Last updated
                                                    just now</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Style 2 -->
                            <div class="col-md-8 col-sm-12">
                                <div class="card select-card">
                                    <div class="card-header d-flex align-items-center">
                                        <h5 class="mb-0">Style 2</h5>
                                        <input type="radio" name="display_type" value="2"
                                            class="ms-2 form-check-input" required>
                                    </div>
                                    <div class="card-body p-0"> <!-- Changed padding to 0 -->
                                        <div class="fade-a app-arrow">
                                            <div class="item">
                                                <img id="previewStyle2Cover"
                                                    src="{{ asset('../assets/images/size/1200x600.png') }}"
                                                    class="img-fluid" alt="Cover Preview">
                                            </div>
                                            <div class="item">
                                                <img src="{{ asset('../assets/images/size/1200x600.png') }}"
                                                    class="img-fluid" alt="Cover Preview">
                                            </div>
                                            <div class="item">
                                                <img src="{{ asset('../assets/images/size/1200x600.png') }}"
                                                    class="img-fluid" alt="Cover Preview">
                                            </div>
                                        </div>
                                        <div class="slider fade-a-nav app-arrow">
                                            <!-- Added padding for text -->
                                            <div class="slider-1">
                                                <h5 class="card-title" id="previewTitle2">@lang('translation.title')</h5>
                                                <p class="card-text" id="previewDetail2">@lang('translation.description')</p>
                                            </div>
                                            <div class="slider-2">
                                                <h5 class="card-title">@lang('translation.title') 2</h5>
                                                <p class="card-text">@lang('translation.description') 2</p>
                                            </div>
                                            <div class="slider-3">
                                                <h5 class="card-title">@lang('translation.title') 3</h5>
                                                <p class="card-text">@lang('translation.description') 3</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="title" placeholder="Blog Title"
                                        required>
                                    <label>@lang('translation.title')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select form-select-labels" name="new_type" required>
                                        <option value="">@lang('translation.select_type')</option>
                                        @foreach ($newtypes as $newtype)
                                            <option value="{{ $newtype->id }}">{{ $newtype->new_type_name }}</option>
                                        @endforeach
                                    </select>
                                    <label>@lang('translation.type')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="detail" placeholder="Blog Description" required></textarea>
                                    <label>@lang('translation.description')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control basic-date" name="effective_date"
                                        placeholder="YYYY-MM-DD H:i" required>
                                    <label>@lang('translation.effective_date')</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="link"
                                        placeholder="External Link (Optional)">
                                    <label>@lang('translation.external_link')</label>
                                </div>
                            </div>
                            {{-- upload cover --}}
                            <div class="col-md-6">
                                <div class="file-uploader-box mb-3">
                                    <input class="filepond-1" type="file" id="fileupload-2" name="cover"
                                        accept="image/png, image/jpeg, image/gif">

                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select form-select-labels" name="status" required>
                                        <option value="1">@lang('translation.active')</option>
                                        <option value="0">@lang('translation.inactive')</option>
                                    </select>
                                    <label>@lang('translation.status')</label>
                                </div>

                                <!-- Add this right after the status dropdown in add.blade.php -->
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_important"
                                        name="is_important" value="1">
                                    <label class="form-check-label" for="is_important">@lang('translation.mark_as_important')</label>
                                    <div class="form-text">@lang('translation.important_news_note')</div>
                                </div>
                            </div>
                            {{-- editor --}}
                            <div class="col-xl-12 editor-details">
                                <div id="editor">
                                    <p>Hello !</p>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary">@lang('translation.save')</button>
                                    <a href="{{ route('new.index') }}"
                                        class="btn btn-outline-secondary">@lang('translation.cancel')</a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- Blog Details end -->

    </div>
@endsection

@section('script')
    <!--customizer-->
    {{-- <div id="customizer"></div> --}}

    <!-- Trumbowyg js -->
    <script src="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>

    <!-- filepond -->
    <script src="{{ asset('assets/vendor/filepond/file-encode.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/validate-size.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/validate-type.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/exif-orientation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/image-preview.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/filepond.min.js') }}"></script>

    <!-- flatpickr js-->
    <script src="{{ asset('assets/vendor/datepikar/flatpickr.js') }}"></script>
    {{-- flatpickr js th --}}
    <script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>
    @php
        $lang = session()->get('lang') == null ? 'th' : session()->get('lang');
    @endphp
    <script>
        var locale = '{{ $lang }}'
        var csrf = '{{ csrf_token() }}'
        const DEFAULT_IMAGE = "{{ asset('../assets/images/size/600x400.png') }}";
        const DEFAULT_IMAGE_STYLE2 = "{{ asset('../assets/images/size/1200x600.png') }}";
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Title and Detail Inputs
            var titleInput = document.querySelector('input[name="title"]');
            var detailInput = document.querySelector('textarea[name="detail"]');

            // Preview Elements
            var previewTitle1 = document.getElementById("previewTitle1");
            var previewDetail1 = document.getElementById("previewDetail1");
            var previewTitle2 = document.getElementById("previewTitle2");
            var previewDetail2 = document.getElementById("previewDetail2");

            // Cover Upload
            let coverUpload = document.getElementById("fileupload-2");
            var previewStyle1Cover = document.getElementById("previewStyle1Cover");
            var previewStyle2Cover = document.getElementById("previewStyle2Cover");

            // Update Title Preview
            titleInput.addEventListener("input", function() {
                previewTitle1.textContent = this.value || "@lang('translation.title')";
                previewTitle2.textContent = this.value || "@lang('translation.title')";
            });

            // Update Detail Preview
            detailInput.addEventListener("input", function() {
                previewDetail1.textContent = this.value || "@lang('translation.description')";
                previewDetail2.textContent = this.value || "@lang('translation.description')";
            });
        });
    </script>

    <!-- add blog js  -->
    <script src="{{ asset('assets/js/add_new_init.js') }}"></script>

    <!-- slick-file -->
    <script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>

    <!--  js -->
    <script src="{{ asset('assets/js/slick.js') }}"></script>
@endsection
