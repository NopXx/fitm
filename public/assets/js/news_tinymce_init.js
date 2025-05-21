$(document).ready(function () {
    let uploadedFilePath = '';

    // Initialize both Thai and English TinyMCE editors
    initializeTinyMCE('#editor-th', 'content_th');
    initializeTinyMCE('#editor-en', 'content_en');

    function initializeTinyMCE(selector, contentFieldName) {
        // Initialize TinyMCE
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
                    // Listen for content changes to fix height
                    setTimeout(function() {
                        editor.execCommand('mceAutoResize');
                        adjustEditorHeight();
                    }, 200);
                });

                // Update hidden field with content when editor changes
                editor.on('change', function() {
                    $('input[name="' + contentFieldName + '"]').val(editor.getContent());
                });

                // Listen for content changes to fix height
                editor.on('SetContent Change', function() {
                    setTimeout(function() {
                        editor.execCommand('mceAutoResize');
                        adjustEditorHeight();
                    }, 200);
                });

                // Function to update table styles based on styling standards
                function applyTableStyles() {
                    const tables = editor.getDoc().querySelectorAll('table');

                    tables.forEach(table => {
                        // Only apply default styles if the table doesn't already have inline styles
                        if (!table.hasAttribute('style') || table.getAttribute('style').trim() === '') {
                            // Set table styles
                            table.style.width = '100%';
                            table.style.borderCollapse = 'collapse';
                            table.style.textAlign = 'left';
                            table.style.fontSize = '0.875rem';
                            table.style.color = '#6b7280';
                            table.style.marginBottom = '1.5rem';

                            // Use border-width, border-style and border-color separately
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

                        // Style thead cells
                        const headerCells = table.querySelectorAll('thead th, thead td');
                        headerCells.forEach(cell => {
                            if (!cell.hasAttribute('style') || cell.getAttribute('style').trim() === '') {
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

                        // Style tbody rows
                        const tbodyRows = table.querySelectorAll('tbody tr');
                        tbodyRows.forEach((row, index) => {
                            if (!row.hasAttribute('style') || row.getAttribute('style').trim() === '') {
                                row.style.borderBottom = index === tbodyRows.length - 1 ? 'none' : '1px solid #e5e7eb';
                                row.style.backgroundColor = 'white';
                            }
                        });

                        // Style tbody header cells
                        const tbodyHeaderCells = table.querySelectorAll('tbody th');
                        tbodyHeaderCells.forEach(cell => {
                            if (!cell.hasAttribute('style') || cell.getAttribute('style').trim() === '') {
                                cell.style.padding = '1rem 1.5rem';
                                cell.style.fontWeight = '500';
                                cell.style.whiteSpace = 'nowrap';
                                cell.style.borderWidth = '1px';
                                cell.style.borderStyle = 'solid';
                                cell.style.borderColor = '#e5e7eb';
                                cell.style.color = '#111827';
                            }
                        });

                        // Style tbody data cells
                        const tbodyCells = table.querySelectorAll('tbody td');
                        tbodyCells.forEach(cell => {
                            if (!cell.hasAttribute('style') || cell.getAttribute('style').trim() === '') {
                                cell.style.padding = '1rem 1.5rem';
                                cell.style.borderWidth = '1px';
                                cell.style.borderStyle = 'solid';
                                cell.style.borderColor = '#e5e7eb';
                            }
                        });
                    });
                }

                // Only apply table styles to new tables
                editor.on('TableInsertRow TableInsertCol TableNewRow TableNewCell', applyTableStyles);

                // Listen for changes to tables
                editor.on('NodeChange', function(e) {
                    // Only apply styles to new tables or cells being created/modified
                    if ((e.element.nodeName === 'TABLE' && !e.element.hasAttribute('data-styled')) ||
                        (e.element.nodeName === 'TR' && e.element.classList.contains('mce-item-new')) ||
                        (e.element.nodeName === 'TD' && e.element.classList.contains('mce-item-new')) ||
                        (e.element.nodeName === 'TH' && e.element.classList.contains('mce-item-new'))) {
                        applyTableStyles();

                        // Mark as styled so we don't reapply unnecessarily
                        if (e.element.nodeName === 'TABLE') {
                            e.element.setAttribute('data-styled', 'true');
                        }
                    }
                });
            },

            // Toolbar configuration
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | align lineheight | numlist bullist indent outdent | emoticons charmap | preview | removeformat',

            // Image upload handlers
            images_upload_url: media_url,
            images_upload_handler: function(blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    formData.append('mediable_type', 'news');

                    // For edit page, use the news ID. For add page, will be updated after creation
                    const newsId = typeof editNewsId !== 'undefined' ? editNewsId : 1;
                    formData.append('mediable_id', newsId);

                    fetch(media_url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrf
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
            table_border_styles: ['solid', 'dotted', 'dashed', 'double', 'groove', 'ridge', 'inset', 'outset'],

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
                    min-height: 400px;
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

    // Handle form submission
    $('#addNewForm, #editNewForm').on('submit', function(e) {
        e.preventDefault();

        // Ensure content is updated before form submission
        tinymce.triggerSave();

        // Update the hidden content fields with the editor content
        if (tinymce.get('editor-th')) {
            $('input[name="content_th"]').val(tinymce.get('editor-th').getContent());
        }

        if (tinymce.get('editor-en')) {
            $('input[name="content_en"]').val(tinymce.get('editor-en').getContent());
        }

        // Create FormData object
        const formData = new FormData(this);

        // Add the uploaded file path if exists
        if (uploadedFilePath) {
            formData.set('cover', uploadedFilePath);
        }

        // Submit form with AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    alert(response.message || 'An error occurred');
                }
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while saving';
                alert(errorMessage);
            }
        });
    });

    // Card selection handling
    document.querySelectorAll('.select-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('input[name="display_type"]').forEach(radio => {
                radio.checked = false;
                radio.closest('.card').classList.remove('border-primary');
            });

            const radio = this.querySelector('input[name="display_type"]');
            radio.checked = true;
            this.classList.add('border-primary');
        });
    });

    // Initialize preview images for edit page
    if (typeof existingFile !== 'undefined' && existingFile) {
        const previewStyle1Cover = document.getElementById('previewStyle1Cover');
        const previewStyle2Cover = document.getElementById('previewStyle2Cover');

        if (previewStyle1Cover) {
            previewStyle1Cover.src = existingFile;
        }
        if (previewStyle2Cover) {
            previewStyle2Cover.src = existingFile;
        }
    }

    // Initialize datepicker
    const config = {
        enableTime: false,
        locale: locale,
        dateFormat: "Y-m-d",
    };
    flatpickr(".basic-date", config);

    // Initialize FilePond
    FilePond.registerPlugin(
        FilePondPluginFileEncode,
        FilePondPluginFileValidateSize,
        FilePondPluginImageExifOrientation,
        FilePondPluginImagePreview
    );

    // Create FilePond instance
    const pondElement = document.querySelector('#fileupload-2');
    if (pondElement) {
        const pondOptions = {
            acceptedFileTypes: ['image/*'],
            server: {
                process: {
                    url: '/admin/new/upload',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    onload: (response) => {
                        uploadedFilePath = response;
                        return response;
                    }
                },
                revert: {
                    url: '/admin/new/revert',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    onload: () => {
                        uploadedFilePath = '';
                    }
                }
            },
            onaddfile: (error, file) => {
                if (error) {
                    console.error('FilePond error:', error);
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewStyle1Cover = document.getElementById('previewStyle1Cover');
                    const previewStyle2Cover = document.getElementById('previewStyle2Cover');

                    if (previewStyle1Cover) {
                        previewStyle1Cover.src = e.target.result;
                    }
                    if (previewStyle2Cover) {
                        previewStyle2Cover.src = e.target.result;
                    }
                };

                reader.readAsDataURL(file.file);
            },
            onremovefile: () => {
                const previewStyle1Cover = document.getElementById('previewStyle1Cover');
                const previewStyle2Cover = document.getElementById('previewStyle2Cover');

                if (previewStyle1Cover) {
                    previewStyle1Cover.src = typeof DEFAULT_IMAGE !== 'undefined' ? DEFAULT_IMAGE : '/assets/images/size/600x400.png';
                }
                if (previewStyle2Cover) {
                    previewStyle2Cover.src = typeof DEFAULT_IMAGE_STYLE2 !== 'undefined' ? DEFAULT_IMAGE_STYLE2 : '/assets/images/size/1200x600.png';
                }
            }
        };

        // For edit page, add existing file
        if (typeof existingFile !== 'undefined' && existingFile) {
            pondOptions.files = [{
                source: existingFile,
                options: {
                    type: 'local'
                }
            }];

            pondOptions.server.load = (source, load, error) => {
                // Handle loading existing files
                fetch(source)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.blob();
                    })
                    .then(load)
                    .catch(error);
            };
        }

        FilePond.create(pondElement, pondOptions);
    }
});

// Adjust editor height based on content
function adjustEditorHeight() {
    const editors = ['editor-th', 'editor-en'];

    editors.forEach(editorId => {
        const editor = tinymce.get(editorId);
        if (!editor) return;

        // Calculate appropriate height
        const contentHeight = editor.getDoc().body.scrollHeight;
        const minHeight = 400;
        const newHeight = Math.max(contentHeight + 100, minHeight);

        // Apply heights to editor components
        const container = editor.getContainer();
        container.style.height = newHeight + 'px';

        const iframe = editor.getContentAreaContainer().firstChild;
        iframe.style.height = (newHeight - 50) + 'px';
        iframe.style.position = 'relative';

        editor.getDoc().body.style.minHeight = (newHeight - 100) + 'px';
        editor.getDoc().body.style.overflow = 'auto';
    });
}
