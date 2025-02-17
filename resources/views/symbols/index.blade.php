@extends('layout.master-new')
@section('title', __('symbol.title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick-theme.css') }}">
    <style>
        .symbol-image {
            max-width: 200px;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }

        .lang-switch {
            margin-bottom: 20px;
        }

        .lang-switch .btn {
            margin-right: 10px;
        }

        .lang-switch .btn.active {
            background-color: #435ebe;
            color: white;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('symbol.title')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li>
                        <a href="#" class="f-s-14 f-w-500">
                            <span>@lang('symbol.data_management')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-4">
                            <a href="{{ route('symbols.create') }}" class="card card-light-primary">
                                <div class="card-body">
                                    <i class="ph-duotone ph-codesandbox-logo icon-bg"></i>
                                    <h6>@lang('symbol.create_title')</h6>
                                </div>
                            </a>
                        </div>
                    </div>

                    <ul class="app-side-timeline" id="timeline-container">
                        @foreach ($symbols as $index => $symbol)
                            <li class="side-timeline-section {{ $index % 2 == 0 ? 'left-side' : 'right-side' }}">
                                <div class="side-timeline-icon">
                                    <span class="text-light-primary h-25 w-25 d-flex-center b-r-50">
                                        <i
                                            class="ph-fill ph-circle f-s-12 rounded-circle animate__animated animate__zoomIn animate__infinite animate__slower"></i>
                                    </span>
                                </div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mt-2 text-primary">
                                            {{ app()->getLocale() == 'th' ? $symbol->name_th : $symbol->name_en }}
                                        </h6>
                                        <div>
                                            <a href="{{ route('symbols.edit', $symbol->id) }}"
                                                class="btn btn-light-primary btn-sm icon-btn">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-light-danger btn-sm icon-btn delete-btn"
                                                data-id="{{ $symbol->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="symbol-description">
                                        {!! app()->getLocale() == 'th' ? $symbol->description_th : $symbol->description_en !!}
                                    </div>
                                    @if ($symbol->type == 'university_color')
                                        <div class="mt-2">
                                            <strong>RGB:</strong> {{ $symbol->rgb_code }}<br>
                                            <strong>CMYK:</strong> {{ $symbol->cmyk_code }}
                                        </div>
                                    @endif
                                    @if ($symbol->image_path)
                                        <img src="{{ asset('storage/' . $symbol->image_path) }}"
                                            alt="{{ app()->getLocale() == 'th' ? $symbol->name_th : $symbol->name_en }}"
                                            class="symbol-image">
                                    @endif
                                    @if ($symbol->download_link)
                                        <div class="mt-2">
                                            <a href="{{ $symbol->download_link }}" target="_blank"
                                                class="btn btn-light-primary btn-sm">
                                                <i class="ti ti-download"></i> @lang('symbol.download')
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/timeline.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: '@lang('symbol.confirm_delete')',
                    text: '@lang('symbol.delete_warning')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '@lang('translation.yes_delete')',
                    cancelButtonText: '@lang('translation.cancel')'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/symbols/${id}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function() {
                                Swal.fire(
                                    '@lang('translation.deleted')',
                                    '@lang('symbol.delete_success')',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    '@lang('translation.error')',
                                    '@lang('symbol.delete_error')',
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
