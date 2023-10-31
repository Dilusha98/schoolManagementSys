@php
    use Illuminate\Support\Facades\DB;
@endphp
@php
    $name = session()->get('name');
    // $data = DB::table('userregistation')->get();
    $data = session()->get('user');
    $dataarray = json_decode($data, true);
@endphp
@if ($name != 'admin')
    @php
        header('Location: ' . URL::to('/'), true, 302);
        exit();
    @endphp
@endif

@extends('layout')

@section('title')
    Admin Dashboard
@endsection

@section('content')
    <h1>Admin</h1>
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <input type="radio" id="semOne" name="semSelect" value="1" checked class="chart-input">
                <label for="semOne">Semester One</label>
                <input type="radio" id="semTwo" name="semSelect" value="2" class="chart-input">
                <label for="semTwo">Semester Two</label>
                <input type="radio" id="semThree" name="semSelect" value="3" class="chart-input">
                <label for="semThree">Semester Three</label>
            </div>
            <div class="col-md-6">
                <label for="selectGrade">Select Grade</label>
                <select name="selectGrade" id="selectGrade" class="form-select chart-input">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8" selected>8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                </select>
            </div>
        </div>
    </div>
    {{-- Bar chart --}}
    <div id="chart-container" style="position: relative;">
        <div id="no-data-message"
            style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
            No data available
        </div>
        <canvas id="barChart"></canvas>
    </div>
        {{-- Pie Chart --}}
        <div>
            <canvas id="pieChartCanvas"></canvas>
        </div>
        {{-- line chart --}}
    <div>
        <div class="row">
            <div class="col-md-6">
                <label for="selectGradeInLineChart">Select Grade</label>
                <select name="selectGrade" id="selectGradeInLineChart" class="form-select">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8" selected>8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                </select>
            </div>
        </div>
        <canvas id="marksLineChart" width="400" height="200"></canvas>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            marksbarchart();

            function marksbarchart() {
                var marksData = <?php echo json_encode($marks); ?>;
                var subjectNames = marksData.map(function(item) {
                    return item.subjectName;
                });
                var AverageMarks = marksData.map(function(item) {
                    return item.AverageMarks;
                });

                if (AverageMarks.length > 0) {

                    var ctx = document.getElementById('barChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: subjectNames,
                            datasets: [{
                                label: 'Average Marks',
                                data: AverageMarks,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                } else {
                    $('#no-data-message').show();
                    chartContainer.find('canvas').hide();
                }
            }

            $('.chart-input').change(function(e) {
                e.preventDefault();
                let sem = $('input[name="semSelect"]:checked').val();
                var grade = $('#selectGrade').val();

                $.ajax({
                    type: "get",
                    url: "/getAvgBarChartAdminSide/" + sem + '/' + grade,
                    success: function(res) {

                        var subjectNames = res.map(function(item) {
                            return item.subjectName;
                        });
                        var AverageMarks = res.map(function(item) {
                            return item.AverageMarks;
                        });

                        var chartContainer = $('#chart-container');

                        if (AverageMarks.length > 0) {

                            $('#no-data-message').hide();
                            var ctx = $('#barChart');

                            if (Chart.getChart(ctx)) {
                                Chart.getChart(ctx).destroy();
                            }

                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: subjectNames,
                                    datasets: [{
                                        label: 'Average Marks',
                                        data: AverageMarks,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        } else {
                            $('#no-data-message').show();
                            chartContainer.find('canvas').hide();
                        }
                    }
                });
                getAvgCountPieChart(sem,grade);
            });

            // line chart
            marksLineChart();

            function marksLineChart() {
                var currentYearData = @json($marks);
                var previousYearData = @json($previousYearMarks);

                var allSubjectNames = currentYearData.map(data => data.subjectName);

                allSubjectNames.forEach(subjectName => {
                    if (!currentYearData.some(data => data.subjectName === subjectName)) {
                        currentYearData.push({
                            subjectName: subjectName,
                            AverageMarks: 0
                        });
                    }
                    if (!previousYearData.some(data => data.subjectName === subjectName)) {
                        previousYearData.push({
                            subjectName: subjectName,
                            AverageMarks: 0
                        });
                    }
                });

                const ctx = document.getElementById('marksLineChart').getContext('2d');

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: currentYearData.map(data => data.subjectName),
                        datasets: [{
                                label: 'Current Year',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                data: currentYearData.map(data => data.AverageMarks),
                            },
                            {
                                label: 'Previous Year',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                data: previousYearData.map(data => data.AverageMarks),
                            }
                        ],
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Average Marks',
                                },
                            },
                        },
                    },
                });
            }

            $(document).on('change', '#selectGradeInLineChart', function(e) {
                e.preventDefault();

                var grade = $(this).val();

                $.ajax({
                    type: "get",
                    url: "/viewlinechanrt/" + grade,
                    success: function(res) {

                        var currentYearData = res.currentYearData;
                        var previousYearData = res.previousYearData;

                        var allSubjectNames = currentYearData.map(data => data.subjectName);

                        allSubjectNames.forEach(subjectName => {
                            if (!currentYearData.some(data => data.subjectName ===
                                    subjectName)) {
                                currentYearData.push({
                                    subjectName: subjectName,
                                    AverageMarks: 0
                                });
                            }
                            if (!previousYearData.some(data => data.subjectName ===
                                    subjectName)) {
                                previousYearData.push({
                                    subjectName: subjectName,
                                    AverageMarks: 0
                                });
                            }
                        });

                        // const ctx = document.getElementById('marksLineChart').getContext('2d');

                        var ctx = $('#marksLineChart');

                        if (Chart.getChart(ctx)) {
                            Chart.getChart(ctx).destroy();
                        }

                        const chart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: currentYearData.map(data => data.subjectName),
                                datasets: [{
                                        label: 'Current Year',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        data: currentYearData.map(data => data
                                            .AverageMarks),
                                    },
                                    {
                                        label: 'Previous Year',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        data: previousYearData.map(data => data
                                            .AverageMarks),
                                    }
                                ],
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Average Marks',
                                        },
                                    },
                                },
                            },
                        });


                    }
                });

            });

            // pie chart
            rangePieChart();

            function rangePieChart() {
                var counts = <?php echo json_encode($counts); ?>;

                var labels = Object.keys(counts);
                var data = Object.values(counts);

                var ctx = document.getElementById('pieChartCanvas').getContext('2d');

                var pieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: [
                                'red',
                                'orange',
                                'yellow',
                                'green',
                                'blue',
                                'purple'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        title: {
                            display: true,
                            text: 'Student Score Distribution'
                        },
                        legend: {
                            display: true,
                            position: 'right',
                            onClick: null
                        }
                    }
                });

                if (labels.length === 0) {
                    var noDataMessage = "No data available.";
                    ctx.fillText(noDataMessage, ctx.canvas.width / 2 - 50, ctx.canvas.height / 2);
                }

            }

            function getAvgCountPieChart(semester,grade) {

                $.ajax({
                    type: "get",
                    url: "/getAvgCountPieChartAdminSide/" + grade + '/' + semester,
                    success: function(res) {
                        var counts = res;
                        var labels = Object.keys(counts);
                        var data = Object.values(counts);

                        var canvas = document.getElementById('pieChartCanvas');

                        var ctx = $('#pieChartCanvas');

                        if (Chart.getChart(ctx)) {
                            Chart.getChart(ctx).destroy();
                        }

                        var ctx = canvas.getContext('2d');

                        canvas.chart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: data,
                                    backgroundColor: [
                                        'red',
                                        'orange',
                                        'yellow',
                                        'green',
                                        'blue',
                                        'purple'
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                title: {
                                    display: true,
                                    text: 'Student Score Distribution'
                                },
                                legend: {
                                    display: true,
                                    position: 'right',
                                    onClick: null
                                }
                            }
                        });

                        if (labels.length === 0) {
                            var noDataMessage = "No data available.";
                            ctx.fillText(noDataMessage, ctx.canvas.width / 2 - 50, ctx.canvas.height /
                                2);
                        }
                    }
                });
            }

        });
    </script>
@endsection
