@extends('layout.master-new')
@section('title', __('content.edit_title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    @vite(['resources/css/tinymce-content.css'])
    <style>
        /* TinyMCE Editor Styles */
        .tox-tinymce {
            min-height: 700px !important;
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
            min-height: 650px !important;
            height: 100% !important;
            flex: 1 1 auto !important;
            overflow: visible !important;
            position: relative !important;
        }

        /* Remove resize handle */
        .tox-statusbar__resize-handle {
            display: none !important;
        }

        /* Preview styles */
        .content-preview img {
            max-width: 100%;
            height: auto;
        }

        #previewContent {
            margin: 0 auto;
            transition: width 0.3s ease, height 0.3s ease;
            border: 1px solid #ddd;
            padding: 1rem;
        }

        /* TinyMCE table styles */
        .tox .tox-collection__item-icon {
            color: inherit !important;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('content.edit_content')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('contents.index') }}" class="f-s-14 f-w-500">
                            <span>@lang('translation.data_management')</span>
                        </a>
                    </li>
                    <li>
                        <span>@lang('content.edit_content')</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="editForm" method="POST"
                        action="{{ route('contents.update', ['content' => $content->id]) }}">
                        @csrf
                        @method('PUT')

                        <!-- Common Fields -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">@lang('content.code')</label>
                                <input type="text" class="form-control" name="code" value="{{ $content->code }}"
                                    required>
                                <small class="text-muted">@lang('content.code_help')</small>
                            </div>
                        </div>

                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs mb-3" id="languageTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="thai-tab" data-bs-toggle="tab"
                                    data-bs-target="#thai-content" type="button" role="tab"
                                    aria-controls="thai-content" aria-selected="true">
                                    @lang('translation.thai_information')
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="english-tab" data-bs-toggle="tab"
                                    data-bs-target="#english-content" type="button" role="tab"
                                    aria-controls="english-content" aria-selected="false">
                                    @lang('translation.english_information')
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="languageTabsContent">
                            <!-- Thai Content Tab -->
                            <div class="tab-pane fade show active" id="thai-content" role="tabpanel"
                                aria-labelledby="thai-tab">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label class="form-label">@lang('content.title_th')</label>
                                        <input type="text" class="form-control" name="title_th"
                                            value="{{ $content->title_th }}" required>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label">@lang('content.detail_th')</label>
                                        <textarea id="detail_th" name="detail_th">{{ $content->detail_th }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- English Content Tab -->
                            <div class="tab-pane fade" id="english-content" role="tabpanel" aria-labelledby="english-tab">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label class="form-label">@lang('content.title_en')</label>
                                        <input type="text" class="form-control" name="title_en"
                                            value="{{ $content->title_en }}" required>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label">@lang('content.detail_en')</label>
                                        <textarea id="detail_en" name="detail_en">{{ $content->detail_en }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">@lang('content.save')</button>
                                <a href="{{ route('contents.index') }}" class="btn btn-secondary">@lang('content.cancel')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('content.preview_title')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="previewContent" class="department-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- sweetalert js-->
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
    <script>
        var csrf_token = '{{ csrf_token() }}';
        var media_url = '{{ route('media.upload') }}';
        // For edit page, set the content ID if available
        var contentId = {{ $content->id ?? 'undefined' }};
    </script>
    <script src="{{ asset('assets/js/content_tinymce_init.js') }}"></script>
@endsection
