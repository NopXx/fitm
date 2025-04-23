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
                                    <label class="form-label">@lang('menu.parent_menu') <span class="text-danger">*</span></label>
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
                                    <label class="form-label">@lang('menu.name_th') <span class="text-danger">*</span></label>
                                    <input type="text" name="name_th"
                                        class="form-control @error('name_th') is-invalid @enderror"
                                        value="{{ old('name_th', isset($menu) ? $menu->translations->where('language_code', 'th')->first()->name : '') }}">
                                    @error('name_th')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">@lang('menu.name_en') <span class="text-danger">*</span></label>
                                    <input type="text" name="name_en"
                                        class="form-control @error('name_en') is-invalid @enderror"
                                        value="{{ old('name_en', isset($menu) ? $menu->translations->where('language_code', 'en')->first()->name : '') }}">
                                    @error('name_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">@lang('menu.url') <span class="text-danger">*</span></label>
                                    <input type="text" name="url"
                                        class="form-control @error('url') is-invalid @enderror"
                                        value="{{ old('url', isset($menu) ? $menu->translations->where('language_code', 'th')->first()->url : '') }}">
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">@lang('menu.content_url')</label>
                                    <select name="content_id" class="form-select">
                                        <option value="">@lang('menu.select_content')</option>
                                        @foreach ($contents as $content)
                                            <option value="{{ $content->code }}">
                                                {{ $content->title_th }} ({{ $content->code }})
                                            </option>
                                        @endforeach
                                    </select>
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
            const contentSelect = document.querySelector('select[name="content_id"]');
            const urlInput = document.querySelector('input[name="url"]');
            const showDropdownToggle = document.querySelector('.show-dropdown-toggle');

            if (parentSelect && showDropdownToggle) {
                // Check on page load
                toggleShowDropdown(parentSelect.value);

                // Check when parent_id changes
                parentSelect.addEventListener('change', function() {
                    toggleShowDropdown(this.value);
                });
            }

            if (contentSelect && urlInput) {
                // Function to update content selection based on URL
                function updateContentSelection() {
                    const currentUrl = urlInput.value;
                    if (currentUrl && currentUrl.startsWith('/contents/')) {
                        const contentCode = currentUrl.replace('/contents/', '');

                        // Find and select the matching option
                        for (let i = 0; i < contentSelect.options.length; i++) {
                            if (contentSelect.options[i].value === contentCode) {
                                contentSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }
                }

                // Run on page load
                updateContentSelection();

                // Update URL when content selection changes
                contentSelect.addEventListener('change', function() {
                    urlInput.value = `/contents/${this.value}`;
                });

                // Listen for URL input changes to update content selection
                urlInput.addEventListener('input', updateContentSelection);
            }

            function toggleShowDropdown(parentId) {
                if (parentId === '') {
                    showDropdownToggle.style.display = 'block';
                } else {
                    showDropdownToggle.style.display = 'none';
                    // Uncheck show_dropdown when it's a sub-menu
                    const showDropdownCheckbox = document.getElementById('show_dropdown');
                    if (showDropdownCheckbox) {
                        showDropdownCheckbox.checked = false;
                    }
                }
            }
        });
    </script>
@endsection
