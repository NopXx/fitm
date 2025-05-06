@extends('layout.master-new')
@section('title', __('online_services.title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}">
    <!-- Draggable CSS -->
    <style>
        #servicesTable tbody tr {
            cursor: move;
            cursor: -webkit-grabbing;
            transition: background-color 0.2s ease;
        }

        #servicesTable tbody tr.bg-light-primary {
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
        #servicesTable tbody tr:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.05) !important;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('online_services.title')</h4>
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
                    <div class="row">
                        <div class="col-xl-4">
                            <a href="{{ route('online-services.create') }}" class="card card-light-primary">
                                <div class="card-body">
                                    <i class="ti ti-file-plus icon-bg"></i>
                                    <h6>@lang('online_services.add_service')</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-auto">
                            <div class="alert alert-light-info " role="alert">
                                <i class="ti ti-info-circle me-2"></i>
                                <span>@lang('online_services.drag_instruction', ['default' => 'Click and drag any row to reorder services'])</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <div class="app-datatable-default overflow-auto">
                                <table id="servicesTable" class="display app-data-table default-data-table">
                                    <thead>
                                        <tr>
                                            <th>@lang('online_services.title_th')</th>
                                            <th>@lang('online_services.title_en')</th>
                                            <th>@lang('online_services.image')</th>
                                            <th class="d-none">@lang('online_services.order')</th>
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
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatable/jquery.dataTables.min.js') }}"></script>
    <!-- Sortable.js for drag and drop functionality -->
    <script src="{{ asset('assets/vendor/sortable/Sortable.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var base_image_url = '{{ asset('storage/') }}'
            var baseURL = '{{ url("/") }}'
            var services_table = $('#servicesTable').DataTable({
                destroy: true,
                search: true,
                ordering: true,
                processing: true,
                responsive: true,
                rowId: 'id', // Use the id field as the row identifier
                order: [
                    [3, 'asc']
                ], // Order by order column (index 3)
                ajax: {
                    type: 'GET',
                    url: '{{ route('online-services.get-services') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataSrc: function(response) {
                        return response;
                    },
                },
                columns: [{
                        data: 'title_th'
                    },
                    {
                        data: 'title_en'
                    },
                    {
                        data: 'image',
                        render: function(data) {
                            if (data) {
                                return `<img src="${base_image_url}/${data}" alt="Service Image" class="img-thumbnail" style="max-height: 50px">`;
                            }
                            return 'No Image';
                        }
                    },
                    {
                        data: 'order',
                        visible: false // Hide the order column
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="action-buttons">
                                <a href="${baseURL}/admin/online-services/${data.id}/edit" class="btn btn-light-primary icon-btn b-r-4 me-1">
                                    <i class="ti ti-edit text-primary"></i>
                                </a>
                                <button type="button" class="btn btn-light-danger icon-btn b-r-4 delete-btn">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>`;
                        }
                    }
                ],
                createdRow: function(row, data, index) {
                    // Add data attributes to each row for sorting
                    $(row).attr('data-id', data.id);
                    $(row).attr('data-order', data.order);
                }
            });

            // Initialize Sortable.js for table body after DataTable is fully rendered
            services_table.on('draw', function() {
                const tbody = document.querySelector('#servicesTable tbody');
                if (tbody && !tbody._sortable) {
                    tbody._sortable = new Sortable(tbody, {
                        animation: 150,
                        ghostClass: 'bg-light-primary',
                        draggable: 'tr',
                        onEnd: function(evt) {
                            updateDisplayOrder();
                        }
                    });
                }
            });

            // Function to update display order after dragging
            function updateDisplayOrder() {
                const rows = $('#servicesTable tbody tr');
                const orderData = [];

                // Collect data for all visible rows
                rows.each(function(index) {
                    const id = $(this).attr('data-id');
                    orderData.push({
                        id: id,
                        order: index + 1
                    });
                });

                // Send the updated order to the server
                if (orderData.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('online-services.update-order') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            orders: orderData
                        },
                        success: function(response) {
                            if (response.success) {
                                // Show success notification
                                Swal.fire({
                                    icon: 'success',
                                    title: '@lang('translation.success', ['default' => 'Success'])',
                                    text: '@lang('online_services.order_updated', ['default' => 'Service order updated successfully'])',
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                // Refresh the table to show updated order
                                services_table.ajax.reload(null, false);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: '@lang('translation.error', ['default' => 'Error'])',
                                    text: response.message || '@lang('online_services.update_error', ['default' => 'Failed to update service order'])'
                                });
                            }
                        },
                        error: function(error) {
                            console.error('Error updating order:', error);
                            Swal.fire({
                                icon: 'error',
                                title: '@lang('translation.error', ['default' => 'Error'])',
                                text: '@lang('online_services.update_error', ['default' => 'Failed to update service order'])'
                            });
                        }
                    });
                }
            }

            // Delete button handler
            $('.app-data-table').on('click', '.delete-btn', function() {
                const row = services_table.row($(this).closest('tr'));
                const data = row.data();

                Swal.fire({
                    title: '@lang('online_services.delete_confirm', ['default' => 'Are you sure?'])',
                    text: '@lang('online_services.delete_message', ['default' => "You won\'t be able to revert this!"])',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '@lang('translation.confirm', ['default' => 'Yes, delete it!'])',
                    cancelButtonText: '@lang('translation.cancel', ['default' => 'Cancel'])'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/online-services/delete/${data.id}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(
                                    '@lang('translation.deleted', ['default' => 'Deleted!'])',
                                    '@lang('online_services.deleted_success', ['default' => 'Service has been deleted.'])',
                                    'success'
                                );
                                services_table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    '@lang('translation.error', ['default' => 'Error!'])',
                                    '@lang('online_services.delete_error', ['default' => 'Failed to delete service.'])',
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
