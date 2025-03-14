@extends('layout.master-new')
@section('title', __('personnel.admin_title'))

@section('css')
    <!--font-awesome-css-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">

    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}">
@endsection

@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">@lang('personnel.admin_title')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                @lang('translation.data_management')
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->
        {{-- Content --}}
        <div class="col-xl-12">
            <div class="card add-blog">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <a href="{{ route('personnel.admin.add') }}" class="card card-light-primary">
                                <div class="card-body">
                                    <i class="ti ti-user-plus icon-bg"></i>
                                    <h6>@lang('personnel.add_new')</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-8"></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="app-datatable-default overflow-auto">
                                <table id="personnelTable" class="display app-data-table default-data-table">
                                    <thead>
                                        <tr>
                                            <th>@lang('personnel.image')</th>
                                            <th>@lang('personnel.fullname_th')</th>
                                            <th>@lang('personnel.position_th')</th>
                                            <th>@lang('personnel.board')</th>
                                            <th>@lang('personnel.display_order')</th>
                                            <th>@lang('personnel.status')</th>
                                            <th>@lang('translation.action')</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendor/datatable/jquery.dataTables.min.js') }}"></script>
    <!-- sweetalert js-->
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/vendor/moment/moment.min.js') }}"></script>

    <script>
        var lang = {
            'confirm': '@lang('personnel.confirm_delete')',
            'yes_delete': '@lang('translation.confirm')',
            'cancel': '@lang('personnel.cancel')',
            'deleted': '@lang('personnel.deleted')',
            'delete_success': '@lang('personnel.delete_success')',
            'error': '@lang('personnel.error')',
            'delete_error': '@lang('personnel.delete_error')',
            'yes': '@lang('translation.yes')',
            'no': '@lang('translation.no')',
            'active': '@lang('personnel.active')',
            'inactive': '@lang('personnel.inactive')',
            'filter_by_board': '@lang('personnel.filter_by_board')',
            'all_boards': '@lang('personnel.all_boards')'
        };
    </script>

    <!-- init page js -->
    <script src="{{ asset('assets/js/personnel_admin_init.js') }}"></script>
@endsection
