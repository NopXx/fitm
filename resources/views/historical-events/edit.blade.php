@extends('layout.master-new')
@section('title', __('historical_event.edit_title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <style>
        .preview-image {
            max-width: 200px;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('historical_event.edit_title')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('historical-events.index') }}" class="f-s-14 f-w-500">
                            <span>@lang('translation.data_management')</span>
                        </a>
                    </li>
                    <li>
                        <span>@lang('historical_event.edit_title')</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Form Card -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form id="editForm" action="{{ route('historical-events.update', $historicalEvent->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Year -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('historical_event.year') <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('year') is-invalid @enderror"
                                    name="year" value="{{ old('year', $historicalEvent->year) }}" required min="2500"
                                    max="2999">
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Thai Content Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>@lang('historical_event.thai_content')</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label class="form-label">@lang('historical_event.title_th') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title_th') is-invalid @enderror"
                                            name="title_th" value="{{ old('title_th', $historicalEvent->title_th ?? $historicalEvent->title) }}" required>
                                        @error('title_th')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label">@lang('historical_event.description_th') <span class="text-danger">*</span></label>
                                        <textarea name="description_th" class="form-control @error('description_th') is-invalid @enderror"
                                            rows="5" required>{{ old('description_th', $historicalEvent->description_th ?? $historicalEvent->description) }}</textarea>
                                        @error('description_th')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- English Content Section (Optional) -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5>@lang('historical_event.english_content') (@lang('translation.optional'))</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label class="form-label">@lang('historical_event.title_en')</label>
                                        <input type="text" class="form-control @error('title_en') is-invalid @enderror"
                                            name="title_en" value="{{ old('title_en', $historicalEvent->title_en ?? '') }}">
                                        @error('title_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label">@lang('historical_event.description_en')</label>
                                        <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror"
                                            rows="5">{{ old('description_en', $historicalEvent->description_en ?? '') }}</textarea>
                                        @error('description_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('historical_event.image')</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image" accept="image/*" id="imageInput">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Current Image Preview -->
                                @if ($historicalEvent->image_path)
                                    <div class="mt-2" id="currentImageContainer">
                                        <img src="{{ asset('storage/' . $historicalEvent->image_path) }}"
                                            alt="Current Image" class="preview-image">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-danger" id="removeImageBtn">
                                                <i class="ti ti-trash"></i> @lang('translation.remove_image')
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                <!-- New Image Preview -->
                                <div class="mt-2" id="newImagePreview" style="display: none;">
                                    <img src="" alt="Preview" class="preview-image">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">@lang('translation.save')</button>
                                <a href="{{ route('historical-events.index') }}"
                                    class="btn btn-secondary">@lang('translation.cancel')</a>
                            </div>
                        </div>

                        <!-- Hidden field for image removal -->
                        <input type="hidden" name="remove_image" value="0" id="removeImage">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image Preview Handler
            const imageInput = document.getElementById('imageInput');
            const newImagePreview = document.getElementById('newImagePreview');
            const previewImage = newImagePreview.querySelector('img');

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        newImagePreview.style.display = 'block';
                        if (document.getElementById('currentImageContainer')) {
                            document.getElementById('currentImageContainer').style.display = 'none';
                        }
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Remove Image Handler
            const removeImageBtn = document.getElementById('removeImageBtn');
            if (removeImageBtn) {
                removeImageBtn.addEventListener('click', function() {
                    document.getElementById('currentImageContainer').style.display = 'none';
                    document.getElementById('removeImage').value = '1';
                    imageInput.value = '';
                    newImagePreview.style.display = 'none';
                });
            }
        });
    </script>
@endsection