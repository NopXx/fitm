@extends('layout.master-new')
@section('title', __('historical_event.title'))

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.css') }}">
    <!--  slick css-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick-theme.css') }}">
    <style>
        .timeline-image {
            max-width: 200px;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('historical_event.title')</h4>
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
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-4">
                            <a href="{{ route('historical-events.create') }}" class="card card-light-primary">
                                <div class="card-body">
                                    <i class="ph-bold ph-clock-clockwise icon-bg"></i>
                                    <h6>@lang('historical_event.add_event')</h6>
                                </div>
                            </a>
                        </div>
                    </div>

                    <ul class="app-side-timeline" id="timeline-container">
                        @foreach ($events as $index => $event)
                            <li class="side-timeline-section {{ $index % 2 == 0 ? 'left-side' : 'right-side' }}">
                                <div class="side-timeline-icon">
                                    <span class="text-light-primary h-25 w-25 d-flex-center b-r-50">
                                        <i
                                            class="ph-fill ph-circle f-s-12 rounded-circle animate__animated animate__zoomIn animate__infinite animate__slower"></i>
                                    </span>
                                </div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mt-2 text-primary">{{ $event->title }}</h6>
                                        <div>
                                            <a href="{{ route('historical-events.edit', $event->id) }}"
                                                class="btn btn-light-primary btn-sm icon-btn">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-light-danger btn-sm icon-btn delete-btn"
                                                data-id="{{ $event->id }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-dark">พ.ศ. {{ $event->year }}</p>
                                    <div>
                                        {!! $event->description !!}
                                    </div>
                                    @if ($event->image_path)
                                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}"
                                            class="timeline-image">
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
    <!--slick-file -->
    <script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>

    <!-- js-->
    <script src="{{ asset('assets/js/timeline.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Delete handler
            $('.delete-btn').on('click', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: '@lang('historical_event.confirm_delete')',
                    text: '@lang('historical_event.delete_warning')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '@lang('translation.yes_delete')',
                    cancelButtonText: '@lang('translation.cancel')'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/historical-events/delete/${id}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function() {
                                Swal.fire(
                                    '@lang('translation.deleted')',
                                    '@lang('historical_event.delete_success')',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    '@lang('translation.error')',
                                    '@lang('historical_event.delete_error')',
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
