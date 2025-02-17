@extends('layout.master-new')
@section('title', 'Dashboard')

@section('css')

@endsection
@section('main-content')
    <div class="container-fluid">
        <!-- Breadcrumb start -->
        <div class="row m-1">
            <div class="col-12 ">
                <h4 class="main-title">@lang('translation.home')</h4>
                <ul class="app-line-breadcrumbs mb-3">
                    <li class="">
                        <a href="#" class="f-s-14 f-w-500">
                            <span>
                                @lang('translation.dashboard')
                            </span>
                        </a>
                    </li>
                </ul>
                <div class="card">
                    <div class="card-header">
                        <p>จำนวนเข้าดูเว็บไซต์ | <span id="end-date"></span> - <span id="start-date"></span></p>
                    </div>
                    <div class="card-body">
                        <div id="line1"></div>
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
    <script>
        const startDate = moment();
        const endDate = moment().subtract(30, 'days');

        document.getElementById("start-date").innerText = startDate.format('LL');
        document.getElementById("end-date").innerText = endDate.format('LL');


        // Generate date categories from endDate to startDate
        const categories = [];
        let currentDate = endDate.clone();
        while (currentDate.isSameOrBefore(startDate, 'day')) {
            categories.push(currentDate.format('MMM D')); // Format as "Jan 1", "Jan 2", etc.
            currentDate.add(1, 'day');
        }

        var options = {
            series: [{
                name: "Count",
                data: Array(categories.length).fill().map(() => Math.floor(Math.random() * 100))
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: '',
                align: 'left'
            },

            colors: [getLocalStorageItem('color-primary', '#7752FE'), '#78738C', '#26C450', '#E65051', '#F09E3C'],

            xaxis: {
                categories: categories,
            }
        };

        var chart = new ApexCharts(document.querySelector("#line1"), options);
        chart.render();
    </script>
@endsection
