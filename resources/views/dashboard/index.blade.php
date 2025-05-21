@extends('layout.master-new')
@section('title', __('translation.visitor_statistics'))

@section('css')
    <!-- เพิ่ม CSS เพิ่มเติมตามต้องการ -->
    <style>
        .stats-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 15px;
        }

        .stats-number {
            font-size: 28px;
            font-weight: 600;
        }

        .stats-label {
            font-size: 14px;
            opacity: 0.7;
        }

        /* Date Range Filter Styles */
        .date-range-filter {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .date-range-filter .input-group {
            width: 180px;
        }

        @media (max-width: 768px) {
            .date-range-container {
                flex-direction: column;
                align-items: stretch;
            }

            .date-range-filter {
                margin-top: 10px;
            }

            .date-range-filter .input-group {
                width: 100%;
            }
        }
    </style>
    <!-- flatpickr css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datepikar/flatpickr.min.css') }}">
@endsection

@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12">
                <h4 class="main-title">@lang('translation.visitor_statistics')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="{{ route('dashboard.index') }}" class="f-s-14 f-w-500">
                            <span>
                                @lang('translation.dashboard')
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                @lang('translation.visitor_statistics')
                            </span>
                        </a>
                    </li>
                </ul>

                <!-- สถิติการเข้าชมแบบ Card -->
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card stats-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon bg-primary text-white">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <div class="stats-number" id="active-visitors">{{ $activeVisitors }}</div>
                                    <div class="stats-label">@lang('translation.active_visitors')</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card stats-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon bg-success text-white">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div>
                                    <div class="stats-number">{{ $todayVisitors }}</div>
                                    <div class="stats-label">@lang('translation.today_visitors')</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card stats-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon bg-info text-white">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <div>
                                    <div class="stats-number">{{ $totalVisitors }}</div>
                                    <div class="stats-label">@lang('translation.total_visitors')</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card stats-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="stats-icon bg-warning text-white">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div>
                                    <div class="stats-number">{{ $totalPageViews }}</div>
                                    <div class="stats-label">@lang('translation.total_page_views')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- กราฟแสดงจำนวนผู้เข้าชมย้อนหลัง 30 วัน -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap justify-content-between align-items-center date-range-container">
                            <p class="mb-2 mb-md-0">@lang('translation.visitors_trend') | <span id="displayed-start-date"></span> - <span
                                    id="displayed-end-date"></span></p>
                            <div class="date-range-filter">
                                <div>
                                    <input type="text" class="form-control basic-date" id="start_date_picker"
                                        name="start_date" placeholder="@lang('translation.start_date')">
                                </div>
                                <div>
                                    <input type="text" class="form-control basic-date" id="end_date_picker"
                                        name="end_date" placeholder="@lang('translation.end_date')">
                                </div>
                                <button type="button" id="filter-btn" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> @lang('translation.filter')
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="visitors-chart"></div>
                    </div>
                </div>

                <!-- รายการหน้าที่มีคนเข้าชมมากที่สุด -->
                <div class="card mt-4">
                    <div class="card-header">
                        <p>@lang('translation.most_visited_pages')</p>
                    </div>
                    <div class="card-body">
                        @if (count($mostVisitedPages) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>@lang('translation.page')</th>
                                            <th>@lang('translation.visits')</th>
                                            <th>@lang('translation.percentage')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalVisits = array_sum(array_column($mostVisitedPages, 'visits'));
                                        @endphp
                                        @foreach ($mostVisitedPages as $page)
                                            <tr>
                                                <td>{{ $page['page'] ?? 'Homepage' }}</td>
                                                <td>{{ $page['visits'] }}</td>
                                                <td>
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $totalVisits > 0 ? ($page['visits'] / $totalVisits) * 100 : 0 }}%">
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="small">{{ $totalVisits > 0 ? number_format(($page['visits'] / $totalVisits) * 100, 1) : 0 }}%</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                @lang('translation.no_page_visits_data')
                            </div>
                        @endif
                    </div>
                </div>
                <!-- เพิ่มหลังจากส่วนแสดงหน้าที่เข้าชมมากที่สุด -->
                <div class="card mt-4">
                    <div class="card-header">
                        <p>@lang('translation.visitor_regions')</p>
                    </div>
                    <div class="card-body">
                        @if (count($topRegions) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>@lang('translation.region')</th>
                                            <th>@lang('translation.visitors')</th>
                                            <th>@lang('translation.percentage')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalRegionVisits = array_sum(array_column($topRegions, 'count'));
                                        @endphp
                                        @foreach ($topRegions as $region)
                                            <tr>
                                                <td>{{ $region['region'] }}</td>
                                                <td>{{ $region['count'] }}</td>
                                                <td>
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $totalRegionVisits > 0 ? ($region['count'] / $totalRegionVisits) * 100 : 0 }}%">
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="small">{{ $totalRegionVisits > 0 ? number_format(($region['count'] / $totalRegionVisits) * 100, 1) : 0 }}%</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                @lang('translation.no_region_data')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb end -->
    </div>
@endsection

@section('script')
    <!-- apexcharts-->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <!-- flatpickr js-->
    <script src="{{ asset('assets/vendor/datepikar/flatpickr.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set the current app language
            @php
                $lang = session()->get('lang') == null ? 'th' : session()->get('lang');
            @endphp
            const currentLang = '{{ $lang }}' || document.documentElement.lang || 'th';
            moment.locale(currentLang); // Set Moment.js locale based on current page language

            // Configure dates for the chart (last 30 days)
            const endDate = moment(); // Current date
            const startDate = moment().subtract(29, 'days'); // 30 days ago (including today)

            // Display date range in the correct format based on language
            document.getElementById("displayed-end-date").innerText = endDate.format('LL');
            document.getElementById("displayed-start-date").innerText = startDate.format('LL');

            // Initialize Flatpickr with proper language
            const config = {
                enableTime: false,
                dateFormat: "Y-m-d",
                locale: currentLang,
                altInput: true,
                altFormat: currentLang === 'th' ? "j F Y" : "j F Y",
            };

            const today = moment().format('YYYY-MM-DD');

            // Initialize date pickers with default date range (30 days)
            const startDatePicker = flatpickr("#start_date_picker", {
                ...config,
                defaultDate: startDate.format('YYYY-MM-DD'),
                maxDate: today,
                onChange: function(selectedDates, dateStr) {
                    // Update end date picker's minDate when start date changes
                    endDatePicker.set('minDate', dateStr);
                }
            });

            const endDatePicker = flatpickr("#end_date_picker", {
                ...config,
                defaultDate: endDate.format('YYYY-MM-DD'),
                maxDate: today
            });

            // Filter button event listener
            document.getElementById('filter-btn').addEventListener('click', function() {
                const selectedStartDate = document.getElementById('start_date_picker').value;
                const selectedEndDate = document.getElementById('end_date_picker').value;

                if (!selectedStartDate || !selectedEndDate) {
                    // Show error message if dates are not selected
                    const errorMessage = currentLang === 'th' ?
                        'กรุณาเลือกช่วงวันที่' :
                        'Please select a date range';

                    alert(errorMessage);
                    return;
                }

                // Validate date range
                const start = moment(selectedStartDate);
                const end = moment(selectedEndDate);

                if (end.isBefore(start)) {
                    const errorMessage = currentLang === 'th' ?
                        'วันที่สิ้นสุดต้องมากกว่าวันที่เริ่มต้น' :
                        'End date must be after start date';

                    alert(errorMessage);
                    return;
                }

                // Fetch data for the selected date range
                fetchVisitorData(selectedStartDate, selectedEndDate);
            });

            // Function to fetch visitor data with date range
            function fetchVisitorData(startDate, endDate) {
                const url =
                    `{{ url('/admin/api/visitors/daily-stats') }}?start_date=${startDate}&end_date=${endDate}`;

                // Show loading indicator
                document.getElementById('visitors-chart').innerHTML =
                    `<div class="d-flex justify-content-center p-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            // Display error message
                            document.getElementById('visitors-chart').innerHTML =
                                `<div class="alert alert-danger text-center p-5">${data.error}</div>`;
                            return;
                        }

                        if (data.visitors && data.visitors.length > 0) {
                            // Update date range display based on actual data
                            if (data.start_date && data.end_date) {
                                const startMoment = moment(data.start_date);
                                const endMoment = moment(data.end_date);

                                // Ensure proper locale is set for the dates
                                startMoment.locale(currentLang);
                                endMoment.locale(currentLang);

                                document.getElementById("displayed-start-date").innerText = startMoment.format(
                                    'LL');
                                document.getElementById("displayed-end-date").innerText = endMoment.format(
                                'LL');
                            }

                            // Use categories from API
                            let chartCategories = data.categories || [];

                            // Render chart with the data
                            renderChart(data.visitors, chartCategories);
                        } else {
                            // No data available message
                            const noDataMessage = currentLang === 'th' ?
                                'ไม่มีข้อมูลการเข้าชมในช่วงเวลานี้' :
                                'No visitor data available for this period';

                            document.getElementById('visitors-chart').innerHTML =
                                `<div class="alert alert-info text-center p-5">${noDataMessage}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching visitor data:', error);

                        const errorMessage = currentLang === 'th' ?
                            'ไม่สามารถโหลดข้อมูลได้' :
                            'Unable to load data';

                        document.getElementById('visitors-chart').innerHTML =
                            `<div class="alert alert-danger text-center p-5">${errorMessage}</div>`;
                    });
            }

            // Initial data load (last 30 days)
            fetchVisitorData(startDate.format('YYYY-MM-DD'), endDate.format('YYYY-MM-DD'));

            function renderChart(visitorData, categoriesData) {
                // Check if we have data
                if (!visitorData || visitorData.length === 0 || visitorData.every(item => item === 0)) {
                    const noDataMessage = currentLang === 'th' ?
                        'ไม่มีข้อมูลการเข้าชมในช่วงเวลานี้' :
                        'No visitor data available for this period';

                    document.getElementById('visitors-chart').innerHTML =
                        `<div class="alert alert-info text-center p-5">${noDataMessage}</div>`;
                    return;
                }

                // Clear previous chart instance
                document.getElementById('visitors-chart').innerHTML = '';

                // Get translated visitor label or default
                const visitorLabel = document.querySelector('[data-visitors-translation]')?.getAttribute(
                        'data-visitors-translation') ||
                    (currentLang === 'th' ? "ผู้เข้าชม" : "Visitors");

                var options = {
                    series: [{
                        name: visitorLabel,
                        data: visitorData
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: true
                        }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    grid: {
                        borderColor: '#e0e0e0',
                        row: {
                            colors: ['#f3f3f3', 'transparent'],
                            opacity: 0.5
                        },
                    },
                    markers: {
                        size: 5,
                        hover: {
                            size: 7
                        }
                    },
                    title: {
                        text: '',
                        align: 'left'
                    },
                    colors: [getLocalStorageItem('color-primary', '#7752FE')],
                    xaxis: {
                        categories: categoriesData,
                        labels: {
                            rotate: -45,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: visitorLabel
                        },
                        min: 0
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " " + visitorLabel;
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#visitors-chart"), options);
                chart.render();
            }

            // Update active visitors count every 30 seconds
            setInterval(function() {
                fetch('{{ url('/admin/api/visitors/stats') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('active-visitors').textContent = data.activeVisitors;
                    });
            }, 30000);
        });

        // Helper function to get color from local storage or use default
        function getLocalStorageItem(key, defaultValue) {
            const value = localStorage.getItem(key);
            return value !== null ? value : defaultValue;
        }
    </script>
@endsection
