@extends('layout.master-new')
@section('title', __('personnel.edit_personnel'))
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

        .img-preview {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }
    </style>
@endsection

@section('main-content')

    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('personnel.edit_personnel')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('personnel.admin.index') }}">@lang('personnel.admin_title')</a></li>
                    <li class="active">@lang('translation.edit')</li>
                </ul>
            </div>
        </div>

        <!-- Form -->
        <div class="col-xl-12">
            <div class="card add-blog">
                <div class="card-body">
                    <form action="{{ route('personnel.admin.update', $personnel->id) }}" id="editPersonnelForm"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs mb-3" id="languageTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="thai-tab" data-bs-toggle="tab"
                                    data-bs-target="#thai-content" type="button" role="tab"
                                    aria-controls="thai-content" aria-selected="true">
                                    @lang('translation.thai_information')
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="english-tab" data-bs-toggle="tab"
                                    data-bs-target="#english-content" type="button" role="tab"
                                    aria-controls="english-content" aria-selected="false">
                                    @lang('translation.english_information_optional')
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="languageTabsContent">
                            <!-- Thai Content Tab -->
                            <div class="tab-pane fade show active" id="thai-content" role="tabpanel"
                                aria-labelledby="thai-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <select name="board_id" id="board_id" class="form-select" required>
                                                <option value="">@lang('personnel.select_board')</option>
                                                @foreach ($boards as $board)
                                                    <option value="{{ $board->id }}"
                                                        {{ $personnel->board_id == $board->id ? 'selected' : '' }}>
                                                        {{ $board->board_name_th }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="firstname_th"
                                                value="{{ old('firstname_th', $personnel->firstname_th) }}" required>
                                            <label>@lang('personnel.firstname_th')</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="lastname_th"
                                                value="{{ old('lastname_th', $personnel->lastname_th) }}" required>
                                            <label>@lang('personnel.lastname_th')</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="position_th"
                                                value="{{ old('position_th', $personnel->position_th) }}" required>
                                            <label>@lang('personnel.position_th')</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" name="display_order"
                                                value="{{ old('display_order', $personnel->display_order) }}">
                                            <label>@lang('personnel.display_order')</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="order_title_th"
                                                value="{{ old('order_title_th', $personnel->order_title_th) }}">
                                            <label>@lang('personnel.order_title_th')</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" name="email" placeholder="Email"
                                                value="{{ old('email', $personnel->email) }}">
                                            <label>@lang('personnel.email')</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="phone" placeholder="Phone"
                                                value="{{ old('phone', $personnel->phone) }}">
                                            <label>@lang('personnel.phone')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- English Content Tab -->
                            <div class="tab-pane fade" id="english-content" role="tabpanel" aria-labelledby="english-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="firstname_en"
                                                value="{{ old('firstname_en', $personnel->firstname_en) }}">
                                            <label>@lang('personnel.firstname_en')</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="lastname_en"
                                                value="{{ old('lastname_en', $personnel->lastname_en) }}">
                                            <label>@lang('personnel.lastname_en')</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="position_en"
                                                value="{{ old('position_en', $personnel->position_en) }}">
                                            <label>@lang('personnel.position_en')</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="order_title_en"
                                                value="{{ old('order_title_en', $personnel->order_title_en) }}">
                                            <label>@lang('personnel.order_title_en')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Common Fields (outside tabs) -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">@lang('personnel.image')</label>
                                    <input type="file" class="form-control" name="image" id="image"
                                        accept="image/*" onchange="previewImage(this)">
                                    <div class="mt-2">
                                        @if ($personnel->image)
                                            <img id="imgPreview" src="{{ asset('storage/' . $personnel->image) }}"
                                                class="img-preview" alt="Current Image">
                                        @else
                                            <img id="imgPreview" class="img-preview d-none" alt="Image Preview">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="d-block mb-2">@lang('personnel.status')</label>
                                    <label class="switch">
                                        <input type="checkbox" name="is_active" value="1"
                                            {{ $personnel->is_active ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                    </label>
                                    <span
                                        class="ms-2">{{ $personnel->is_active ? __('personnel.active') : __('personnel.inactive') }}</span>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary">@lang('translation.save')</button>
                                    <a href="{{ route('personnel.admin.index') }}"
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

        function previewImage(input) {
            var imgPreview = document.getElementById('imgPreview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('d-none');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- sweetalert js-->
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
    <!-- edit js -->
    <script src="{{ asset('assets/js/personnel_admin_edit_init.js') }}"></script>
@endsection
