@extends('layout.master-new')
@section('title', __('users.edit_user'))
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
                <h4 class="main-title">@lang('users.edit_user')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li><a href="{{ route('users.index') }}">@lang('users.title')</a></li>
                    <li class="active">@lang('users.edit_user')</li>
                </ul>
            </div>
        </div>

        <!-- Form -->
        <div class="col-xl-12">
            <div class="card add-blog">
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="f_name"
                                        value="{{ old('f_name', $user->f_name) }}" required>
                                    <label>@lang('users.f_name') <span class="text-danger">*</span></label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="l_name"
                                        value="{{ old('l_name', $user->l_name) }}" required>
                                    <label>@lang('users.l_name') <span class="text-danger">*</span></label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', $user->email) }}" required>
                                    <label>@lang('users.email') <span class="text-danger">*</span></label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    <label>@lang('users.password') (@lang('users.leave_empty'))</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="tel" class="form-control" name="tel"
                                        value="{{ old('tel', $user->tel) }}">
                                    <label>@lang('users.tel') <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary">@lang('translation.save')</button>
                                    <a href="{{ route('users.index') }}"
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
    <script src="{{ asset('assets/js/users_edit_init.js') }}"></script>
@endsection
