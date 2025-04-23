@extends('layout.master-new')
@section('title', __('department.edit_title'))

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

        /* Language Tabs */
        .lang-tabs {
            margin-bottom: 15px;
        }

        .lang-tabs .nav-link.active {
            font-weight: 600;
        }

        .tab-pane {
            padding-top: 15px;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('department.edit_department')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('department.index') }}" class="f-s-14 f-w-500">
                            <span>@lang('translation.data_management')</span>
                        </a>
                    </li>
                    <li>
                        <span>@lang('department.edit_department')</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>@lang('department.basic_info')</h5>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('department.code') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="department_code"
                                    value="{{ $department->department_code }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('department.name_th') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="department_name_th"
                                    value="{{ $department->department_name_th }}" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="form-label">@lang('department.name_en') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="department_name_en"
                                    value="{{ $department->department_name_en }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h5>@lang('department.content_sections')</h5>
                                <hr>
                            </div>

                            <!-- Language Tabs for Overview -->
                            <div class="col-12 mb-4">
                                <div class="lang-tabs">
                                    <ul class="nav nav-tabs" id="overviewLangTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="overview-th-tab" data-bs-toggle="tab"
                                                data-bs-target="#overview-th-content" type="button" role="tab"
                                                aria-controls="overview-th-content" aria-selected="true">
                                                @lang('translation.thai_information') <span class="text-danger">*</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="overview-en-tab" data-bs-toggle="tab"
                                                data-bs-target="#overview-en-content" type="button" role="tab"
                                                aria-controls="overview-en-content" aria-selected="false">
                                                @lang('translation.english_information')
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                                <div class="tab-content" id="overviewLangTabContent">
                                    <!-- Thai Overview -->
                                    <div class="tab-pane fade show active" id="overview-th-content" role="tabpanel"
                                        aria-labelledby="overview-th-tab">
                                        <label class="form-label">@lang('department.overview') (@lang('translation.thai_information'))</label>
                                        <textarea id="overview_th" name="overview_th">{{ $department->overview_th }}</textarea>
                                    </div>

                                    <!-- English Overview -->
                                    <div class="tab-pane fade" id="overview-en-content" role="tabpanel"
                                        aria-labelledby="overview-en-tab">
                                        <label class="form-label">@lang('department.overview') (@lang('translation.english_information'))</label>
                                        <textarea id="overview_en" name="overview_en">{{ $department->overview_en }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

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

        <div class="modal fade" id="previewModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Content Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="lang-tabs">
                            <ul class="nav nav-tabs" id="previewLangTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="preview-th-tab" data-bs-toggle="tab"
                                        data-bs-target="#preview-th-content" type="button" role="tab"
                                        aria-controls="preview-th-content" aria-selected="true">
                                        @lang('translation.thai_information')
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="preview-en-tab" data-bs-toggle="tab"
                                        data-bs-target="#preview-en-content" type="button" role="tab"
                                        aria-controls="preview-en-content" aria-selected="false">
                                        @lang('translation.english_information')
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="previewLangTabContent">
                            <!-- Thai Preview -->
                            <div class="tab-pane fade show active" id="preview-th-content" role="tabpanel"
                                aria-labelledby="preview-th-tab">
                                <div id="previewContentTh" class="department-content"></div>
                            </div>

                            <!-- English Preview -->
                            <div class="tab-pane fade" id="preview-en-content" role="tabpanel"
                                aria-labelledby="preview-en-tab">
                                <div id="previewContentEn" class="department-content"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize TinyMCE for Thai content
            initTinyMCE('#overview_th');

            // Initialize TinyMCE for English content
            initTinyMCE('#overview_en');

            // Handle form submission
            document.querySelector('#editForm').addEventListener('submit', submitForm);

            // Setup preview button
            document.querySelector('#previewBtn').addEventListener('click', function() {
                // Get content from both editors
                const thContent = tinymce.get('overview_th').getContent();
                const enContent = tinymce.get('overview_en').getContent();

                // Apply content to preview containers
                const previewContentTh = document.querySelector('#previewContentTh');
                const previewContentEn = document.querySelector('#previewContentEn');

                previewContentTh.innerHTML = thContent;
                previewContentEn.innerHTML = enContent;

                // Apply responsive table wrappers and image classes
                applyResponsiveClasses(previewContentTh);
                applyResponsiveClasses(previewContentEn);

                // Show the modal
                const previewModal = new bootstrap.Modal(document.querySelector('#previewModal'));
                previewModal.show();
            });
        });

        // Initialize TinyMCE with all the configuration
        function initTinyMCE(selector) {
            tinymce.init({
                selector: selector,
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

                setup: function(editor) {
                    editor.on('init', function() {
                        // Only apply table styles to new tables, not existing ones with content
                        editor.on('NewBlock', function(e) {
                            if (e.newBlock && e.newBlock.nodeName === 'TABLE') {
                                applyTableStyles();
                            }
                        });

                        // Add custom border width option to the row properties dialog
                        editor.ui.registry.addMenuButton('borderWidth', {
                            text: 'Border Width',
                            fetch: function(callback) {
                                const items = [{
                                        type: 'menuitem',
                                        text: '1px',
                                        onAction: function() {
                                            editor.execCommand(
                                                'mceTableRowProps',
                                                false, {
                                                    borderwidth: '1px'
                                                });
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: '2px',
                                        onAction: function() {
                                            editor.execCommand(
                                                'mceTableRowProps',
                                                false, {
                                                    borderwidth: '2px'
                                                });
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: '3px',
                                        onAction: function() {
                                            editor.execCommand(
                                                'mceTableRowProps',
                                                false, {
                                                    borderwidth: '3px'
                                                });
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: '4px',
                                        onAction: function() {
                                            editor.execCommand(
                                                'mceTableRowProps',
                                                false, {
                                                    borderwidth: '4px'
                                                });
                                        }
                                    },
                                    {
                                        type: 'menuitem',
                                        text: '5px',
                                        onAction: function() {
                                            editor.execCommand(
                                                'mceTableRowProps',
                                                false, {
                                                    borderwidth: '5px'
                                                });
                                        }
                                    }
                                ];
                                callback(items);
                            }
                        });
                    });

                    // Only apply table styles to newly created tables
                    editor.on('TableInsertRow TableInsertCol TableNewRow TableNewCell',
                        applyTableStyles);

                    // Listen for changes to tables
                    editor.on('NodeChange', function(e) {
                        // Only apply styles to new tables or cells being created/modified
                        if ((e.element.nodeName === 'TABLE' && !e.element.hasAttribute(
                                'data-styled')) ||
                            (e.element.nodeName === 'TR' && e.element.classList.contains(
                                'mce-item-new')) ||
                            (e.element.nodeName === 'TD' && e.element.classList.contains(
                                'mce-item-new')) ||
                            (e.element.nodeName === 'TH' && e.element.classList.contains(
                                'mce-item-new'))) {
                            applyTableStyles();

                            // Mark as styled so we don't reapply unnecessarily
                            if (e.element.nodeName === 'TABLE') {
                                e.element.setAttribute('data-styled', 'true');
                            }
                        }
                    });

                    // Handle custom border width property in table dialogs
                    editor.on('tableRowDialogShow', function(e) {
                        const dialog = e.dialog;

                        // Add border width field if it doesn't exist
                        if (!dialog.find('#borderwidth').length) {
                            const borderStyleField = dialog.find('#borderstyle')[0];
                            if (borderStyleField) {
                                const borderWidthField = {
                                    type: 'selectbox',
                                    name: 'borderwidth',
                                    label: 'Border width',
                                    items: [{
                                            text: '1px',
                                            value: '1px'
                                        },
                                        {
                                            text: '2px',
                                            value: '2px'
                                        },
                                        {
                                            text: '3px',
                                            value: '3px'
                                        },
                                        {
                                            text: '4px',
                                            value: '4px'
                                        },
                                        {
                                            text: '5px',
                                            value: '5px'
                                        }
                                    ]
                                };
                                dialog.insert(borderWidthField, borderStyleField, false);
                            }
                        }
                    });

                    // Listen for content changes to fix height
                    editor.on('SetContent Change', function() {
                        setTimeout(function() {
                            editor.execCommand('mceAutoResize');
                            adjustEditorHeight(editor);
                        }, 200);
                    });

                    // Function to update table styles based on the department-content class
                    function applyTableStyles() {
                        const tables = editor.getDoc().querySelectorAll('table');

                        tables.forEach(table => {
                            // Only apply default styles if the table doesn't already have inline styles
                            if (!table.hasAttribute('style') || table.getAttribute('style')
                                .trim() === '') {
                                // Set table styles
                                table.style.width = '100%';
                                table.style.borderCollapse = 'collapse';
                                table.style.textAlign = 'left';
                                table.style.fontSize = '0.875rem';
                                table.style.color = '#6b7280';
                                table.style.marginBottom = '1.5rem';

                                // Use border-width, border-style and border-color separately to allow for more control
                                table.style.borderWidth = '1px';
                                table.style.borderStyle = 'solid';
                                table.style.borderColor = '#e5e7eb';
                            }

                            // Create thead if it doesn't exist
                            if (!table.querySelector('thead') && table.rows.length > 0) {
                                const thead = document.createElement('thead');
                                thead.appendChild(table.rows[0].cloneNode(true));
                                table.insertBefore(thead, table.firstChild);
                                table.deleteRow(1);
                            }

                            // Style thead cells only if they don't have styles already
                            const headerCells = table.querySelectorAll('thead th, thead td');
                            headerCells.forEach(cell => {
                                if (!cell.hasAttribute('style') || cell.getAttribute(
                                        'style').trim() === '') {
                                    cell.style.padding = '0.75rem 1.5rem';
                                    cell.style.fontWeight = '600';
                                    cell.style.textTransform = 'uppercase';
                                    cell.style.fontSize = '0.75rem';
                                    cell.style.borderWidth = '1px';
                                    cell.style.borderStyle = 'solid';
                                    cell.style.borderColor = '#e5e7eb';
                                    cell.style.backgroundColor = '#f9fafb';
                                    cell.style.color = '#374151';
                                }
                            });

                            // Style tbody rows only if they don't have styles already
                            const tbodyRows = table.querySelectorAll('tbody tr');
                            tbodyRows.forEach((row, index) => {
                                if (!row.hasAttribute('style') || row.getAttribute(
                                        'style').trim() === '') {
                                    row.style.borderBottom = index === tbodyRows
                                        .length - 1 ? 'none' : '1px solid #e5e7eb';
                                    row.style.backgroundColor = 'white';
                                }
                            });

                            // Style tbody header cells only if they don't have styles already
                            const tbodyHeaderCells = table.querySelectorAll('tbody th');
                            tbodyHeaderCells.forEach(cell => {
                                if (!cell.hasAttribute('style') || cell.getAttribute(
                                        'style').trim() === '') {
                                    cell.style.padding = '1rem 1.5rem';
                                    cell.style.fontWeight = '500';
                                    cell.style.whiteSpace = 'nowrap';
                                    cell.style.borderWidth = '1px';
                                    cell.style.borderStyle = 'solid';
                                    cell.style.borderColor = '#e5e7eb';
                                    cell.style.color = '#111827';
                                }
                            });

                            // Style tbody data cells only if they don't have styles already
                            const tbodyCells = table.querySelectorAll('tbody td');
                            tbodyCells.forEach(cell => {
                                if (!cell.hasAttribute('style') || cell.getAttribute(
                                        'style').trim() === '') {
                                    cell.style.padding = '1rem 1.5rem';
                                    cell.style.borderWidth = '1px';
                                    cell.style.borderStyle = 'solid';
                                    cell.style.borderColor = '#e5e7eb';
                                }
                            });
                        });
                    }
                },

                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | align lineheight | numlist bullist indent outdent | emoticons charmap | preview | removeformat',

                // Image upload handlers
                images_upload_url: '{{ route('media.upload') }}',
                images_upload_handler: function(blobInfo, progress) {
                    return new Promise((resolve, reject) => {
                        const formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        formData.append('mediable_type', 'department');
                        formData.append('mediable_id', {{ $department->id }});

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
                                        message: 'Upload failed',
                                        remove: true
                                    });
                                }
                            })
                            .catch(error => {
                                reject({
                                    message: 'Upload failed',
                                    remove: true
                                });
                            });
                    });
                },

                menubar: true,
                image_dimensions: true,

                // Class lists
                image_class_list: [{
                    title: 'Responsive',
                    value: 'img-fluid'
                }],

                table_class_list: [{
                        title: 'None',
                        value: ''
                    },
                    {
                        title: 'Responsive',
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

                // Content style based on department.css
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
            });
        }

        // Adjust editor height based on content
        function adjustEditorHeight(editor) {
            if (!editor) return;

            // Calculate appropriate height
            const contentHeight = editor.getDoc().body.scrollHeight;
            const minHeight = 700;
            const newHeight = Math.max(contentHeight + 100, minHeight);

            // Apply heights to editor components
            const container = editor.getContainer();
            container.style.height = newHeight + 'px';

            const iframe = editor.getContentAreaContainer().firstChild;
            iframe.style.height = (newHeight - 50) + 'px';
            iframe.style.position = 'relative';

            editor.getDoc().body.style.minHeight = (newHeight - 100) + 'px';
            editor.getDoc().body.style.overflow = 'auto';
        }

        // Apply responsive classes to tables and images in preview
        function applyResponsiveClasses(container) {
            if (!container) return;

            // Apply responsive table wrappers if not already added
            const tables = container.querySelectorAll('table:not(.table-responsive)');
            tables.forEach(table => {
                if (!table.parentElement.classList.contains('table-responsive')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'table-responsive';
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
            });

            // Add img-fluid class to images if not already added
            const images = container.querySelectorAll('img:not(.img-fluid)');
            images.forEach(img => {
                img.classList.add('img-fluid');
            });
        }

        // Handle form submission
        async function submitForm(e) {
            e.preventDefault();
            const departmentId = {{ $department->id }};

            // Ensure content is updated before form submission
            tinymce.triggerSave();

            // Get form data
            const formData = new FormData(this);
            const formDataObj = {};
            for (const [key, value] of formData.entries()) {
                formDataObj[key] = value;
            }

            try {
                // Send a single request to update all department fields
                const response = await fetch(`/admin/department/update/${departmentId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        department_code: formDataObj.department_code,
                        department_name_th: formDataObj.department_name_th,
                        department_name_en: formDataObj.department_name_en,
                        overview_th: tinymce.get('overview_th').getContent(),
                        overview_en: tinymce.get('overview_en').getContent(),
                        status: 'draft' // Default to draft status
                    })
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = '{{ route('department.index') }}';
                } else {
                    console.error('Failed to update department:', result.message);

                    if (result.errors) {
                        // Display validation errors
                        const errorMessages = Object.values(result.errors).flat();
                        alert('Error: ' + errorMessages.join('\n'));
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while saving. Please try again.');
            }
        }
    </script>
@endsection
