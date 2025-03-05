@extends('layout.master-new')
@section('title', __('fitmnews.title'))

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
                <h4 class="main-title">@lang('fitmnews.title')</h4>
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
                            <a href="{{ route('fitmnews.add') }}" class="card card-light-primary">
                                <div class="card-body">
                                    <i class="ti ti-news icon-bg"></i>
                                    <h6>@lang('fitmnews.add_new')</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-8"></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="app-datatable-default overflow-auto">
                                <table id="example" class="display app-data-table default-data-table">
                                    <thead>
                                        <tr>
                                            <th>@lang('fitmnews.issue_name')</th>
                                            <th>@lang('fitmnews.table_title')</th>
                                            <th>@lang('fitmnews.published_date')</th>
                                            <th>@lang('fitmnews.description')</th>
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
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>

    <script>
        var lang = {
            'confirm': '@lang('fitmnews.confirm_delete')',
            'yes_delete': '@lang('fitmnews.yes_delete')',
            'cancel': '@lang('fitmnews.cancel')',
            'deleted': '@lang('fitmnews.deleted')',
            'delete_success': '@lang('fitmnews.delete_success')',
            'error': '@lang('fitmnews.error')',
            'delete_error': '@lang('fitmnews.delete_error')',
            'filter_by_issue': '@lang('fitmnews.filter_by_issue')',
            'all_issues': '@lang('fitmnews.all_issues')'
        };
    </script>

    {{-- init page fitmnews js --}}
    <script src="{{ asset('assets/js/fitmnews_init.js') }}"></script>
@endsection
