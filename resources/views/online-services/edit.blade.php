@extends('layout.master-new')
@section('title', __('online_services.edit_title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <style>
        /* Image preview */
        .image-preview {
            max-width: 100%;
            max-height: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            margin-top: 10px;
        }

        .current-image {
            max-width: 100%;
            max-height: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        /* Add validation styling */
        .is-invalid {
            border-color: #dc3545 !important;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('online_services.edit_title')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('online-services.index') }}" class="f-s-14 f-w-500">
                            <span>@lang('translation.data_management')</span>
                        </a>
                    </li>
                    <li>
                        <span>@lang('online_services.edit_title')</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="editForm" method="POST"
                        action="{{ route('online-services.update', ['onlineService' => $service->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('online_services.title_th') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title_th" id="title_th" value="{{ $service->title_th }}"
                                    required>
                                <div class="invalid-feedback" id="title_th_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('online_services.title_en') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title_en" id="title_en" value="{{ $service->title_en }}"
                                    required>
                                <div class="invalid-feedback" id="title_en_error"></div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('online_services.link') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="link" id="link" value="{{ $service->link }}" required>
                                <div class="invalid-feedback" id="link_error"></div>
                                <small class="text-muted">@lang('online_services.link_hint', ['default' => 'https://example.com'])</small>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">@lang('online_services.active')</label>
                                <select class="form-select" name="active">
                                    <option value="1" {{ $service->active ? 'selected' : '' }}>@lang('translation.yes')</option>
                                    <option value="0" {{ !$service->active ? 'selected' : '' }}>@lang('translation.no')</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">@lang('online_services.order')</label>
                                <input type="number" class="form-control" name="order" value="{{ $service->order }}" min="0">
                                <small class="text-muted">@lang('online_services.order_hint')</small>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">@lang('online_services.image')</label>
                                @if($service->image)
                                    <div class="mb-3">
                                        <p>@lang('online_services.image_current'):</p>
                                        <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->title_th }}" class="current-image">
                                    </div>
                                    <div class="mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="removeImage" name="remove_image" value="1">
                                            <label class="form-check-label" for="removeImage">
                                                @lang('online_services.remove_image')
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="image" id="imageInput" accept="image/*">
                                <div class="invalid-feedback" id="image_error"></div>
                                <small class="text-muted">@lang('online_services.image_change')</small>
                                <div id="imagePreviewContainer" class="mt-2" style="display: none;">
                                    <img id="imagePreview" src="#" alt="Image Preview" class="image-preview">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save me-1"></i> @lang('online_services.save')
                                </button>
                                <a href="{{ route('online-services.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> @lang('online_services.cancel')
                                </a>
                            </div>
                        </div>
                    </form>
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
            // Image preview
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const removeImageCheckbox = document.getElementById('removeImage');

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                    }

                    reader.readAsDataURL(this.files[0]);

                    // If user selects a new image, uncheck the remove image checkbox
                    if (removeImageCheckbox) {
                        removeImageCheckbox.checked = false;
                    }
                } else {
                    imagePreviewContainer.style.display = 'none';
                }
            });

            // If remove image is checked, disable file input
            if (removeImageCheckbox) {
                removeImageCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        imageInput.value = '';
                        imagePreviewContainer.style.display = 'none';
                    }
                });
            }

            // Validate form before submission
            function validateForm() {
                let isValid = true;
                const title_th = document.getElementById('title_th');
                const title_en = document.getElementById('title_en');
                const link = document.getElementById('link');

                // Reset validation
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');

                // Validate title_th
                if (!title_th.value.trim()) {
                    title_th.classList.add('is-invalid');
                    document.getElementById('title_th_error').textContent = '@lang("validation.required", ["attribute" => __("online_services.title_th")])';
                    document.getElementById('title_th_error').style.display = 'block';
                    isValid = false;
                }

                // Validate title_en
                if (!title_en.value.trim()) {
                    title_en.classList.add('is-invalid');
                    document.getElementById('title_en_error').textContent = '@lang("validation.required", ["attribute" => __("online_services.title_en")])';
                    document.getElementById('title_en_error').style.display = 'block';
                    isValid = false;
                }

                // Validate link
                if (!link.value.trim()) {
                    link.classList.add('is-invalid');
                    document.getElementById('link_error').textContent = '@lang("validation.required", ["attribute" => __("online_services.link")])';
                    document.getElementById('link_error').style.display = 'block';
                    isValid = false;
                }

                return isValid;
            }

            // Form submission with loading state
            document.querySelector('#editForm').addEventListener('submit', async function(e) {
                e.preventDefault();

                if (!validateForm()) {
                    return;
                }

                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> @lang("translation.processing")';
                submitBtn.disabled = true;

                // Use FormData for file upload
                const formData = new FormData(this);

                try {
                    const response = await fetch('{{ route('online-services.update', ['onlineService' => $service->id]) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        Swal.fire({
                            title: '@lang('translation.success')',
                            text: '@lang('online_services.update_success')',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = '{{ route('online-services.index') }}';
                        });
                    } else {
                        // Show validation errors
                        if (result.message && typeof result.message === 'object') {
                            Object.keys(result.message).forEach(field => {
                                const input = document.querySelector(`[name="${field}"]`);
                                const error = document.getElementById(`${field}_error`);
                                if (input && error) {
                                    input.classList.add('is-invalid');
                                    error.textContent = result.message[field][0];
                                    error.style.display = 'block';
                                }
                            });
                        } else {
                            Swal.fire(
                                '@lang('translation.error')',
                                result.message || '@lang('online_services.update_error')',
                                'error'
                            );
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire(
                        '@lang('translation.error')',
                        '@lang('online_services.update_error')',
                        'error'
                    );
                } finally {
                    // Reset button state
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                }
            });


        });
    </script>
@endsection
