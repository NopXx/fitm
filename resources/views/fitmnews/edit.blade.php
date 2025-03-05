@extends('layout.master-new')
@section('title', __('fitmnews.edit_news'))
@section('css')
    <!-- Remove filepond css -->

    <!-- flatpickr css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datepikar/flatpickr.min.css') }}">

    <!-- slick css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick-theme.css') }}">

    <!-- Custom file input preview style -->
    <style>
        .custom-file-container {
            border: 2px dashed #ccc;
            border-radius: 6px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .custom-file-container:hover {
            border-color: #6c757d;
        }

        .image-preview-container {
            margin-top: 15px;
            position: relative;
        }

        .image-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 4px;
        }

        .remove-image-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            cursor: pointer;
            color: #dc3545;
        }

        .remove-image-btn:hover {
            background: rgba(255, 255, 255, 1);
        }
    </style>
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
                <h4 class="main-title">@lang('fitmnews.edit_news')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('fitmnews.index') }}">@lang('fitmnews.title')</a></li>
                    <li class="active">@lang('translation.edit')</li>
                </ul>
            </div>
        </div>

        <!-- Form -->
        <div class="col-xl-12">
            <div class="card add-blog">
                <div class="card-body">
                    <form action="{{ route('fitmnews.update', $news->id) }}" id="editFitmNewsForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="issue_name"
                                        value="{{ old('issue_name', $news->issue_name) }}" required>
                                    <label>@lang('fitmnews.issue_name')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="title"
                                        value="{{ old('title', $news->title) }}" required>
                                    <label>@lang('translation.title')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="description">{{ old('description', $news->description) }}</textarea>
                                    <label>@lang('translation.description')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control basic-date" name="published_date"
                                        value="{{ old('published_date', $news->published_date ? \Carbon\Carbon::parse($news->published_date)->format('Y-m-d H:i') : '') }}"
                                        required>
                                    <label>@lang('fitmnews.published_date')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="url"
                                        value="{{ old('url', $news->url) }}">
                                    <label>@lang('translation.external_link')</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="custom-file-container" onclick="document.getElementById('cover_image').click()">
                                    <div class="mb-3">
                                        <i class="fa fa-cloud-upload fa-3x mb-2"></i>
                                        <h5>@lang('fitmnews.drag_or_click')</h5>
                                        <p class="text-muted">@lang('fitmnews.supported_formats'): PNG, JPG, GIF</p>
                                        <input type="file" id="cover_image" name="cover_image"
                                            accept="image/png, image/jpeg, image/gif" class="d-none"
                                            data-file="{{ $news->cover_image ? asset('storage/' . $news->cover_image) : '' }}">
                                        <!-- Hidden input to track if file was changed -->
                                        <input type="hidden" id="file_changed" name="file_changed" value="0">
                                    </div>

                                    <div id="image-preview-container" class="image-preview-container d-none">
                                        <img id="image-preview" class="image-preview" src="" alt="Preview">
                                        <div id="remove-image" class="remove-image-btn"><i class="fa fa-times"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary">@lang('translation.save')</button>
                                    <a href="{{ route('fitmnews.index') }}"
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
    <!-- Remove FilePond scripts -->

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

    <!-- edit preview js -->
    <script src="{{ asset('assets/js/fitmnews_edit_init.js') }}"></script>

    <!-- slick-file -->
    <script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>

    <!--  js -->
    <script src="{{ asset('assets/js/slick.js') }}"></script>
@endsection
