@extends('layout.admin_layout')


@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Today Sale -->
        <div class="col-sm-6 col-xl-4">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Today Sale</p>
                    <h6 class="mb-0">${{ $todaySales }}</h6>
                </div>
            </div>
        </div>
        <!-- Total Sale -->
        <div class="col-sm-6 col-xl-4">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Sale</p>
                    <h6 class="mb-0">${{ $totalSales }}</h6>
                </div>
            </div>
        </div>
        <!-- Today Revenue -->
        <div class="col-sm-6 col-xl-4">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Today Revenue</p>
                    <h6 class="mb-0">${{ $todaySales }}</h6> <!-- Today's total_price as revenue -->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Worldwide Sales</h6>
                    <a href="">Show All</a>
                </div>
                <canvas id="worldwide-sales"></canvas>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Salse & Revenue</h6>
                                <a href="">Show All</a>
                            </div>
                            <canvas id="salse-revenue"></canvas>
                        </div>
                    </div>
    </div>
</div>
<!-- Sales Chart End -->

<script>
    var ctx1 = document.getElementById('worldwide-sales').getContext('2d');
    var worldwideSalesChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: @json($salesDates), // Pass sales dates
            datasets: [{
                label: 'Sales Amount',
                data: @json($salesTotals), // Pass total sales data
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return '$' + tooltipItem.raw.toFixed(2); // Format as currency
                        }
                    }
                }
            }
        }
    });

    var ctx2 = document.getElementById('sales-revenue').getContext('2d');
    var salesRevenueChart = new Chart(ctx2, {
        type: 'bar', // Change chart type if needed
        data: {
            labels: @json($salesDates), // Pass sales dates
            datasets: [{
                label: 'Sales Revenue',
                data: @json($salesTotals), // Pass total sales data
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return '$' + tooltipItem.raw.toFixed(2); // Format as currency
                        }
                    }
                }
            }
        }
    });
</script>

@endsection