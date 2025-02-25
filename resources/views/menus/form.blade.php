@extends('layout.master-new')
@section('title', isset($menu) ? __('menu.edit_menu') : __('menu.add_menu'))

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
                            @if (isset($menu))
                                @method('PUT')
                            @endif

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">@lang('menu.parent_menu')</label>
                                    <select name="parent_id" class="form-select">
                                        <option value="">@lang('menu.no_parent')</option>
                                        @foreach ($mainMenus as $mainMenu)
                                            <option value="{{ $mainMenu->id }}"
                                                {{ isset($menu) && $menu->parent_id == $mainMenu->id ? 'selected' : '' }}>
                                                {{ $mainMenu->translations->where('language_code', 'th')->first()->name ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">@lang('menu.name_th')</label>
                                    <input type="text" name="name_th"
                                        class="form-control @error('name_th') is-invalid @enderror"
                                        value="{{ old('name_th', isset($menu) ? $menu->translations->where('language_code', 'th')->first()->name : '') }}">
                                    @error('name_th')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">@lang('menu.name_en')</label>
                                    <input type="text" name="name_en"
                                        class="form-control @error('name_en') is-invalid @enderror"
                                        value="{{ old('name_en', isset($menu) ? $menu->translations->where('language_code', 'en')->first()->name : '') }}">
                                    @error('name_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">@lang('menu.url')</label>
                                    <input type="text" name="url"
                                        class="form-control @error('url') is-invalid @enderror"
                                        value="{{ old('url', isset($menu) ? $menu->translations->where('language_code', 'th')->first()->url : '') }}">
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if (isset($menu))
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                                                value="1" {{ $menu->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">@lang('menu.is_active')</label>
                                        </div>

                                        <!-- แสดง show_dropdown เฉพาะเมนูหลัก (ไม่มี parent_id) -->
                                        @if (!$menu->parent_id)
                                            <div class="form-check mt-2">
                                                <input type="checkbox" name="show_dropdown" class="form-check-input"
                                                    id="show_dropdown" value="1"
                                                    {{ optional($menu->displaySetting)->show_dropdown ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="show_dropdown">@lang('menu.show_dropdown')</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <!-- สำหรับการสร้างเมนูใหม่ -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <!-- แสดง show_dropdown เฉพาะเมื่อไม่ได้เลือก parent_id -->
                                        <div class="form-check show-dropdown-toggle" style="display: none;">
                                            <input type="checkbox" name="show_dropdown" class="form-check-input"
                                                id="show_dropdown" value="1">
                                            <label class="form-check-label" for="show_dropdown">@lang('menu.show_dropdown')</label>
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

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const parentSelect = document.querySelector('select[name="parent_id"]');
            const showDropdownToggle = document.querySelector('.show-dropdown-toggle');

            if (parentSelect && showDropdownToggle) {
                // ตรวจสอบตอนโหลดหน้า
                toggleShowDropdown(parentSelect.value);

                // ตรวจสอบเมื่อมีการเปลี่ยนแปลง parent_id
                parentSelect.addEventListener('change', function() {
                    toggleShowDropdown(this.value);
                });
            }

            function toggleShowDropdown(parentId) {
                if (parentId === '') {
                    showDropdownToggle.style.display = 'block';
                } else {
                    showDropdownToggle.style.display = 'none';
                    // ยกเลิกการเลือก show_dropdown เมื่อเป็นเมนูย่อย
                    document.getElementById('show_dropdown').checked = false;
                }
            }
        });
    </script>
@endsection
