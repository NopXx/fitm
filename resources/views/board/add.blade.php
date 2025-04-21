@extends('layout.master-new')
@section('title', __('boards.add_new'))
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

        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">@lang('boards.title')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="{{ route('boards.index') }}" class="f-s-14 f-w-500">@lang('boards.title')</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">@lang('boards.add_new')</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Form start -->
        <div class="col-xl-12">
            <div class="card add-blog">
                <div class="card-body">
                    <form action="{{ route('boards.store') }}" id="addBoardForm" class="app-form" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="board_name_th" placeholder="Board Name (TH)" required>
                                    <label>@lang('boards.board_name_th')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="board_name_en" placeholder="Board Name (EN)">
                                    <label>@lang('boards.board_name_en')</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="display_order" placeholder="Display Order" value="0">
                                    <label>@lang('boards.display_order')</label>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="d-block mb-2">@lang('boards.status')</label>
                                    <label class="switch">
                                        <input type="checkbox" name="is_active" value="1" checked>
                                        <span class="slider"></span>
                                    </label>
                                    <span class="ms-2">@lang('boards.active')</span>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="text-start">
                                    <button type="submit" class="btn btn-primary">@lang('translation.save')</button>
                                    <a href="{{ route('boards.index') }}"
                                        class="btn btn-outline-secondary">@lang('translation.cancel')</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Form end -->

    </div>
@endsection

@section('script')
    <script>
        var locale = '{{ session()->get('lang') == null ? 'th' : session()->get('lang') }}'
        var csrf = '{{ csrf_token() }}'
    </script>

    <!-- add new js  -->
    <!-- sweetalert js-->
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/js/boards_add_init.js') }}"></script>
@endsection
