@extends('admin.layouts.master')
@section('title')
    DashBoard
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6 mt-3 mb-3">
            <h3 class="text-center">Danh mục và số lượng bài viết</h3>
            <!-- Container cho biểu đồ -->
            <canvas id="myChart"></canvas>
        </div>
        <div class="col-md-6 mt-3 mb-3">
            <h3 class="text-center">Top 5 Bài Viết Nhiều Lượt Xem Nhất Trong Tháng {{ now()->month }}</h3>
            <canvas id="chartOf5Viewest"></canvas>
        </div>
    </div>
@endsection
@push('script')
    <script>
        // Lấy dữ liệu từ Blade (Laravel)
        var labels = @json($labels); // Tên các danh mục
        var data = @json($data); // Số lượng bài viết trong từng danh mục

        // Dữ liệu biểu đồ cho Chart.js
        var chartData = {
            labels: labels, // Tên danh mục trên trục X
            datasets: [{
                label: 'Số lượng bài viết',
                data: data, // Dữ liệu số lượng bài viết
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Màu nền cho các cột
                borderColor: 'rgba(54, 162, 235, 1)', // Màu viền cho các cột
                borderWidth: 1
            }]
        };

        // Tùy chỉnh biểu đồ
        var options = {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true // Đảm bảo trục Y bắt đầu từ 0
                }
            }
        };

        // Khởi tạo biểu đồ
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // Kiểu biểu đồ (bar chart)
            data: chartData, // Dữ liệu biểu đồ
            options: options // Tùy chỉnh biểu đồ
        });


        // Lấy dữ liệu từ `top5ArticleViewest` (dữ liệu bài viết nhiều lượt xem nhất)
        var top5 = @json($top5ArticleViewest); // Dữ liệu top 5 bài viết

        console.log(top5)

        // Tạo mảng labels và data từ top5
        var top5Labels = top5.map(function(item) {
            return item.title.length > 30 ? item.title.substring(0, 10) + '...' : item.title;
        });
        var top5Data = top5.map(function(item) {
            return item.views_count;
        });

        // Dữ liệu biểu đồ cho Top 5 bài viết nhiều lượt xem nhất
        var top5ChartData = {
            labels: top5Labels, // Tên bài viết trên trục X
            datasets: [{
                label: 'Lượt xem',
                data: top5Data, // Dữ liệu số lượt xem
                backgroundColor: 'rgba(255, 99, 132, 0.2)', // Màu nền cho các cột
                borderColor: 'rgba(255, 99, 132, 1)', // Màu viền cho các cột
                borderWidth: 1
            }]
        };

        // Tùy chỉnh biểu đồ cho Top 5 bài viết
        var top5Options = {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true // Đảm bảo trục Y bắt đầu từ 0
                }
            }
        };

        // Khởi tạo biểu đồ cho Top 5 bài viết
        var ctxTop5 = document.getElementById('chartOf5Viewest').getContext('2d');
        var top5Chart = new Chart(ctxTop5, {
            type: 'line',
            data: top5ChartData, // Dữ liệu biểu đồ
            options: top5Options // Tùy chỉnh biểu đồ
        });
    </script>
@endpush
