document.addEventListener('DOMContentLoaded', function () {
    // File input preview functionality
    const fileInput = document.getElementById('cover_image');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');
    const removeButton = document.getElementById('remove-image');

    // Initialize flatpickr
    flatpickr('.basic-date', {
        enableTime: false,
        dateFormat: 'Y-m-d',
        locale: locale
    });

    // Handle file selection
    fileInput.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('d-none');
                removeButton.classList.remove('d-none');
            }

            reader.readAsDataURL(file);
        } else {
            previewImage.src = '';
            previewContainer.classList.add('d-none');
            removeButton.classList.add('d-none');
        }
    });

    // Handle remove button click
    removeButton.addEventListener('click', function() {
        fileInput.value = '';
        previewImage.src = '';
        previewContainer.classList.add('d-none');
        removeButton.classList.add('d-none');
    });
});
