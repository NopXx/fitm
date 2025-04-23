document.addEventListener('DOMContentLoaded', function () {
    // Submit form using AJAX
    const form = document.getElementById('addPersonnelForm');
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

    // Initialize order title autocomplete
    initOrderTitleAutocomplete();

});

function initOrderTitleAutocomplete() {
    const displayOrderSelect = document.getElementById('display_order');
    const orderTitleThInput = document.querySelector('input[name="order_title_th"]');
    const orderTitleEnInput = document.querySelector('input[name="order_title_en"]');

    if (displayOrderSelect && orderTitleThInput && orderTitleEnInput) {
        // Define order titles mapping
        const orderTitles = {
            '0': {
                th: 'คณบดี,หัวหน้าภาควิชา,หัวหน้าสำนักงาน',
                en: 'Dean, Department Head, Office Head'
            },
            '1': {
                th: 'รองคณบดี,ผู้ช่วยหัวหน้าภาควิชา,สายสนับสนุนวิชาการ',
                en: 'Associate Dean, Assistant Department Head, Academic Support Staff'
            },
            '2': {
                th: 'ผู้ช่วยคณบดี,อาจารย์ประจำภาควิชา',
                en: 'Assistant Dean, Department Faculty/Professor'
            },
            '3': {
                th: 'สายสนับสนุนวิชาการ',
                en: 'Academic Support Staff'
            }
        };

        // Add change event listener to display order select
        displayOrderSelect.addEventListener('change', function () {
            const selectedOrder = this.value;

            if (selectedOrder && orderTitles[selectedOrder]) {
                orderTitleThInput.value = orderTitles[selectedOrder].th;
                orderTitleEnInput.value = orderTitles[selectedOrder].en;
            } else {
                orderTitleThInput.value = '';
                orderTitleEnInput.value = '';
            }
        });
    }
}
