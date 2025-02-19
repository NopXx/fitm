@extends('layout.master-new')
@section('title', __('content.title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatable/jquery.dataTables.min.css') }}">
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('content.title')</h4>
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
                            <a href="{{ route('contents.create') }}" class="card card-light-primary">
                                <div class="card-body">
                                    <i class="ti ti-file-plus icon-bg"></i>
                                    <h6>@lang('content.add_content')</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <div class="app-datatable-default overflow-auto">
                                <table id="contentsTable" class="display app-data-table default-data-table">
                                    <thead>
                                        <tr>
                                            <th>@lang('content.title_th')</th>
                                            <th>@lang('content.title_en')</th>
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
            var content_table = $('#contentsTable').DataTable({
                destroy: true,
                search: false,
                ordering: true,
                processing: true,
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: '/admin/contents/get-contents',
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
                        data: null,
                        render: function(data, type, row) {
                            return `
                            <a href="/admin/contents/${data.id}/edit" class="btn btn-light-primary icon-btn b-r-4">
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
                const row = content_table.row($(this).closest('tr'));
                const data = row.data();

                Swal.fire({
                    title: '@lang("content.delete_confirm")',
                    text: '@lang("content.delete_message")',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '@lang("translation.confirm")',
                    cancelButtonText: '@lang("translation.cancel")'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/contents/delete/${data.id}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire(
                                    '@lang("translation.deleted")',
                                    '@lang("content.deleted_success")',
                                    'success'
                                );
                                content_table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    '@lang("translation.error")',
                                    '@lang("content.delete_error")',
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
