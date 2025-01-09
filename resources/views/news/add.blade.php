@extends('layout.master-new')
@section('title', 'Add New')
@section('css')

    <!-- filepond css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/filepond/image-preview.min.css') }}">

    <!-- editor css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.css') }}">
@endsection
@section('main-content')
    <div class="container-fluid">

        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">Add Blog</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">

                            <span>
                                <i class="ph-duotone  ph-stack f-s-16"></i> New
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="f-s-14 f-w-500">DataTable</a>
                    </li>
                    <li class="active">
                        <a href="#" class="f-s-14 f-w-500">Add New</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Blog Details start -->
        <div class="col-xl-12">
            <div class="card add-blog">
                <div class="card-header">
                    <h5>Add Blog</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="title" placeholder="Blog Title" required>
                            <label>Blog Title</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" name="new_type" required>
                                <option value="">Select Type</option>
                                <option value="1">News</option>
                                <option value="2">Announcement</option>
                            </select>
                            <label>News Type</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="detail" placeholder="Blog Description" required></textarea>
                            <label>Blog Description</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" name="effective_date" required>
                            <label>Effective Date</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" name="cover" accept="image/jpeg, image/png">
                            <label>Cover Image</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="link"
                                placeholder="External Link (Optional)">
                            <label>External Link</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <label>Status</label>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Add Blog</button>
                            <a href="{{ route('new.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- Blog Details end -->

    </div>
@endsection

@section('script')
    <!--customizer-->
    {{-- <div id="customizer"></div> --}}

    <!-- Trumbowyg js -->
    <script src="{{ asset('assets/vendor/trumbowyg/trumbowyg.min.js') }}"></script>

    <!-- filepond -->
    <script src="{{ asset('assets/vendor/filepond/file-encode.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/validate-size.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/validate-type.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/exif-orientation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/image-preview.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/filepond/filepond.min.js') }}"></script>

    <!-- add blog js  -->
    <script src="{{ asset('assets/js/add_blog.js') }}"></script>
@endsection
