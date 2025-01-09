@extends('layout.master-new')
@section('title', __('new.title'))

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
                <h4 class="main-title">@lang('new.title')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                <i class="ph-duotone  ph-table f-s-16"></i> Table
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
                <div class="card-header">
                    <h5>@lang('new.title')</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <a href="{{ route('new.add') }}" class="card hover-effect card-success">
                                <div class="card-body">
                                    <i class="ti ti-news icon-bg"></i>
                                    <h6>@lang('new.add_new')</h6>
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
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Start date</th>
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

    {{-- init page newjs --}}
    <script src="{{ asset('assets/js/new_init.js') }}"></script>
@endsection
