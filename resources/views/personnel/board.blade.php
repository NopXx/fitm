@extends('layout.app')
@section('title')
    {{ $board->board_name }}
@endsection
@section('css')
    <style>
        .personnel-card-img {
            height: 240px;
            object-fit: contain;
        }

        .personnel-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .personnel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- หัวข้อและปุ่มเปลี่ยนภาษา -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('personnel.index') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                                {{ __('personnel.title') }}
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $board->board_name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold text-gray-800">{{ $board->board_name }}</h1>
            </div>
        </div>

        <!-- แสดงข้อมูลบุคลากรในหน่วยงาน -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8">
            @foreach ($personnel as $person)
                <div class="personnel-card bg-white rounded-lg overflow-hidden shadow-md">
                    <a href="{{ route('personnel.show', $person->id) }}">
                        @if ($person->image)
                            <img src="{{ asset('storage/' . $person->image) }}" alt="{{ $person->full_name }}"
                                class="w-full personnel-card-img">
                        @else
                            <div class="w-full personnel-card-img bg-gray-100 flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                    </a>

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $person->full_name }}</h3>
                        <p class="text-gray-600 mb-2">{{ $person->position }}</p>

                        @if ($person->order_title)
                            <p class="text-sm text-gray-500 italic">{{ $person->order_title }}</p>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('personnel.show', $person->id) }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                {{ __('personnel.view_profile') }}
                                <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- ปุ่มกลับไปหน้าหลัก -->
        <div class="mt-12">
            <a href="{{ route('personnel.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200">
                <svg class="w-3.5 h-3.5 mr-2 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
                {{ __('personnel.back_to_all_personnel') }}
            </a>
        </div>
    </div>
@endsection

@section('script-app')
    <script>
        // เพิ่ม script เพิ่มเติมตามต้องการ
    </script>
@endsection
