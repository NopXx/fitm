$(document).ready(function () {
    let uploadedFilePath = '';

    // Initialize Trumbowyg Editor with existing content
    $('#editor').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'],
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen']
        ],
    });

    // Sync editor content to hidden input before form submission
    $('#editNewForm').on('submit', function (e) {
        e.preventDefault();

        // Get editor content
        const editorContent = $('#editor').trumbowyg('html');
        $('input[name="content"]').val(editorContent);

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
        card.addEventListener('click', function () {
            document.querySelectorAll('input[name="display_type"]').forEach(radio => {
                radio.checked = false;
                radio.closest('.card').classList.remove('border-primary');
            });

            const radio = this.querySelector('input[name="display_type"]');
            radio.checked = true;
            this.classList.add('border-primary');
        });
    });

    // Initialize preview images with existing file
    if (existingFile) {
        const previewStyle1Cover = document.getElementById('previewStyle1Cover');
        const previewStyle2Cover = document.getElementById('previewStyle2Cover');

        if (previewStyle1Cover) {
            previewStyle1Cover.src = existingFile;
        }
        if (previewStyle2Cover) {
            previewStyle2Cover.src = existingFile;
        }
    }

    // Datepicker initialization
    const config = {
        enableTime: true,
        locale: locale,
        dateFormat: "Y-m-d H:i",
    };
    flatpickr(".basic-date", config);

    // Initialize FilePond plugins
    FilePond.registerPlugin(
        FilePondPluginFileEncode,
        FilePondPluginFileValidateSize,
        FilePondPluginImageExifOrientation,
        FilePondPluginImagePreview
    );

    // FilePond initialization for edit form
    const pond = FilePond.create(document.querySelector('#fileupload-2'), {
        allowImagePreview: true,
        allowRevert: true,
        files: existingFile ? [{
            source: existingFile,
            options: {
                type: 'local'
            }
        }] : [],
        server: {
            process: {
                url: '/../admin/new/upload',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                onload: (response) => {
                    uploadedFilePath = response;
                    return response;
                }
            },
            revert: {
                url: '/../admin/new/revert',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                onload: () => {
                    uploadedFilePath = '';
                }
            },
            load: (source, load, error) => {
                // Handle loading existing files
                fetch(source)
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.blob();
                    })
                    .then(load)
                    .catch(error);
            }
        },
        onaddfile: (error, file) => {
            if (error) {
                console.error('FilePond error:', error);
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
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
                previewStyle1Cover.src = DEFAULT_IMAGE;
            }
            if (previewStyle2Cover) {
                previewStyle2Cover.src = DEFAULT_IMAGE_STYLE2;
            }

            uploadedFilePath = '';
        }
    });
});
