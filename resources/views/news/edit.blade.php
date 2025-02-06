@extends('layout.master-new')
@section('title', __('new.edit_new'))
@section('css')
    <!-- เพิ่ม CSS เหมือนหน้า add -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/image-preview.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datepikar/flatpickr.min.css') }}">

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
        <!-- Breadcrumb -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('new.edit_new')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('new.index') }}">@lang('translation.news')</a></li>
                    <li class="active">@lang('translation.edit')</li>
                </ul>
            </div>
        </div>

        <!-- Form -->
        <div class="col-xl-12">
            <div class="card add-blog">
                <div class="card-body">
                    <form action="{{ route('new.update', $new->id) }}" id="editNewForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="content" value="{{ old('content', $new->content) }}">

                        <h5>Display New</h5>
                        <div class="row">
                            <!-- Style 1 -->
                            <div class="col-md-4 col-sm-12">
                                <div class="card select-card">
                                    <div class="card-header d-flex align-items-center">
                                        <h5 class="mb-0">Style 1</h5>
                                        <input type="radio" name="display_type" value="1"
                                            class="ms-2 form-check-input" {{ $new->display_type == 1 ? 'checked' : '' }}
                                            required>
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
                                            class="ms-2 form-check-input" {{ $new->display_type == 2 ? 'checked' : '' }}
                                            required>
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
                                    <input type="text" class="form-control" name="title"
                                        value="{{ old('title', $new->title) }}" required>
                                    <label>@lang('translation.title')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select" name="new_type" required>
                                        <option value="">@lang('translation.select_type')</option>
                                        @foreach ($newtypes as $newtype)
                                            <option value="{{ $newtype->id }}" {{ $new->new_type == $newtype->id ? 'selected' : '' }}>{{ $newtype->new_type_name }}</option>
                                        @endforeach
                                    </select>
                                    <label>@lang('translation.type')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="detail" required>{{ old('detail', $new->detail) }}</textarea>
                                    <label>@lang('translation.description')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control basic-date" name="effective_date"
                                        value="{{ old('effective_date', $new->effective_date ? \Carbon\Carbon::parse($new->effective_date)->format('Y-m-d H:i') : '') }}"
                                        required>
                                    <label>@lang('translation.effective_date')</label>
                                </div>


                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="link"
                                        value="{{ old('link', $new->link) }}">
                                    <label>@lang('translation.external_link')</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="file-uploader-box mb-3">
                                    <input class="filepond-1" type="file" id="fileupload-2" name="cover"
                                        accept="image/png, image/jpeg, image/gif"
                                        data-file="{{ $new->cover ? asset('storage/' . $new->cover) : '' }}">

                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select" name="status" required>
                                        <option value="1" {{ $new->status ? 'selected' : '' }}>@lang('translation.active')
                                        </option>
                                        <option value="0" {{ !$new->status ? 'selected' : '' }}>@lang('translation.inactive')
                                        </option>
                                    </select>
                                    <label>@lang('translation.status')</label>
                                </div>
                            </div>

                            <div class="col-xl-12 editor-details">
                                <div id="editor">{!! old('content', $new->content) !!}</div>
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
    </div>
@endsection

@section('script')

    <!-- Trumbowyg js -->
    <script src="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>

    <!-- Load FilePond core first -->
    <script src="{{ asset('assets/vendor/filepond/filepond.min.js') }}"></script>
    <!-- Then load plugins -->
    <script src="{{ asset('assets/vendor/filepond/file-encode.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/validate-size.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/validate-type.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/exif-orientation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/image-preview.min.js') }}"></script>

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
    </script>

    <script>
        // กำหนดค่าเริ่มต้นให้ FilePond
        var existingFile = document.querySelector('input[name="cover"]').dataset.file;
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

            previewTitle1.textContent = titleInput.value || "@lang('translation.title')";
            previewTitle2.textContent = titleInput.value || "@lang('translation.title')";
            previewDetail1.textContent = detailInput.value || "@lang('translation.description')";
            previewDetail2.textContent = detailInput.value || "@lang('translation.description')";

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

    <!-- ใช้สคริปต์เดียวกันกับหน้า add แต่ปรับ id form -->
    <script src="{{ asset('assets/js/edit_new_init.js') }}"></script>
    <script>
        // เปลี่ยน selector เป็น form edit
        document.getElementById('editNewForm').addEventListener('submit', function(e) {
            document.querySelector('input[name="content"]').value = $('#editor').trumbowyg('html');
        });
    </script>

    <!-- slick-file -->
    <script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>

    <!--  js -->
    <script src="{{ asset('assets/js/slick.js') }}"></script>
@endsection
