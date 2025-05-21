@extends('layout.master-new')
@section('title', __('symbol.create_title'))

@section('css')
    <!-- TinyMCE -->
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <style>
        .tox-tinymce {
            min-height: 300px;
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
                <h4 class="main-title">@lang('symbol.create_title')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('symbols.index') }}" class="f-s-14 f-w-500">
                            <span>@lang('symbol.data_management')</span>
                        </a>
                    </li>
                    <li>
                        <span>@lang('symbol.create_title')</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('symbols.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('symbol.type') <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror" name="type" required>
                                    <option value="university_emblem">@lang('symbol.university_emblem')</option>
                                    <option value="university_color">@lang('symbol.university_color')</option>
                                    <option value="university_tree">@lang('symbol.university_tree')</option>
                                    <option value="faculty_logo">@lang('symbol.faculty_logo')</option>
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
                                    name="name_th" value="{{ old('name_th') }}" required>
                                @error('name_th')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('symbol.name_en')</label>
                                <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                    name="name_en" value="{{ old('name_en') }}">
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('symbol.description_th') <span class="text-danger">*</span></label>
                                <textarea id="description_th" name="description_th" class="form-control @error('description_th') is-invalid @enderror">{{ old('description_th') }}</textarea>
                                @error('description_th')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('symbol.description_en')</label>
                                <textarea id="description_en" name="description_en" class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en') }}</textarea>
                                @error('description_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('symbol.image') <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image" accept="image/*" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('symbol.rgb_code')</label>
                                <input type="text" class="form-control @error('rgb_code') is-invalid @enderror"
                                    name="rgb_code" placeholder="#AC3520" value="{{ old('rgb_code') }}">
                                @error('rgb_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">@lang('symbol.cmyk_code')</label>
                                <input type="text" class="form-control @error('cmyk_code') is-invalid @enderror"
                                    name="cmyk_code" placeholder="5%, 85%, 85%, 30%" value="{{ old('cmyk_code') }}">
                                @error('cmyk_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('symbol.download_link')</label>
                                <input type="text" class="form-control @error('download_link') is-invalid @enderror"
                                    name="download_link" value="{{ old('download_link') }}">
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
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        tinymce.init({
            selector: '#description_th',
            height: 300,
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            language: 'th',
            promotion: false,
            branding: false
        });

        tinymce.init({
            selector: '#description_en',
            height: 300,
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            language: 'en',
            promotion: false,
            branding: false
        });
    </script>
@endsection
