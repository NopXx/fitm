@extends('layout.master-new')
@section('title', __('historical_event.create_title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('historical_event.add_event')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('historical-events.index') }}" class="f-s-14 f-w-500">
                            <span>@lang('translation.data_management')</span>
                        </a>
                    </li>
                    <li>
                        <span>@lang('historical_event.create_title')</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('historical-events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">@lang('historical_event.year')</label>
                                <input type="number" class="form-control" name="year" required min="2500" max="2999" value="{{ old('year') }}">
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
                                        <label class="form-label">@lang('historical_event.title_th')</label>
                                        <input type="text" class="form-control" name="title_th" required value="{{ old('title_th') }}">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label">@lang('historical_event.description_th')</label>
                                        <textarea id="description_th" name="description_th" class="form-control" rows="5" required>{{ old('description_th') }}</textarea>
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
                                        <input type="text" class="form-control" name="title_en" value="{{ old('title_en') }}">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label">@lang('historical_event.description_en')</label>
                                        <textarea id="description_en" name="description_en" class="form-control" rows="5">{{ old('description_en') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">@lang('historical_event.image')</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">@lang('translation.save')</button>
                                <a href="{{ route('historical-events.index') }}" class="btn btn-secondary">@lang('translation.cancel')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection