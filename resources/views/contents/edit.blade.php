@extends('layout.master-new')
@section('title', __('content.edit_title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <script src="https://cdn.tiny.cloud/1/hn7u4cu4cokjuyws887pfvcxkwbkdc6gm82bsbpamfqjdjhy/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @vite(['resources/css/department.css'])
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
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">@lang('content.code')</label>
                                <input type="text" class="form-control" name="code" value="{{ $content->code }}"
                                    required>
                                <small class="text-muted">@lang('content.code_help')</small>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('content.title_th')</label>
                                <input type="text" class="form-control" name="title_th" value="{{ $content->title_th }}"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('content.title_en')</label>
                                <input type="text" class="form-control" name="title_en" value="{{ $content->title_en }}"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('content.detail_th')</label>
                                <textarea id="detail_th" name="detail_th">{{ $content->detail_th }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('content.detail_en')</label>
                                <textarea id="detail_en" name="detail_en">{{ $content->detail_en }}</textarea>
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
        document.addEventListener('DOMContentLoaded', function() {
            // กำหนดตั้งค่าทั่วไปสำหรับ TinyMCE ที่จะใช้ร่วมกัน
            const tinyMCECommonConfig = {
                send_browser_spellcheck_urls: false,
                send_client_stats: false,
                promotion: false,
                referrer_policy: 'origin',

                // Essential plugins
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount advlist preview autoresize',

                // Height settings
                height: "auto",
                min_height: 600,
                max_height: 2000,
                resize: true,
                autoresize_on_init: true,
                autoresize_bottom_margin: 50,

                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | align lineheight | numlist bullist indent outdent | emoticons charmap | preview | removeformat',

                // Image upload handlers
                images_upload_url: '{{ route('media.upload') }}',
                images_upload_handler: function(blobInfo, progress) {
                    return new Promise((resolve, reject) => {
                        const formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        formData.append('mediable_type', 'department');
                        formData.append('mediable_id', 1); // จะถูกอัปเดตหลังจากสร้างเนื้อหา

                        fetch('{{ route('media.upload') }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.success) {
                                    resolve(result.media.path);
                                } else {
                                    reject({
                                        message: 'อัปโหลดล้มเหลว',
                                        remove: true
                                    });
                                }
                            })
                            .catch(error => {
                                reject({
                                    message: 'อัปโหลดล้มเหลว',
                                    remove: true
                                });
                            });
                    });
                },

                menubar: true,
                image_dimensions: true,

                // Class lists
                image_class_list: [{
                    title: 'เต็มขนาด (Responsive)',
                    value: 'img-fluid'
                }],

                table_class_list: [{
                        title: 'ไม่มี',
                        value: ''
                    },
                    {
                        title: 'เต็มขนาด (Responsive)',
                        value: 'table-responsive'
                    }
                ],

                // Table settings
                table_advtab: true,
                table_cell_advtab: true,
                table_row_advtab: true,
                table_appearance_options: true,
                table_style_by_css: true,
                table_border_widths: [1, 2, 3, 4, 5],
                table_border_styles: ['solid', 'dotted', 'dashed', 'double', 'groove', 'ridge', 'inset',
                    'outset'
                ],

                // Allow inline styles
                valid_elements: '*[*]',
                extended_valid_elements: 'table[*],tr[*],td[*],th[*]',

                // Content style
                content_style: `
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                        line-height: 1.5;
                        color: #6b7280;
                        padding: 20px;
                        min-height: 650px;
                    }

                    img {
                        max-width: 100%;
                        height: auto;
                    }

                    /* Table styling */
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        text-align: left;
                        font-size: 0.875rem;
                        color: #6b7280;
                        margin-bottom: 1.5rem;
                        border-width: 1px;
                        border-style: solid;
                        border-color: #e5e7eb;
                    }

                    /* Table header */
                    table thead {
                        font-size: 0.75rem;
                        text-transform: uppercase;
                        color: #374151;
                        background-color: #f9fafb;
                    }

                    table th {
                        padding: 0.75rem 1.5rem;
                        font-weight: 600;
                        border-width: 1px;
                        border-style: solid;
                        border-color: #e5e7eb;
                    }

                    /* Table body */
                    table tbody tr {
                        border-bottom: 1px solid #e5e7eb;
                        background-color: white;
                    }

                    table tbody tr:last-child {
                        border-bottom: none;
                    }

                    table tbody th {
                        padding: 1rem 1.5rem;
                        font-weight: 500;
                        color: #111827;
                        white-space: nowrap;
                        border-width: 1px;
                        border-style: solid;
                        border-color: #e5e7eb;
                    }

                    table tbody td {
                        padding: 1rem 1.5rem;
                        border-width: 1px;
                        border-style: solid;
                        border-color: #e5e7eb;
                    }

                    /* Headings */
                    h1, h2, h3, h4, h5, h6 {
                        margin-top: 1.5rem;
                        margin-bottom: 1rem;
                        font-weight: 600;
                        line-height: 1.25;
                        color: #111827;
                    }

                    p {
                        margin-bottom: 1rem;
                    }

                    ul, ol {
                        padding-left: 2rem;
                        margin-bottom: 1rem;
                    }

                    blockquote {
                        padding: 1rem;
                        border-left: 4px solid #e5e7eb;
                        background-color: #f9fafb;
                        margin-bottom: 1rem;
                    }

                    /* Links */
                    a {
                        color: #3b82f6;
                        text-decoration: underline;
                    }

                    a:hover {
                        color: #2563eb;
                    }
                `
            };

            // ตั้งค่า TinyMCE สำหรับเนื้อหาภาษาไทย
            tinymce.init({
                selector: '#detail_th',
                ...tinyMCECommonConfig,
                language: '{{ app()->getLocale() }}',
                setup: function(editor) {
                    editor.on('init', function() {
                        // ปรับความสูงอัตโนมัติ
                        editor.on('SetContent Change', function() {
                            setTimeout(function() {
                                editor.execCommand('mceAutoResize');
                                adjustEditorHeight(editor);
                            }, 200);
                        });
                    });
                }
            });

            // ตั้งค่า TinyMCE สำหรับเนื้อหาภาษาอังกฤษ
            tinymce.init({
                selector: '#detail_en',
                ...tinyMCECommonConfig,
                language: 'en',
                setup: function(editor) {
                    editor.on('init', function() {
                        // ปรับความสูงอัตโนมัติ
                        editor.on('SetContent Change', function() {
                            setTimeout(function() {
                                editor.execCommand('mceAutoResize');
                                adjustEditorHeight(editor);
                            }, 200);
                        });
                    });
                }
            });

            // ฟังก์ชันปรับความสูงของ editor ตามเนื้อหา
            function adjustEditorHeight(editor) {
                if (!editor) return;

                // คำนวณความสูงที่เหมาะสม
                const contentHeight = editor.getDoc().body.scrollHeight;
                const minHeight = 700;
                const newHeight = Math.max(contentHeight + 100, minHeight);

                // ปรับความสูงของส่วนประกอบ editor
                const container = editor.getContainer();
                container.style.height = newHeight + 'px';

                const iframe = editor.getContentAreaContainer().firstChild;
                iframe.style.height = (newHeight - 50) + 'px';
                iframe.style.position = 'relative';

                editor.getDoc().body.style.minHeight = (newHeight - 100) + 'px';
                editor.getDoc().body.style.overflow = 'auto';
            }

            // จัดการการส่งฟอร์มแก้ไข
            document.querySelector('#editForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                // อัปเดตเนื้อหาจาก TinyMCE ไปยัง textarea
                tinymce.triggerSave();

                const contentId = {{ $content->id }};

                try {
                    const response = await fetch(
                        '{{ route('contents.update', ['content' => $content->id]) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                _method: 'PUT', // สร้าง PUT request ให้กับ Laravel
                                code: this.code.value,
                                title_th: this.title_th.value,
                                title_en: this.title_en.value,
                                detail_th: tinymce.get('detail_th').getContent(),
                                detail_en: tinymce.get('detail_en').getContent()
                            })
                        });

                    const result = await response.json();

                    if (result.success) {
                        Swal.fire({
                            title: '@lang('translation.success')',
                            text: '@lang('content.update_success')',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = '{{ route('contents.index') }}';
                        });
                    } else {
                        Swal.fire(
                            '@lang('translation.error')',
                            result.message || '@lang('content.update_error')',
                            'error'
                        );
                    }
                } catch (error) {
                    console.error('ข้อผิดพลาด:', error);
                    Swal.fire(
                        '@lang('translation.error')',
                        '@lang('content.update_error')',
                        'error'
                    );
                }
            });

            // จัดการปุ่มแสดงตัวอย่าง
            document.querySelector('#previewBtn').addEventListener('click', () => {
                const previewContent = document.querySelector('#previewContent');
                const content = `
                    <div class="mb-4">
                        <h3>@lang('content.thai_content')</h3>
                        <h4>${document.querySelector('input[name="title_th"]').value}</h4>
                        <div class="content-preview">${tinymce.get('detail_th').getContent()}</div>
                    </div>
                    <hr>
                    <div>
                        <h3>@lang('content.english_content')</h3>
                        <h4>${document.querySelector('input[name="title_en"]').value}</h4>
                        <div class="content-preview">${tinymce.get('detail_en').getContent()}</div>
                    </div>
                `;

                previewContent.innerHTML = content;

                // เพิ่ม wrapper สำหรับตารางเพื่อให้แสดงผลแบบ responsive
                const tables = previewContent.querySelectorAll('table:not(.table-responsive)');
                tables.forEach(table => {
                    if (!table.parentElement.classList.contains('table-responsive')) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'table-responsive';
                        table.parentNode.insertBefore(wrapper, table);
                        wrapper.appendChild(table);
                    }
                });

                // เพิ่มคลาส img-fluid ให้กับรูปภาพที่ยังไม่มี
                const images = previewContent.querySelectorAll('img:not(.img-fluid)');
                images.forEach(img => {
                    img.classList.add('img-fluid');
                });

                // แสดง modal ตัวอย่าง
                const previewModal = new bootstrap.Modal(document.querySelector('#previewModal'));
                previewModal.show();
            });
        });
    </script>
@endsection
