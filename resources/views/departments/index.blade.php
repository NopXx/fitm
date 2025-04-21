@extends('layout.master-new')
@section('title', __('department.title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}">
    <style>
        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .status-draft {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        .status-published {
            background-color: #dcfce7;
            color: #166534;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('translation.department')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>@lang('translation.data_management')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card add-blog">
                <div class="card-body">
                    <!-- Management Tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#departments">
                                @lang('translation.department')
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Departments Tab -->
                        <div class="tab-pane fade show active" id="departments">
                            <div class="row">
                                <div class="col-xl-4">
                                    <a href="{{ route('departments.create') }}" class="card card-light-primary">
                                        <div class="card-body">
                                            <i class="ti ti-building-bank icon-bg"></i>
                                            <h6>@lang('department.add_department')</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-xl-12">
                                    <div class="app-datatable-default overflow-auto">
                                        <table id="departmentsTable" class="display app-data-table default-data-table">
                                            <thead>
                                                <tr>
                                                    <th>@lang('department.code')</th>
                                                    <th>@lang('department.name_th')</th>
                                                    <th>@lang('department.name_en')</th>
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
        </div>
    </div>
@endsection

@section('script')
    <!-- sweetalert js-->
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatable/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var department_table
            // Departments DataTable
            function departmentTable() {
                department_table = $('#departmentsTable').DataTable({
                    destroy: true,
                    search: false,
                    ordering: true,
                    processing: true,
                    responsive: true,
                    ajax: {
                        type: 'GET',
                        url: '/admin/departments',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataSrc: function(response) {
                            return response;
                        },
                    },
                    columns: [
                        {
                            data: 'department_code'
                        },
                        {
                            data: 'department_name_th'
                        },
                        {
                            data: 'department_name_en',
                            render: function(data) {
                                return data || '-';
                            }
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                let contentEditBtn = '';
                                let contentPreviewBtn = '';

                                return `
                                ${contentEditBtn}
                                ${contentPreviewBtn}
                                <a href="/admin/department/edit/${data.id}" type="button" class="btn btn-light-primary icon-btn b-r-4 me-1" title="@lang('department.edit')">
                                    <i class="ti ti-edit text-primary"></i>
                                </a>
                                <button type="button" class="btn btn-light-danger icon-btn b-r-4 delete-btn" title="@lang('department.delete')">
                                    <i class="ti ti-trash"></i>
                                </button>`;
                            }
                        }
                    ],
                });
            }

            // Initialize DataTables
            departmentTable();

            // Delete button handler
            $('.app-data-table').on('click', '.delete-btn', function() {
                const table = $(this).closest('table').DataTable();
                const row = table.row($(this).closest('tr'));
                const data = row.data();

                // Determine the appropriate delete URL based on the table's ID.
                let deleteUrl = '';
                const tableId = $(this).closest('table').attr('id');
                if (tableId === 'departmentsTable') {
                    deleteUrl = `/admin/department/delete/${data.id}`;
                }

                // Confirm deletion using SweetAlert.
                Swal.fire({
                    title: '@lang('department.delete_confirm')',
                    text: "@lang('content.delete_message')",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '@lang('translation.confirm')',
                    cancelButtonText: '@lang('translation.cancel')'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(
                                    '@lang('translation.deleted')',
                                    '@lang('department.deleted_success')',
                                    'success'
                                );
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    '@lang('translation.error')',
                                    '@lang('department.delete_error')',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection