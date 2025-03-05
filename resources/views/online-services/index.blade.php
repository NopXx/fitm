@extends('layout.master-new')
@section('title', __('online_services.title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}">
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
                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <div class="app-datatable-default overflow-auto">
                                <table id="servicesTable" class="display app-data-table default-data-table">
                                    <thead>
                                        <tr>
                                            <th>@lang('online_services.title_th')</th>
                                            <th>@lang('online_services.title_en')</th>
                                            <th>@lang('online_services.image')</th>
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
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatable/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var base_image_url = '{{ asset('storage/') }}'
            var services_table = $('#servicesTable').DataTable({
                destroy: true,
                search: true,
                ordering: true,
                processing: true,
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: '{{ route("online-services.get-services") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataSrc: function(response) {
                        return response;
                    },
                },
                columns: [
                    { data: 'title_th' },
                    { data: 'title_en' },
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
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <a href="/admin/online-services/${data.id}/edit" class="btn btn-light-primary icon-btn b-r-4">
                                <i class="ti ti-edit text-primary"></i>
                            </a>
                            <button type="button" class="btn btn-light-danger icon-btn b-r-4 delete-btn">
                                <i class="ti ti-trash"></i>
                            </button>`;
                        }
                    }
                ]
            });

            $('.app-data-table').on('click', '.delete-btn', function() {
                const row = services_table.row($(this).closest('tr'));
                const data = row.data();

                Swal.fire({
                    title: '@lang('online_services.delete_confirm')',
                    text: `@lang('online_services.delete_message')`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '@lang('translation.confirm')',
                    cancelButtonText: '@lang('translation.cancel')'
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
                                    '@lang('translation.deleted')',
                                    '@lang('online_services.deleted_success')',
                                    'success'
                                );
                                services_table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    '@lang('translation.error')',
                                    '@lang('online_services.delete_error')',
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
