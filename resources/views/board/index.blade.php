@extends('layout.master-new')
@section('title', __('boards.title'))

@section('css')
    <!--font-awesome-css-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">

    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}">

    <!-- Draggable CSS -->
    <style>
        #boardTable tbody tr {
            cursor: move;
            cursor: -webkit-grabbing;
            transition: background-color 0.2s ease;
        }

        #boardTable tbody tr.bg-light-primary {
            background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
        }

        .sorting_disabled.sorting_asc:after,
        .sorting_disabled.sorting_desc:after {
            display: none !important;
        }

        /* Make sure action buttons don't interfere with dragging */
        .action-buttons {
            pointer-events: auto;
            z-index: 10;
            position: relative;
        }

        /* Add a subtle visual indicator that rows are draggable */
        #boardTable tbody tr:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.05) !important;
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
                            <a href="{{ route('boards.add') }}" class="card card-light-primary">
                                <div class="card-body">
                                    <i class="ti ti-plus icon-bg"></i>
                                    <h6>@lang('boards.add_new')</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-auto">
                            <div class="alert alert-light-info " role="alert">
                                <i class="ti ti-info-circle me-2"></i>
                                <span>@lang('boards.drag_instruction', ['default' => 'Click and drag any row to reorder items'])</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <div class="app-datatable-default overflow-auto">
                                <table id="boardTable" class="display app-data-table default-data-table">
                                    <thead>
                                        <tr>
                                            <th>@lang('boards.board_name_th')</th>
                                            <th>@lang('boards.board_name_en')</th>
                                            <th class="d-none">@lang('boards.display_order')</th>
                                            <th>@lang('boards.status')</th>
                                            <th>@lang('translation.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="draggable-content">
                                        <!-- Table content will be loaded dynamically -->
                                    </tbody>
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
    <!-- Sortable.js for drag and drop functionality -->
    <script src="{{ asset('assets/vendor/sortable/Sortable.min.js') }}"></script>

    <script>
        var lang = {
            'confirm': '@lang('boards.confirm_delete')',
            'yes_delete': '@lang('translation.confirm')',
            'cancel': '@lang('boards.cancel')',
            'deleted': '@lang('boards.deleted')',
            'delete_success': '@lang('boards.delete_success')',
            'error': '@lang('boards.error')',
            'delete_error': '@lang('boards.delete_error')',
            'yes': '@lang('translation.yes')',
            'no': '@lang('translation.no')',
            'active': '@lang('boards.active')',
            'inactive': '@lang('boards.inactive')',
            'success': '@lang('translation.success', ['default' => 'Success'])',
            'order_updated': '@lang('boards.order_updated', ['default' => 'Display order updated successfully'])',
            'update_error': '@lang('boards.update_error', ['default' => 'Failed to update display order'])'
        };
    </script>

    {{-- init page boards js --}}
    <script>
        var baseUrl = '{{ url("/") }}';
    </script>
    <script src="{{ asset('assets/js/boards_init.js') }}"></script>
@endsection
