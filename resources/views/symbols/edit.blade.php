@extends('layout.master-new')
@section('title', __('symbol.edit_title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css">
    <style>
        .ck-editor__editable {
            min-height: 300px;
        }
        .preview-image {
            max-width: 200px;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
        }
        .lang-switch {
            margin-bottom: 20px;
        }
        .lang-switch .btn {
            margin-right: 10px;
        }
        .lang-switch .btn.active {
            background-color: #435ebe;
            color: white;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('symbol.edit_title')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('symbols.index') }}" class="f-s-14 f-w-500">
                            <span>@lang('symbol.data_management')</span>
                        </a>
                    </li>
                    <li>
                        <span>@lang('symbol.edit_title')</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('symbols.update', $symbol->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('symbol.type') <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror" name="type" required>
                                    <option value="university_emblem" {{ $symbol->type == 'university_emblem' ? 'selected' : '' }}>
                                        @lang('symbol.university_emblem')
                                    </option>
                                    <option value="university_color" {{ $symbol->type == 'university_color' ? 'selected' : '' }}>
                                        @lang('symbol.university_color')
                                    </option>
                                    <option value="university_tree" {{ $symbol->type == 'university_tree' ? 'selected' : '' }}>
                                        @lang('symbol.university_tree')
                                    </option>
                                    <option value="faculty_logo" {{ $symbol->type == 'faculty_logo' ? 'selected' : '' }}>
                                        @lang('symbol.faculty_logo')
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('symbol.name_th') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name_th') is-invalid @enderror"
                                       name="name_th" value="{{ old('name_th', $symbol->name_th) }}" required>
                                @error('name_th')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('symbol.name_en')</label>
                                <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                       name="name_en" value="{{ old('name_en', $symbol->name_en) }}">
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('symbol.description_th') <span class="text-danger">*</span></label>
                                <textarea id="description_th" name="description_th"
                                          class="form-control @error('description_th') is-invalid @enderror">{{ old('description_th', $symbol->description_th) }}</textarea>
                                @error('description_th')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('symbol.description_en')</label>
                                <textarea id="description_en" name="description_en"
                                          class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en', $symbol->description_en) }}</textarea>
                                @error('description_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('symbol.image') <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                       name="image" accept="image/*" id="imageInput">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($symbol->image_path)
                                    <div class="mt-2" id="currentImageContainer">
                                        <img src="{{ asset('storage/' . $symbol->image_path) }}"
                                             alt="Current Image" class="preview-image">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-danger" id="removeImageBtn">
                                                <i class="ti ti-trash"></i> @lang('symbol.remove_image')
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-2" id="newImagePreview" style="display: none;">
                                    <img src="" alt="Preview" class="preview-image">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('symbol.rgb_code')</label>
                                <input type="text" class="form-control @error('rgb_code') is-invalid @enderror"
                                       name="rgb_code" placeholder="#AC3520" value="{{ old('rgb_code', $symbol->rgb_code) }}">
                                @error('rgb_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('symbol.cmyk_code')</label>
                                <input type="text" class="form-control @error('cmyk_code') is-invalid @enderror"
                                       name="cmyk_code" placeholder="5%, 85%, 85%, 30%" value="{{ old('cmyk_code', $symbol->cmyk_code) }}">
                                @error('cmyk_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('symbol.download_link')</label>
                                <input type="text" class="form-control @error('download_link') is-invalid @enderror"
                                       name="download_link" value="{{ old('download_link', $symbol->download_link) }}">
                                @error('download_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">@lang('translation.save')</button>
                                <a href="{{ route('symbols.index') }}" class="btn btn-secondary">@lang('translation.cancel')</a>
                            </div>
                        </div>

                        <input type="hidden" name="remove_image" value="0" id="removeImage">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>
    <script>
        const {
            ClassicEditor,
            Essentials,
            Paragraph,
            Bold,
            Italic,
            Heading,
            Link,
            List,
            Table,
            BlockQuote,
            MediaEmbed
        } = CKEDITOR;

        // Initialize CKEditor for Thai description
        ClassicEditor
            .create(document.querySelector('#description_th'), {
                extraPlugins: [
                    Essentials,
                    Paragraph,
                    Bold,
                    Italic,
                    Heading,
                    Link,
                    List,
                    Table,
                    BlockQuote,
                    MediaEmbed
                ],
                licenseKey: '{{ env('CKEDITOR_KEY') }}',
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        '|',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'link',
                        'blockQuote',
                        '|',
                        'undo',
                        'redo'
                    ]
                }
            })
            .catch(error => {
                console.error('CKEditor TH initialization error:', error);
            });

        // Initialize CKEditor for English description
        ClassicEditor
            .create(document.querySelector('#description_en'), {
                extraPlugins: [
                    Essentials,
                    Paragraph,
                    Bold,
                    Italic,
                    Heading,
                    Link,
                    List,
                    Table,
                    BlockQuote,
                    MediaEmbed
                ],
                licenseKey: '{{ env('CKEDITOR_KEY') }}',
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        '|',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'link',
                        'blockQuote',
                        '|',
                        'undo',
                        'redo'
                    ]
                }
            })
            .catch(error => {
                console.error('CKEditor EN initialization error:', error);
            });

        // Image Preview and Remove Image Handlers
        document.addEventListener('DOMContentLoaded', function() {
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
