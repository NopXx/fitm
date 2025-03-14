$(document).ready(function () {
    // Initialize both Thai and English TinyMCE editors
    initializeTinyMCE('#detail_th', 'detail_th');
    initializeTinyMCE('#detail_en', 'detail_en');

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
                        adjustEditorHeight(editor);
                    }, 200);
                });

                // Listen for content changes to fix height
                editor.on('SetContent Change', function() {
                    setTimeout(function() {
                        editor.execCommand('mceAutoResize');
                        adjustEditorHeight(editor);
                    }, 200);
                });

                // Function to update table styles based on styling standards
                function applyTableStyles() {
                    const tables = editor.getDoc().querySelectorAll('table');

                    tables.forEach(table => {
                        // Add modern table class
                        table.classList.add('content-table');

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
                            table.style.borderRadius = '0.375rem';
                            table.style.overflow = 'hidden';
                            table.style.boxShadow = '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)';
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
                                cell.style.backgroundColor = '#f0f9ff';
                                cell.style.color = '#374151';
                                cell.style.position = 'relative';
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
                    formData.append('mediable_type', 'contents');
                    const contentID = typeof contentId !== 'undefined' ? contentId : 1;
                    formData.append('mediable_id', contentID); // Will be updated after creation

                    fetch(media_url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrf_token
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
                    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
                    border-radius: 0.375rem;
                    overflow: hidden;
                }

                /* Table header */
                table thead {
                    font-size: 0.75rem;
                    text-transform: uppercase;
                    color: #374151;
                    background-color: #f0f9ff;
                    border-bottom: 2px solid #e5e7eb;
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
                    transition: background-color 0.2s ease;
                }

                table tbody tr:hover {
                    background-color: #f9fafb;
                }

                table tbody tr:last-child {
                    border-bottom: none;
                }

                /* Alternating row colors for better readability */
                table tbody tr:nth-child(even) {
                    background-color: #f8fafc;
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

    // Form submission handlers
    if (document.querySelector('#createForm')) {
        document.querySelector('#createForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            // Update content from TinyMCE to textareas
            tinymce.triggerSave();

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        code: this.code.value,
                        title_th: this.title_th.value,
                        title_en: this.title_en.value,
                        detail_th: tinymce.get('detail_th').getContent(),
                        detail_en: tinymce.get('detail_en').getContent()
                    })
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = result.redirect || '/admin/contents';
                } else {
                    Swal.fire(
                        'Error',
                        result.message || 'An error occurred while saving',
                        'error'
                    );
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'An error occurred while saving',
                    'error'
                );
            }
        });
    }

    // For edit form
    if (document.querySelector('#editForm')) {
        document.querySelector('#editForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            // Update content from TinyMCE to textareas
            tinymce.triggerSave();

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PUT', // For Laravel PUT request
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
                        title: 'Success',
                        text: 'Content updated successfully',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = result.redirect || '/admin/contents';
                    });
                } else {
                    Swal.fire(
                        'Error',
                        result.message || 'An error occurred while updating',
                        'error'
                    );
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire(
                    'Error',
                    'An error occurred while updating',
                    'error'
                );
            }
        });
    }

    // Preview button handler
    document.querySelector('#previewBtn')?.addEventListener('click', () => {
        const previewContent = document.querySelector('#previewContent');
        const content = `
            <div class="mb-4">
                <h3>Thai Content</h3>
                <h4>${document.querySelector('input[name="title_th"]').value}</h4>
                <div class="content-preview">${tinymce.get('detail_th').getContent()}</div>
            </div>
            <hr>
            <div>
                <h3>English Content</h3>
                <h4>${document.querySelector('input[name="title_en"]').value}</h4>
                <div class="content-preview">${tinymce.get('detail_en').getContent()}</div>
            </div>
        `;

        previewContent.innerHTML = content;

                        // Add responsive wrapper for tables
        const tables = previewContent.querySelectorAll('table:not(.table-responsive)');
        tables.forEach(table => {
            // Add content-table class to tables
            table.classList.add('content-table');

            if (!table.parentElement.classList.contains('table-responsive')) {
                const wrapper = document.createElement('div');
                wrapper.className = 'table-responsive';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            }
        });

        // Add responsive class to images
        const images = previewContent.querySelectorAll('img:not(.img-fluid)');
        images.forEach(img => {
            img.classList.add('img-fluid');
        });

        // Show preview modal
        const previewModal = new bootstrap.Modal(document.querySelector('#previewModal'));
        previewModal.show();
    });
});
