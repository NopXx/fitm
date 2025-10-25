@extends('layout.master-new')

@section('title', __('popup.title'))

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('popup.heading')</h4>
                <p class="text-secondary mb-0">@lang('popup.description')</p>
            </div>
        </div>

        <div class="row m-1">
            <div class="col-xl-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('popup-settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label" for="title">@lang('popup.title_label')</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', optional($popup)->title) }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="link">@lang('popup.link_label')</label>
                                <input type="url" class="form-control" id="link" name="link"
                                    value="{{ old('link', optional($popup)->link) }}" placeholder="https://example.com">
                            </div>

                            <div class="form-check form-switch mb-4">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                    name="is_active" value="1"
                                    {{ old('is_active', optional($popup)->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">@lang('popup.status_label')</label>
                                <div class="form-text">@lang('popup.status_help')</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="image">@lang('popup.image')</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">@lang('popup.image_help')</div>
                            </div>

                            @if (!empty(optional($popup)->image_url))
                                <div class="mb-4">
                                    <label class="form-label d-block">@lang('popup.current_image')</label>
                                    <div class="border rounded p-3 text-center">
                                        <img src="{{ asset('storage/' . optional($popup)->image_url) }}" alt="popup image" class="img-fluid rounded">
                                    </div>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                <i class="ph ph-floppy-disk me-2"></i>@lang('popup.submit')
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
