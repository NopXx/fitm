@extends('layout.app')

@section('css')
    <style>
        .profile-image {
            max-height: 400px;
            object-fit: cover;
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
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <a href="{{ route('personnel.board', $person->board_id) }}"
                                    class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">{{ $person->board->board_name }}</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $person->full_name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl font-bold text-gray-800">{{ $person->full_name }}</h1>
            </div>
        </div>

        <!-- ข้อมูลบุคลากร -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
            <div class="md:flex">
                <!-- รูปภาพ -->
                <div class="md:w-1/3">
                    @if ($person->image)
                        <img src="{{ asset('storage/' . $person->image) }}" alt="{{ $person->full_name }}"
                            class="w-full profile-image">
                    @else
                        <div class="w-full h-64 md:h-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-32 h-32 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- รายละเอียด -->
                <div class="md:w-2/3 p-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $person->full_name }}</h2>
                        <p class="text-lg text-blue-700 font-semibold">{{ $person->position }}</p>
                        @if ($person->order_title)
                            <p class="text-gray-600 mt-1">{{ $person->order_title }}</p>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('personnel.department') }}</h3>
                        <p class="text-gray-600">{{ $person->board->board_name }}</p>
                    </div>

                    <!-- สามารถเพิ่มข้อมูลเพิ่มเติมตามต้องการได้ตรงนี้ เช่น ประวัติการศึกษา, ผลงาน, การติดต่อ ฯลฯ -->

                    <!-- ตัวอย่างส่วนข้อมูลเพิ่มเติม (สามารถเพิ่มหรือแก้ไขตามข้อมูลที่มี) -->
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('personnel.contact_info') }}</h3>
                        <p class="text-gray-600">
                            <strong>{{ __('personnel.email') }}:</strong>
                            <a href="mailto:{{ strtolower(str_replace(' ', '.', $person->email)) }}"
                                class="text-blue-600 hover:underline">
                                {{ strtolower(str_replace(' ', '.', $person->email)) }}
                            </a>
                        </p>
                        <p class="text-gray-600 mt-3">
                            <strong>{{ __('personnel.phone') }}:</strong>
                            <a href="mailto:{{ strtolower(str_replace(' ', '.', $person->phone)) }}"
                                class="text-blue-600 hover:underline">
                                {{ strtolower(str_replace(' ', '.', $person->phone)) }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ปุ่มกลับไปหน้าหน่วยงาน -->
        <div class="mt-8">
            <a href="{{ route('personnel.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200">
                <svg class="w-3.5 h-3.5 mr-2 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
                {{ __('personnel.back_to_board') }}
            </a>
        </div>
    </div>
@endsection

@section('script-app')
    <script>
        // เพิ่ม script เพิ่มเติมตามต้องการ
    </script>
@endsection
