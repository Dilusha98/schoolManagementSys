@php
    use Illuminate\Support\Facades\DB;
@endphp
@php
    $name = session()->get('name');
    // $data = DB::table('userregistation')->get();
    $data = session()->get('user');
    $dataarray = json_decode($data, true);
@endphp
@if ($name != 'teacher')
    @php
        header('Location: ' . URL::to('/'), true, 302);
        exit();
    @endphp
@endif

@extends('Teacher.Tlayout')

<style>
    #barChart {
        width: 500px !important;
        height: 400px !important;
    }
</style>

@section('title')
    Teacher Dashboard
@endsection

@section('content')
    <h1>Teacher</h1>
    <div class="card">
        <input type="radio" id="semOne" name="semSelect" value="1" checked>
        <label for="semOne">Semester One</label>
        <input type="radio" id="semTwo" name="semSelect" value="2">
        <label for="semTwo">Semester Two</label>
        <input type="radio" id="semThree" name="semSelect" value="3">
        <label for="semThree">Semester Three</label>
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
    {{-- line Chart --}}
    <div class="">
        <div>
            <label for="select_student">Studentt</label>
            <select name="select_student" id="select_student" class="form-select form-select-sm">
                <option value="">- Select Student -</option>
                @foreach ($stList as $item)
                    <option value="{{ $item->id }}">{{ $item->studentFullName }}</option>
                @endforeach
            </select>
        </div>
        <canvas id="marksChart" width="400" height="200"></canvas>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            marksbarchart();
            rangePieChart();

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


            $('input[name="semSelect"]').change(function(e) {
                e.preventDefault();
                let sem = $('input[name="semSelect"]:checked').val();

                $.ajax({
                    type: "get",
                    url: "/getAvgBarChart/" + sem,
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
                getAvgCountPieChart(sem);
            });


            function getAvgCountPieChart(semester) {

                $.ajax({
                    type: "get",
                    url: "/getAvgCountPieChart/" + semester,
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

            // line chart
            lineChart();

            function lineChart() {

                var semesterOneData = <?php echo json_encode($semesterOneData); ?>;
                var semesterTwoData = <?php echo json_encode($semesterTwoData); ?>;
                var semesterThreeData = <?php echo json_encode($semesterThreeData); ?>;

                var allSubjects = Object.keys(semesterOneData);

                var ctx = document.getElementById('marksChart').getContext('2d');

                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: allSubjects,
                        datasets: [{
                                label: 'Semester 1',
                                data: allSubjects.map(function(subject) {
                                    return semesterOneData[subject] || 0;
                                }),
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                fill: false,
                            },
                            {
                                label: 'Semester 2',
                                data: allSubjects.map(function(subject) {
                                    return semesterTwoData[subject] || 0;
                                }),
                                borderColor: 'rgba(192, 75, 192, 1)',
                                borderWidth: 2,
                                fill: false,
                            },
                            {
                                label: 'Semester 3',
                                data: allSubjects.map(function(subject) {
                                    return semesterThreeData[subject] || 0;
                                }),
                                borderColor: 'rgba(192, 192, 75, 1)',
                                borderWidth: 2,
                                fill: false,
                            },
                        ],
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                suggestedMax: 100,
                            }
                        }
                    }
                });
            }

            // onchange event
            $('#select_student').change(function(e) {
                e.preventDefault();

                var id = $(this).val();

                $.ajax({
                    type: "get",
                    url: "/getstudentAllMarks/" + id,
                    success: function(res) {

                        var semesterOneData = res.semesterOneData;
                        var semesterTwoData = res.semesterTwoData;
                        var semesterThreeData = res.semesterThreeData;

                        var allSubjects = Object.keys(semesterOneData);

                        var ctx = $('#marksChart');

                        if (Chart.getChart(ctx)) {
                            Chart.getChart(ctx).destroy();
                        }

                        var chart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: allSubjects,
                                datasets: [{
                                        label: 'Semester 1',
                                        data: allSubjects.map(function(subject) {
                                            return semesterOneData[
                                                subject] || 0;
                                        }),
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 2,
                                        fill: false,
                                    },
                                    {
                                        label: 'Semester 2',
                                        data: allSubjects.map(function(subject) {
                                            return semesterTwoData[
                                                subject] || 0;
                                        }),
                                        borderColor: 'rgba(192, 75, 192, 1)',
                                        borderWidth: 2,
                                        fill: false,
                                    },
                                    {
                                        label: 'Semester 3',
                                        data: allSubjects.map(function(subject) {
                                            return semesterThreeData[
                                                subject] || 0;
                                        }),
                                        borderColor: 'rgba(192, 192, 75, 1)',
                                        borderWidth: 2,
                                        fill: false,
                                    },
                                ],
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        suggestedMax: 100,
                                    }
                                }
                            }
                        });

                    }
                });

            });
        });
    </script>
@endsection
