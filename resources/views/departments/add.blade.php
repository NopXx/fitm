@extends('layout.master-new')
@section('title', __('department.create_title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css">
    <style>
        .ck-editor__editable {
            min-height: 300px;
        }

        .ck-content .image {
            max-width: 100%;
            margin: 1em 0;
        }

        .ck-content .image img {
            max-width: 100%;
            height: auto;
        }

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
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('department.create_department')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('department.index') }}" class="f-s-14 f-w-500">
                            <span>@lang('translation.data_management')</span>
                        </a>
                    </li>
                    <li>
                        <span>@lang('department.create_department')</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Form Card -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Info Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>@lang('department.basic_info')</h5>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('department.code')</label>
                                <input type="text" class="form-control" name="department_code" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('department.name_th')</label>
                                <input type="text" class="form-control" name="department_name_th" required>
                            </div>
                        </div>

                        <!-- Content Sections -->
                        <div class="row">
                            <div class="col-12">
                                <h5>@lang('department.content_sections')</h5>
                                <hr>
                            </div>

                            <!-- Overview Section -->
                            <div class="col-12 mb-4">
                                <label class="form-label">@lang('department.overview')</label>
                                <textarea id="overview" name="overview"></textarea>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">@lang('translation.save')</button>
                                <button type="button" class="btn btn-info" id="previewBtn">@lang('translation.preview')</button>
                                <a href="{{ route('department.index') }}" class="btn btn-secondary">@lang('translation.cancel')</a>
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
                        <h5 class="modal-title">Content Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="previewContent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Include CKEditor from CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>
    <script>
        const {
            ClassicEditor,
            Essentials,
            Paragraph,
            Bold,
            Font,
            HorizontalLine,
            Italic,
            Heading,
            Link,
            List,
            Image,
            ImageCaption,
            ImageResize,
            ImageResizeEditing,
            ImageResizeHandles,
            ImageStyle,
            ImageToolbar,
            ImageUpload,
            LinkImage,
            Table,
            TableToolbar,
            BlockQuote,
            MediaEmbed
        } = CKEDITOR;
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then(file => {
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('mediable_type', 'department');
                    formData.append('mediable_id', 1); // You might want to dynamically set this

                    return fetch('{{ route('media.upload') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                return {
                                    default: result.media
                                        .path // Assuming your server returns the image URL in this format
                                };
                            }
                            return Promise.reject('Upload failed');
                        });
                });
            }

            abort() {
                // Abort upload if needed
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#overview'), {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    licenseKey: '{{ env('CKEDITOR_KEY') }}',
                    plugins: [
                        Essentials,
                        Paragraph,
                        Bold,
                        Font,
                        Italic,
                        Heading,
                        HorizontalLine,
                        Link,
                        List,
                        Image,
                        ImageUpload,
                        ImageCaption,
                        ImageResize,
                        ImageResizeEditing,
                        ImageResizeHandles,
                        ImageStyle,
                        ImageToolbar,
                        LinkImage,
                        Table,
                        TableToolbar,
                        BlockQuote,
                        MediaEmbed
                    ],
                    toolbar: {
                        items: [
                            'undo', 'redo',
                            '|',
                            'heading',
                            '|',
                            'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                            '|',
                            'bold', 'italic', 'horizontalLine',
                            '|',
                            'bulletedList', 'numberedList',
                            '|',
                            'link', 'uploadImage', 'blockQuote',
                            '|',
                            'insertTable', 'mediaEmbed'
                        ],
                    },
                    image: {
                        resizeOptions: [{
                                name: 'resizeImage:original',
                                value: null,
                                icon: 'original'
                            },
                            {
                                name: 'resizeImage:custom',
                                label: 'Custom',
                                icon: 'custom'
                            },
                            {
                                name: 'resizeImage:25',
                                value: '25',
                                icon: 'small'
                            },
                            {
                                name: 'resizeImage:60',
                                value: '60',
                                icon: 'medium'
                            }
                        ],
                        toolbar: [
                            'imageStyle:inline',
                            'imageStyle:block',
                            'imageStyle:side',
                            '|',
                            'resizeImage:25',
                            'resizeImage:60',
                            'resizeImage:original',
                            'resizeImage:custom',
                            '|',
                            'toggleImageCaption',
                            'imageTextAlternative',
                            '|',
                            'linkImage'
                        ]
                    },
                    table: {
                        contentToolbar: ['tableColumn', 'setTableRowHeader', 'tableRow', 'mergeTableCells']
                    }
                })
                .then(editor => {
                    window.editor = editor;
                    setupPreview(editor);
                })
                .catch(error => {
                    console.error('CKEditor initialization error:', error);
                });

            document.querySelector('#editForm').addEventListener('submit', submitForm);
        });
    </script>
@endsection
