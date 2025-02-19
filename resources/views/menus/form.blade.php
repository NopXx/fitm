@extends('layout.master-new')
@section('title', isset($menu) ? __('menu.edit_menu') : __('menu.add_menu'))

@section('css')
<style>
.language-tabs {
    margin-bottom: 20px;
}
.language-tabs .nav-link {
    padding: 5px 15px;
    border-radius: 0;
}
.language-tabs .nav-link.active {
    background-color: #4a5568;
    color: white;
}
</style>
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ isset($menu) ? __('menu.edit_menu') : __('menu.add_menu') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($menu) ? route('menus.update', $menu->id) : route('menus.store') }}"
                          method="POST">
                        @csrf
                        @if(isset($menu))
                            @method('PUT')
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">@lang('menu.parent_menu')</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">@lang('menu.no_parent')</option>
                                    @foreach($mainMenus as $mainMenu)
                                        <option value="{{ $mainMenu->id }}"
                                            {{ (isset($menu) && $menu->parent_id == $mainMenu->id) ? 'selected' : '' }}>
                                            {{ $mainMenu->translations->where('language_code', 'th')->first()->name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <ul class="nav nav-tabs language-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#thai">ภาษาไทย</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#english">English</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="thai" class="tab-pane active">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">@lang('menu.name_th')</label>
                                        <input type="text" name="name_th" class="form-control @error('name_th') is-invalid @enderror"
                                               value="{{ old('name_th', isset($menu) ? $menu->translations->where('language_code', 'th')->first()->name : '') }}">
                                        @error('name_th')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">@lang('menu.url_th')</label>
                                        <input type="text" name="url_th" class="form-control @error('url_th') is-invalid @enderror"
                                               value="{{ old('url_th', isset($menu) ? $menu->translations->where('language_code', 'th')->first()->url : '') }}">
                                        @error('url_th')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div id="english" class="tab-pane fade">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">@lang('menu.name_en')</label>
                                        <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                               value="{{ old('name_en', isset($menu) ? $menu->translations->where('language_code', 'en')->first()->name : '') }}">
                                        @error('name_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">@lang('menu.url_en')</label>
                                        <input type="text" name="url_en" class="form-control @error('url_en') is-invalid @enderror"
                                               value="{{ old('url_en', isset($menu) ? $menu->translations->where('language_code', 'en')->first()->url : '') }}">
                                        @error('url_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(isset($menu))
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" class="form-check-input"
                                           id="is_active" value="1" {{ $menu->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">@lang('menu.is_active')</label>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($menu) ? __('menu.update') : __('menu.save') }}
                                </button>
                                <a href="{{ route('menus.index') }}" class="btn btn-secondary">
                                    @lang('menu.cancel')
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
