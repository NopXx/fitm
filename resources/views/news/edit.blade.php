@extends('layout.master-new')
@section('title', __('new.edit_new'))
@section('css')
    <!-- filepond css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/image-preview.min.css') }}">

    <!-- TinyMCE -->
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"
        referrerpolicy="origin"></script>

    <!-- flatpickr css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datepikar/flatpickr.min.css') }}">

    <!-- slick css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick-theme.css') }}">

    <style>
        /* TinyMCE Editor Styles */
        .tox-tinymce {
            min-height: 600px !important;
            height: auto !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: visible !important;
        }

        .tox-editor-container {
            flex: 1 1 auto !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: visible !important;
        }

        .tox-edit-area,
        .tox-edit-area__iframe {
            min-height: 350px !important;
            height: 100% !important;
            flex: 1 1 auto !important;
            overflow: visible !important;
            position: relative !important;
        }

        /* Remove resize handle */
        .tox-statusbar__resize-handle {
            display: none !important;
        }

        /* Fade slider styles */
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
        }

        .fade-a-nav .card-title {
            margin-bottom: 1rem;
        }

        .fade-a-nav .card-text {
            max-width: 80%;
            margin: 0 auto;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('new.edit_new')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('new.index') }}" class="f-s-14 f-w-500">@lang('translation.news')</a></li>
                    <li class="active"><span class="f-s-14 f-w-500">@lang('translation.edit')</span></li>
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
                        <input type="hidden" name="content_th" value="{{ old('content_th', $new->content_th) }}">
                        <input type="hidden" name="content_en" value="{{ old('content_en', $new->content_en) }}">

                        <h5>@lang('translation.display_new')</h5>
                        <div class="row">
                            <!-- Style 1 -->
                            <div class="col-md-4 col-sm-12">
                                <div class="card select-card {{ $new->display_type == 1 ? 'border-primary' : '' }}">
                                    <div class="card-header d-flex align-items-center">
                                        <h5 class="mb-0">@lang('translation.style') 1</h5>
                                        <input type="radio" name="display_type" value="1"
                                            class="ms-2 form-check-input" {{ $new->display_type == 1 ? 'checked' : '' }}
                                            required>
                                    </div>
                                    <div class="card">
                                        <img id="previewStyle1Cover"
                                            src="{{ $new->cover ? asset('storage/' . $new->cover) : asset('../assets/images/size/600x400.png') }}"
                                            class="card-img-top" alt="Cover Preview">
                                        <div class="card-body">
                                            <h5 class="card-title" id="previewTitle1">{{ $new->title }}</h5>
                                            <p class="card-text" id="previewDetail1">{{ $new->detail }}</p>
                                            <p class="card-text"><small class="text-body-secondary">@lang('translation.last_updated')
                                                    @lang('translation.just_now')</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Style 2 -->
                            <div class="col-md-8 col-sm-12">
                                <div class="card select-card {{ $new->display_type == 2 ? 'border-primary' : '' }}">
                                    <div class="card-header d-flex align-items-center">
                                        <h5 class="mb-0">@lang('translation.style') 2</h5>
                                        <input type="radio" name="display_type" value="2"
                                            class="ms-2 form-check-input" {{ $new->display_type == 2 ? 'checked' : '' }}
                                            required>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="fade-a app-arrow">
                                            <div class="item">
                                                <img id="previewStyle2Cover"
                                                    src="{{ $new->cover ? asset('storage/' . $new->cover) : asset('../assets/images/size/1200x600.png') }}"
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
                                                <h5 class="card-title" id="previewTitle2">{{ $new->title }}</h5>
                                                <p class="card-text" id="previewDetail2">{{ $new->detail }}</p>
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

                        <!-- Information Tabs (Thai/English) -->
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-pills mb-3" id="infoTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active d-flex align-items-center" id="thai-info-tab"
                                            data-bs-toggle="pill" data-bs-target="#thai-info" type="button"
                                            role="tab">
                                            <span class="badge bg-primary me-2">TH</span> @lang('translation.thai_information')
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link d-flex align-items-center" id="english-info-tab"
                                            data-bs-toggle="pill" data-bs-target="#english-info" type="button"
                                            role="tab">
                                            <span class="badge bg-secondary me-2">EN</span> @lang('translation.english_information_optional')
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content p-3 border rounded" id="infoTabsContent">
                                    <!-- Thai Information Tab -->
                                    <div class="tab-pane fade show active" id="thai-info" role="tabpanel"
                                        aria-labelledby="thai-info-tab">
                                        <div class="mb-3">
                                            <label for="title_th" class="form-label">@lang('translation.title_th')</label>
                                            <input type="text" class="form-control" id="title_th" name="title_th"
                                                value="{{ old('title_th', $new->title_th) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="detail_th" class="form-label">@lang('translation.description_th')</label>
                                            <textarea class="form-control" id="detail_th" name="detail_th" rows="5" required>{{ old('detail_th', $new->detail_th) }}</textarea>
                                        </div>
                                    </div>

                                    <!-- English Information Tab -->
                                    <div class="tab-pane fade" id="english-info" role="tabpanel"
                                        aria-labelledby="english-info-tab">
                                        <div class="mb-3">
                                            <label for="title_en" class="form-label">@lang('translation.title_en')</label>
                                            <input type="text" class="form-control" id="title_en" name="title_en"
                                                value="{{ old('title_en', $new->title_en) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="detail_en" class="form-label">@lang('translation.description_en')</label>
                                            <textarea class="form-control" id="detail_en" name="detail_en" rows="5">{{ old('detail_en', $new->detail_en) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Common fields - before the tabs -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="effective_date" class="form-label">@lang('translation.display_date')</label>
                                    <input type="text" class="form-control basic-date" name="effective_date"
                                        value="{{ old('effective_date', $new->effective_date ? \Carbon\Carbon::parse($new->effective_date)->format('Y-m-d H:i') : '') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="link" class="form-label">@lang('translation.external_link')</label>
                                    <input type="text" class="form-control" id="link" name="link"
                                        value="{{ old('link', $new->link) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="new_type" class="form-label">@lang('translation.type')</label>
                                    <select class="form-select" name="new_type" required>
                                        <option value="">@lang('translation.select_type')</option>
                                        @foreach ($newtypes as $newtype)
                                            <option value="{{ $newtype->id }}"
                                                {{ $new->new_type == $newtype->id ? 'selected' : '' }}>
                                                {{ $newtype->new_type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">@lang('translation.status')</label>
                                    <select class="form-select" name="status" required>
                                        <option value="1" {{ $new->status ? 'selected' : '' }}>@lang('translation.active')
                                        </option>
                                        <option value="0" {{ !$new->status ? 'selected' : '' }}>@lang('translation.inactive')
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_important"
                                        name="is_important" value="1" {{ $new->is_important ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_important">@lang('translation.mark_as_important')</label>
                                    <div class="form-text">@lang('translation.important_news_note')</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="file-uploader-box mb-3">
                                    <input class="filepond-1" type="file" id="fileupload-2" name="cover"
                                        accept="image/png, image/jpeg, image/gif"
                                        data-file="{{ $new->cover ? asset('storage/' . $new->cover) : '' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Content Tabs (Thai/English) -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <ul class="nav nav-pills mb-3" id="contentTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active d-flex align-items-center" id="thai-content-tab"
                                            data-bs-toggle="pill" data-bs-target="#thai-content" type="button"
                                            role="tab">
                                            <span class="badge bg-primary me-2">TH</span> @lang('translation.thai_content')
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link d-flex align-items-center" id="english-content-tab"
                                            data-bs-toggle="pill" data-bs-target="#english-content" type="button"
                                            role="tab">
                                            <span class="badge bg-secondary me-2">EN</span> @lang('translation.english_content_optional')
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content border rounded" id="contentTabsContent">
                                    <!-- Thai Content Tab -->
                                    <div class="tab-pane fade show active" id="thai-content" role="tabpanel"
                                        aria-labelledby="thai-content-tab">
                                        <div id="editor-th">{!! old('content_th', $new->content_th) !!}</div>
                                    </div>

                                    <!-- English Content Tab -->
                                    <div class="tab-pane fade" id="english-content" role="tabpanel"
                                        aria-labelledby="english-content-tab">
                                        <div id="editor-en">{!! old('content_en', $new->content_en) !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
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
    <!-- filepond -->
    <script src="{{ asset('assets/vendor/filepond/file-encode.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/validate-size.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/validate-type.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/exif-orientation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/image-preview.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/filepond.min.js') }}"></script>

    <!-- flatpickr js-->
    <script src="{{ asset('assets/vendor/datepikar/flatpickr.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>

    @php
        $lang = session()->get('lang') == null ? 'th' : session()->get('lang');
    @endphp
    <script>
        var locale = '{{ $lang }}';
        var csrf = '{{ csrf_token() }}';
        const DEFAULT_IMAGE = "{{ asset('../assets/images/size/600x400.png') }}";
        const DEFAULT_IMAGE_STYLE2 = "{{ asset('../assets/images/size/1200x600.png') }}";
        var existingFile = '{{ $new->cover ? asset('storage/' . $new->cover) : '' }}';

        // Browse link for filepond
        document.addEventListener('DOMContentLoaded', function() {
            const browseLink = document.querySelector('.browse-link');
            if (browseLink) {
                browseLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector('input[type="file"]').click();
                });
            }
        });
    </script>

    <!-- Title and Detail Preview Script -->
    <script src="{{ asset('assets/js/news_preview.js') }}"></script>

    <!-- TinyMCE Integration -->
    <script>
        // For edit page, set the news ID for image uploads
        var editNewsId = {{ $new->id }};
        var media_url = '{{ route('media.upload') }}'
    </script>
    <script src="{{ asset('assets/js/news_tinymce_init.js') }}"></script>

    <!-- slick-file -->
    <script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.js') }}"></script>
@endsection
