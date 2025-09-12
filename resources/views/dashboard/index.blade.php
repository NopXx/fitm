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
                                    <div class="stats-number" id="active-visitors">0</div>
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
                                    <div class="stats-number" id="today-visitors">0</div>
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
                                    <div class="stats-number" id="total-visitors">0</div>
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
                                    <div class="stats-number" id="total-page-views">0</div>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('translation.page')</th>
                                        <th>@lang('translation.visits')</th>
                                        <th>@lang('translation.percentage')</th>
                                    </tr>
                                </thead>
                                <tbody id="most-visited-body">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">@lang('common.loading')</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- เพิ่มหลังจากส่วนแสดงหน้าที่เข้าชมมากที่สุด -->
                <div class="card mt-4">
                    <div class="card-header">
                        <p>@lang('translation.visitor_regions')</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('translation.region')</th>
                                        <th>@lang('translation.visitors')</th>
                                        <th>@lang('translation.percentage')</th>
                                    </tr>
                                </thead>
                                <tbody id="region-stats-body">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">@lang('common.loading')</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
            const earliest = moment().subtract(60, 'days').format('YYYY-MM-DD');

            // Initialize date pickers with default date range (30 days) and enforce max 60-day window
            const startDatePicker = flatpickr("#start_date_picker", {
                ...config,
                defaultDate: startDate.format('YYYY-MM-DD'),
                maxDate: today,
                minDate: earliest,
                onChange: function(selectedDates, dateStr) {
                    // Update end date picker's minDate when start date changes
                    endDatePicker.set('minDate', dateStr);
                    // Limit end date to within 60 days from start (inclusive)
                    const maxEnd = moment(dateStr).add(60, 'days');
                    const maxEndStr = moment.min(maxEnd, moment(today)).format('YYYY-MM-DD');
                    endDatePicker.set('maxDate', maxEndStr);
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

                // Enforce maximum 60-day window
                const diffDays = end.diff(start, 'days');
                if (diffDays > 60) {
                    const msg = currentLang === 'th'
                        ? 'เลือกช่วงวันที่ได้ไม่เกิน 60 วัน'
                        : 'Please select a range of 60 days or less';
                    alert(msg);
                    return;
                }

                // Enforce lookback limit: start date not earlier than today-60 days
                const earliestMoment = moment().subtract(60, 'days').startOf('day');
                if (start.isBefore(earliestMoment)) {
                    const msg = currentLang === 'th'
                        ? 'สามารถดูย้อนหลังได้ไม่เกิน 60 วันนับจากวันนี้'
                        : 'You can only look back up to 60 days from today';
                    alert(msg);
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

                            // Also update tables to the same range
                            fetchMostVisitedPages(startDate, endDate);
                            fetchRegionStats(startDate, endDate);
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

            // Fetch summary stats (active, today, totals)
            function fetchSummaryStats() {
                fetch(`{{ url('/admin/api/visitors/stats') }}`)
                    .then(r => r.json())
                    .then(d => {
                        document.getElementById('active-visitors').textContent = d.activeVisitors ?? 0;
                        document.getElementById('today-visitors').textContent = d.todayVisitors ?? 0;
                        document.getElementById('total-visitors').textContent = d.totalVisitors ?? 0;
                        document.getElementById('total-page-views').textContent = d.totalPageViews ?? 0;
                    })
                    .catch(() => {
                        // keep defaults on error
                    });
            }

            // Fetch most visited pages
            function fetchMostVisitedPages(startDate = null, endDate = null) {
                const tbody = document.getElementById('most-visited-body');
                const qp = (startDate && endDate) ? `?start_date=${startDate}&end_date=${endDate}` : '';
                fetch(`{{ url('/admin/api/visitors/most-visited') }}${qp}`)
                    .then(r => r.json())
                    .then(d => {
                        const items = d.mostVisitedPages || [];
                        if (!items.length) {
                            tbody.innerHTML = `<tr><td colspan="3" class="text-center text-muted">@lang('translation.no_page_visits_data')</td></tr>`;
                            return;
                        }

                        const total = items.reduce((sum, it) => sum + (it.visits || 0), 0);
                        tbody.innerHTML = items.map(it => {
                            const percent = total > 0 ? ((it.visits || 0) / total) * 100 : 0;
                            const label = it.page || 'Homepage';
                            return `
                                <tr>
                                    <td>${label}</td>
                                    <td>${it.visits || 0}</td>
                                    <td>
                                        <div class=\"progress\" style=\"height: 6px;\">\n                                            <div class=\"progress-bar\" role=\"progressbar\" style=\"width: ${percent.toFixed(1)}%\"></div>\n                                        </div>
                                        <span class=\"small\">${percent.toFixed(1)}%</span>
                                    </td>
                                </tr>
                            `;
                        }).join('');
                    })
                    .catch(() => {
                        tbody.innerHTML = `<tr><td colspan=\"3\" class=\"text-center text-danger\">@lang('translation.error')</td></tr>`;
                    });
            }

            // Fetch top regions
            function fetchRegionStats(startDate = null, endDate = null) {
                const tbody = document.getElementById('region-stats-body');
                const qp = (startDate && endDate) ? `?start_date=${startDate}&end_date=${endDate}` : '';
                fetch(`{{ route('api.visitors.region-stats') }}${qp}`)
                    .then(r => r.json())
                    .then(d => {
                        const items = d.topRegions || [];
                        if (!items.length) {
                            tbody.innerHTML = `<tr><td colspan=\"3\" class=\"text-center text-muted\">@lang('translation.no_region_data')</td></tr>`;
                            return;
                        }
                        const total = items.reduce((sum, it) => sum + (it.count || 0), 0);
                        tbody.innerHTML = items.map(it => {
                            const percent = total > 0 ? ((it.count || 0) / total) * 100 : 0;
                            return `
                                <tr>
                                    <td>${it.region}</td>
                                    <td>${it.count || 0}</td>
                                    <td>
                                        <div class=\"progress\" style=\"height: 6px;\">\n                                            <div class=\"progress-bar\" role=\"progressbar\" style=\"width: ${percent.toFixed(1)}%\"></div>\n                                        </div>
                                        <span class=\"small\">${percent.toFixed(1)}%</span>
                                    </td>
                                </tr>
                            `;
                        }).join('');
                    })
                    .catch(() => {
                        tbody.innerHTML = `<tr><td colspan=\"3\" class=\"text-center text-danger\">@lang('translation.error')</td></tr>`;
                    });
            }

            // Initial fetches for stats and tables
            fetchSummaryStats();
            // For initial load, align tables to the initial chart range
            fetchMostVisitedPages(startDate.format('YYYY-MM-DD'), endDate.format('YYYY-MM-DD'));
            fetchRegionStats(startDate.format('YYYY-MM-DD'), endDate.format('YYYY-MM-DD'));

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
                        document.getElementById('active-visitors').textContent = data.activeVisitors ?? 0;
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
