/**
 * Content Form Handlers
 * Form submission and validation for content forms
 */
document.addEventListener('DOMContentLoaded', function() {
    // Create form handler
    const createForm = document.getElementById('createForm');
    if (createForm) {
        createForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Update content from TinyMCE to textarea
            tinymce.triggerSave();

            try {
                const response = await fetch(contentConfig.formSubmitHandlers.create, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': contentConfig.csrfToken,
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
                    window.location.href = contentConfig.indexRedirectUrl;
                } else {
                    Swal.fire(
                        contentConfig.errorTitle,
                        contentConfig.createErrorMsg,
                        'error'
                    );
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire(
                    contentConfig.errorTitle,
                    contentConfig.createErrorMsg,
                    'error'
                );
            }
        });
    }

    // Edit form handler
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Update content from TinyMCE to textarea
            tinymce.triggerSave();

            // Get content ID from form action URL or data attribute
            const contentId = this.dataset.contentId ||
                              this.action.split('/').filter(Boolean).pop();

            try {
                const updateUrl = contentConfig.formSubmitHandlers.update.replace(':id', contentId);

                const response = await fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': contentConfig.csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PUT', // Laravel PUT request
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
                        title: contentConfig.successTitle,
                        text: contentConfig.updateSuccessMsg,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = contentConfig.indexRedirectUrl;
                    });
                } else {
                    Swal.fire(
                        contentConfig.errorTitle,
                        result.message || contentConfig.updateErrorMsg,
                        'error'
                    );
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire(
                    contentConfig.errorTitle,
                    contentConfig.updateErrorMsg,
                    'error'
                );
            }
        });
    }
});
