document.addEventListener('DOMContentLoaded', function () {
    // Initialize any form elements if needed

    // Submit form using AJAX
    const form = document.getElementById('editBoardForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Handle checkbox for is_active (when unchecked)
            if (!formData.has('is_active')) {
                formData.append('is_active', '0');
            }

            $.ajax({
                type: "POST",
                url: form.getAttribute('action'),
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        // Show success message and redirect
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            window.location.href = response.redirect;
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (xhr) {
                    // Handle validation errors
                    let errorMessage = 'Something went wrong. Please try again.';

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let firstError = Object.values(errors)[0][0];
                        errorMessage = firstError;
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    }
});
