@extends('layout.master-new')
@section('title', __('content.create_title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css">
    <style>
        .ck-editor__editable {
            min-height: 300px;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('content.create_content')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('contents.index') }}" class="f-s-14 f-w-500">
                            <span>@lang('translation.data_management')</span>
                        </a>
                    </li>
                    <li>
                        <span>@lang('content.create_content')</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('contents.store') }}" id="createForm" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('content.title_th')</label>
                                <input type="text" class="form-control" name="title_th" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('content.title_en')</label>
                                <input type="text" class="form-control" name="title_en" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('content.detail_th')</label>
                                <textarea id="detail_th" name="detail_th"></textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('content.detail_en')</label>
                                <textarea id="detail_en" name="detail_en"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">@lang('content.save')</button>
                                <button type="button" class="btn btn-info" id="previewBtn">@lang('content.preview')</button>
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
                        <div id="previewContent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>
    <!-- sweetalert js-->
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
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
            // Initialize CKEditor for Thai content
            ClassicEditor
                .create(document.querySelector('#detail_th'), {
                    language: '{{ app()->getLocale() }}',
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
                    window.editorTh = editor;
                })
                .catch(error => {
                    console.error('Thai editor initialization error:', error);
                });

            // Initialize CKEditor for English content with similar config
            ClassicEditor
                .create(document.querySelector('#detail_en'), {
                    language: 'en',
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
                    window.editorEn = editor;
                })
                .catch(error => {
                    console.error('English editor initialization error:', error);
                });

            // Form submission handler
            document.querySelector('#createForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                // Update the fetch URL in your form submission handler
                try {
                    const response = await fetch(
                    '{{ route('contents.store') }}', { // This will generate /contents
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            title_th: this.title_th.value,
                            title_en: this.title_en.value,
                            detail_th: window.editorTh.getData(),
                            detail_en: window.editorEn.getData()
                        })
                    });
                    const result = await response.json();
                    if (result.success) {
                        window.location.href = '{{ route('contents.index') }}';
                    } else {
                        Swal.fire(
                            '@lang('translation.error')',
                            '@lang('content.create_error')',
                            'error'
                        );
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire(
                        '@lang('translation.error')',
                        '@lang('content.create_error')',
                        'error'
                    );
                }
            });

            // Preview button handler
            document.querySelector('#previewBtn').addEventListener('click', () => {
                const previewContent = document.querySelector('#previewContent');
                const content = `
                    <div class="mb-4">
                        <h3>@lang('content.thai_content')</h3>
                        <h4>${document.querySelector('input[name="title_th"]').value}</h4>
                        <div class="content-preview">${window.editorTh.getData()}</div>
                    </div>
                    <hr>
                    <div>
                        <h3>@lang('content.english_content')</h3>
                        <h4>${document.querySelector('input[name="title_en"]').value}</h4>
                        <div class="content-preview">${window.editorEn.getData()}</div>
                    </div>
                `;
                previewContent.innerHTML = content;
                const previewModal = new bootstrap.Modal(document.querySelector('#previewModal'));
                previewModal.show();
            });
        });
    </script>
@endsection
