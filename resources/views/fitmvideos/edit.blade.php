@extends('layout.master-new')
@section('title', __('fitmvideos.edit_video'))
@section('css')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('fitmvideos.edit_video')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('fitmvideos.index') }}">@lang('fitmvideos.title')</a></li>
                    <li class="active">@lang('translation.edit')</li>
                </ul>
            </div>
        </div>

        <!-- Form -->
        <div class="col-xl-12">
            <div class="card add-blog">
                <div class="card-body">
                    <form action="{{ route('fitmvideos.update', $video->id) }}" id="editFitmVideosForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $video->name) }}" required>
                                    <label>@lang('fitmvideos.name')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="url"
                                        value="{{ old('url', $video->url) }}" required>
                                    <label>@lang('fitmvideos.url')</label>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">@lang('fitmvideos.is_important')</label>
                                    <div>
                                        <label class="switch">
                                            <input type="checkbox" name="is_important" value="1"
                                                {{ $video->is_important ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary">@lang('translation.save')</button>
                                    <a href="{{ route('fitmvideos.index') }}"
                                        class="btn btn-outline-secondary">@lang('translation.cancel')</a>
                                </div>
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
        var locale = '{{ session()->get('lang') == null ? 'th' : session()->get('lang') }}'
        var csrf = '{{ csrf_token() }}'
    </script>

    <!-- sweetalert js-->
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
    <!-- edit js -->
    <script src="{{ asset('assets/js/fitmvideos_edit_init.js') }}"></script>
@endsection
