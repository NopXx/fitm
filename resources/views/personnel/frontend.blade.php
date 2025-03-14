@extends('layout.app')

@section('css')
    <style>
        .org-chart {
            margin-bottom: 3rem;
        }

        .org-chart-header {
            margin-bottom: 2rem;
        }

        .org-chart-leader {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 250px;
            margin: 0 auto 1.5rem;
        }

        .org-chart-leader-img-wrapper {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .org-chart-leader-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .org-chart-leader-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            position: relative;
            padding-top: 1rem;
            margin-top: 0.5rem;
        }

        :root.dark .org-chart-leader-name {
            color: #f3f4f6;
        }

        .org-chart-leader-name:before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: #ef4444;
        }

        .org-chart-leader-title {
            font-size: 0.95rem;
            color: #4b5563;
            text-align: center;
        }

        :root.dark .org-chart-leader-title {
            color: #d1d5db;
        }

        .org-chart-order-title {
            font-size: 0.875rem;
            color: #6b7280;
            font-style: italic;
            text-align: center;
            margin-top: 0.25rem;
        }

        :root.dark .org-chart-order-title {
            color: #9ca3af;
        }

        .org-chart-connector {
            width: 2px;
            height: 60px;
            background-color: #d1d5db;
            margin: 0 auto;
        }

        :root.dark .org-chart-connector {
            background-color: #4b5563;
        }

        .org-chart-reports-container {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1.5rem;
            position: relative;
            margin-bottom: 2rem;
        }

        :root.dark .org-chart-reports-container {
            border-color: #374151;
            background-color: #1f2937;
        }

        .org-chart-reports-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #111827;
            text-align: center;
        }

        :root.dark .org-chart-reports-title {
            color: #f3f4f6;
        }

        .org-chart-reports {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }

        .org-chart-person {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 160px;
            text-align: center;
            position: relative;
            transition: transform 0.3s ease;
        }

        .org-chart-person:hover {
            transform: translateY(-5px);
        }

        .org-chart-person-img-wrapper {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 0.75rem;
            position: relative;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .org-chart-person-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .reports-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 28px;
            height: 28px;
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        :root.dark .reports-indicator {
            background-color: #374151;
            border-color: #4b5563;
        }

        .reports-indicator svg {
            width: 16px;
            height: 16px;
            color: #9ca3af;
        }

        .org-chart-person-name {
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        :root.dark .org-chart-person-name {
            color: #f3f4f6;
        }

        .org-chart-person-title {
            font-size: 0.875rem;
            color: #4b5563;
        }

        :root.dark .org-chart-person-title {
            color: #d1d5db;
        }

        .org-chart-person-placeholder {
            width: 100px;
            height: 100px;
            background-color: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
        }

        :root.dark .org-chart-person-placeholder {
            background-color: #4b5563;
        }

        :root.dark .org-chart-person-placeholder svg {
            color: #9ca3af;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .org-chart-reports {
                gap: 1rem;
            }

            .org-chart-person {
                width: 120px;
            }

            .org-chart-person-img-wrapper {
                width: 80px;
                height: 80px;
            }

            .reports-indicator {
                width: 24px;
                height: 24px;
            }

            .reports-indicator svg {
                width: 14px;
                height: 14px;
            }
        }

        /* Dark mode for board menu */
        :root.dark .bg-white {
            background-color: #1f2937;
        }

        :root.dark .text-gray-600 {
            color: #d1d5db;
        }

        :root.dark .text-gray-800 {
            color: #f3f4f6;
        }

        :root.dark .text-gray-500 {
            color: #9ca3af;
        }

        :root.dark .bg-blue-100 {
            background-color: rgba(59, 130, 246, 0.2);
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- หัวข้อและเมนูเลือก board -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">{{ __('personnel.title') }}</h1>

            <!-- เมนูเลือก board -->
            <div class="bg-white rounded-lg shadow-sm p-2">
                <nav class="flex flex-wrap gap-2">
                    @foreach ($boards as $navBoard)
                        <a href="{{ route('personnel.index', ['board_id' => $navBoard->id]) }}"
                            class="px-4 py-2 text-sm font-medium rounded-md {{ request()->get('board_id') == $navBoard->id || (!request()->has('board_id') && $loop->first) ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                            {{ $navBoard->board_name }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        <!-- แสดงข้อมูลบุคลากรตามหน่วยงานในรูปแบบแผนผังองค์กร -->
        @php
            // ตรวจสอบว่ามีการระบุ board_id มาหรือไม่
            $selectedBoardId = request()->get('board_id');

            // ถ้าไม่มีการระบุ board_id ให้เลือก board แรกที่มี display_order = 0
            if (!$selectedBoardId) {
                $defaultBoard = $boards->first();
                $selectedBoardId = $defaultBoard ? $defaultBoard->id : null;
            }

            $displayBoards = $selectedBoardId ? $boards->where('id', $selectedBoardId) : collect([]);
        @endphp

        @foreach ($displayBoards as $board)
            <div class="org-chart">
                <div class="org-chart-header">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $board->board_name }}</h2>

                    @php
                        // หาวันที่อัปเดตล่าสุดของบุคลากรในบอร์ดนี้
                        $lastUpdated = $board->personnel->max('updated_at');
                    @endphp

                    @if ($lastUpdated)
                        <div class="text-sm text-gray-500 mb-4">
                            {{ __('personnel.last_updated') }}: <span class="last-updated-date"
                                data-timestamp="{{ $lastUpdated->toISOString() }}">{{ $lastUpdated->format('d M Y') }}</span>
                        </div>
                    @endif
                </div>

                @php
                    // กรองเฉพาะบุคลากรที่กำลังใช้งาน
                    $activePersonnel = $board->personnel->where('is_active', true);

                    // ป้องกันกรณีไม่มีบุคลากร
                    if ($activePersonnel->isEmpty()) {
                        $hasLeader = false;
                        $reportGroups = collect([]);
                    } else {
                        // จัดกลุ่มตาม display_order
                        $groupedPersonnel = $activePersonnel->groupBy('display_order');

                        // เรียงลำดับตาม display_order ก่อน
                        $sortedGroups = $groupedPersonnel->sortKeys();

                        // ดึงกลุ่มแรกออกมา (มีค่า display_order น้อยที่สุด) สำหรับใช้เป็น leader
                        $leaderGroup = $sortedGroups->first();

                        if ($leaderGroup) {
                            // เรียงลำดับภายในกลุ่ม leader ตาม created_at
                            $sortedLeaderGroup = $leaderGroup->sortBy('created_at');
                            $leader = $sortedLeaderGroup->first();

                            // ลบ leader group ออกจาก sorted groups
                            $reportGroups = $sortedGroups->slice(1);
                        } else {
                            $sortedLeaderGroup = collect([]);
                            $leader = null;
                            $reportGroups = collect([]);
                        }

                        // ตรวจสอบว่ามี leader หรือไม่
                        $hasLeader = $leader !== null;
                    }
                @endphp

                @if ($hasLeader)
                    <div class="org-chart-leader">
                        <div class="org-chart-leader-img-wrapper">
                            @if ($leader->image)
                                <img src="{{ asset('storage/' . $leader->image) }}" alt="{{ $leader->full_name }}"
                                    class="org-chart-leader-img">
                            @else
                                <div class="org-chart-leader-img bg-gray-100 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="org-chart-leader-name">{{ $leader->full_name }}</div>
                        <div class="org-chart-leader-title">{{ $leader->position }}</div>
                        @if ($leader->order_title)
                            <div class="org-chart-order-title">{{ $leader->order_title }}</div>
                        @endif
                    </div>

                    @if (isset($sortedLeaderGroup) && $sortedLeaderGroup->count() > 1)
                        <div class="org-chart-connector"></div>
                        <div class="org-chart-reports-container">
                            <div class="org-chart-reports-title">{{ $leader->order_title ?? __('personnel.colleagues') }}
                            </div>
                            <div class="org-chart-reports">
                                @foreach ($sortedLeaderGroup->slice(1) as $person)
                                    <a href="{{ route('personnel.show', $person->id) }}" class="org-chart-person">
                                        <div class="org-chart-person-img-wrapper">
                                            @if ($person->image)
                                                <img src="{{ asset('storage/' . $person->image) }}"
                                                    alt="{{ $person->full_name }}" class="org-chart-person-img">
                                            @else
                                                <div class="org-chart-person-placeholder">
                                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                            clip-rule="evenodd">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="reports-indicator">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="org-chart-person-name">{{ $person->full_name }}</div>
                                        <div class="org-chart-person-title">{{ $person->position }}</div>
                                        @if ($person->order_title)
                                            <div class="org-chart-order-title">{{ $person->order_title }}</div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif

                @if ($reportGroups->count() > 0)
                    @if ($hasLeader)
                        <div class="org-chart-connector"></div>
                    @endif

                    @foreach ($reportGroups as $displayOrder => $group)
                        @php
                            // ตรวจสอบว่ากลุ่มไม่เป็น null
                            if ($group) {
                                // เรียงลำดับภายในกลุ่มตาม created_at
                                $sortedGroup = $group->sortBy('created_at');

                                // ตรวจสอบว่ามี order_title หรือไม่ (ให้ใช้ของคนแรกในกลุ่ม)
                                $firstPerson = $sortedGroup->first();
                                if ($firstPerson) {
                                    $groupTitle =
                                        $firstPerson->order_title ?? __('personnel.level') . ' ' . ($displayOrder + 1);
                                } else {
                                    $groupTitle = __('personnel.level') . ' ' . ($displayOrder + 1);
                                    $sortedGroup = collect([]);
                                }
                            } else {
                                $sortedGroup = collect([]);
                                $groupTitle = __('personnel.level') . ' ' . ($displayOrder + 1);
                            }
                        @endphp

                        <div class="org-chart-reports-container">
                            <div class="org-chart-reports-title">{{ $groupTitle }}</div>
                            <div class="org-chart-reports">
                                @foreach ($sortedGroup as $person)
                                    <a href="{{ route('personnel.show', $person->id) }}" class="org-chart-person">
                                        <div class="org-chart-person-img-wrapper">
                                            @if ($person->image)
                                                <img src="{{ asset('storage/' . $person->image) }}"
                                                    alt="{{ $person->full_name }}" class="org-chart-person-img">
                                            @else
                                                <div class="org-chart-person-placeholder">
                                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                            clip-rule="evenodd">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="reports-indicator">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="org-chart-person-name">{{ $person->full_name }}</div>
                                        <div class="org-chart-person-title">{{ $person->position }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
    </div>
    @endforeach
    </div>
@endsection

@section('script-app')
    <script>

        // จัดรูปแบบวันที่ด้วย moment.js
        document.addEventListener('DOMContentLoaded', function() {
            const dateElements = document.querySelectorAll('.last-updated-date');

            dateElements.forEach(function(element) {
                const timestamp = element.getAttribute('data-timestamp');
                if (timestamp) {
                    element.textContent = moment(timestamp).format('D MMM YYYY');
                }
            });
        });
    </script>
@endsection
