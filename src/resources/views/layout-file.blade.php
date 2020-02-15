@extends('layouts.blank')

@section('title',"File report: " .$video->name)


@section('body')
    <div class="container w-75">
        <h1>File video report: {{$video->name}}</h1>
        <div class="row my-4">
            <div class="col-6">
                <table class="table" style="color:black">
            <thead class="thead-light">
            <tr>
                <th scope="col">Creator</th>
                <th scope="col">Project </th>
                <th scope="col">Video's duration</th>
                <th scope="col">Range analyzed</th>

            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{(new Emotionally\Http\Controllers\VideoController)->getCreator($video)->name }}
                    {{(new Emotionally\Http\Controllers\VideoController)->getCreator($video)->surname}}</td>

                <td>{{(new Emotionally\Http\Controllers\VideoController)->getProject($video)->name}}</td>

                <td>{{$video->duration}}</td>

                <td>[ {{$video->start}} , {{$video->end}} ]</td>
            </tr>

            </tbody>
        </table>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <h3>Spider Chart</h3>
                <div class="smaller-charts">
                    <canvas id="radar"></canvas>
                </div>
            </div>
            <div class="col-6">
                <h3>Bar Chart</h3>
                <div class="smaller-charts">
                    <canvas id="bar"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3>Line Chart</h3>
                <div class="bigger-charts">
                    <canvas id="line"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        (function () {
            $(document).ready(function () {

                let averageReport = @json($video->average_report);
                let fullReport = @json(\Emotionally\Http\Controllers\ReportController::getEmotionValues($video->report));

                let radar = document.getElementById("radar").getContext("2d");
                let line = document.getElementById("line").getContext("2d");
                let bar = document.getElementById("bar").getContext("2d");

                /**
                 * Create a new radar chart.
                 */
                new Chart(radar, {
                    type: 'radar',
                    data: {
                        labels: Object.keys(averageReport).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                        datasets: [
                            {
                                label: 'Emotions',
                                data: Object.keys(averageReport).map(el => averageReport[el]),
                                fill: true,
                                backgroundColor: 'rgba(255, 152, 0, 0.3)',
                                borderColor: 'rgba(255, 152, 0, 0.7)',
                                pointBackgroundColor: 'rgba(255, 152, 0, 1)',
                                pointBorderColor: 'rgba(255, 255, 255, 0.9)'
                            }
                        ]
                    },
                    options: {
                        scale: {
                            angleLines: {
                                color: 'rgba(0, 0, 0, 0.5)'
                            },
                            gridLines: {
                                color: 'rgba(0, 0, 0, 0.5)'
                            },
                            pointLabels: {
                                fontColor: 'rgba(0, 0, 0, 0.7)',
                                fontSize: 12
                            },
                            ticks: {
                                showLabelBackdrop: false,
                                fontColor: 'rgba(0, 0, 0, 0.7)'
                            }
                        },
                        legend: {
                            labels: {
                                fontColor: '#000'
                            }
                        },
                        maintainAspectRatio: false
                    }
                });

                /**
                 * Create a new bar chart.
                 */
                new Chart(bar, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(averageReport).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                        datasets: [
                            {
                                label: 'Emotions',
                                data: Object.keys(averageReport).map(el => averageReport[el]),
                                fill: false,
                                barPercentage: 0.25,
                                backgroundColor: 'rgba(255, 152, 0, 1)',
                                hoverBackgroundColor: 'rgba(255, 152, 0, 0.7)'
                            }
                        ]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    color: 'rgba(0, 0, 0, 0.2)',
                                    zeroLineColor: 'rgba(0, 0, 0, 0.5)'
                                },
                                ticks: {
                                    fontColor: '#000'
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: 'rgba(0, 0, 0, 0.2)',
                                    zeroLineColor: 'rgba(0, 0, 0, 0.5)'
                                },
                                ticks: {
                                    fontColor: '#000'
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                fontColor: '#000'
                            }
                        },
                        maintainAspectRatio: false
                    }
                });

                let colors = ['#FF9800', '#5BC0EB', '#E55934', '#084887', '#9BC53D', '#97959b', '#44AF69'];

                /**
                 * Create a new line chart.
                 */
                let lineChart = new Chart(line, {
                    type: 'line',
                    data: {
                        labels: fullReport.map((_, i) => i), //TODO: Insert framerate as labels?
                        datasets: Object.keys(fullReport[0]).map((key, i) => {
                            return {
                                borderColor: colors[i],
                                pointBackgroundColor: colors[i],
                                pointBorderColor: colors[i],
                                label: key.charAt(0).toUpperCase() + key.slice(1),
                                data: fullReport.map(el => el[key]),
                                fill: false
                            };
                        })
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    color: 'rgba(0, 0, 0, 0.2)',
                                    zeroLineColor: 'rgba(0, 0, 0, 0.5)'
                                },
                                ticks: {
                                    fontColor: '#000'
                                }
                            }],
                            yAxes: [{
                                gridLines: {
                                    color: 'rgba(0, 0, 0, 0.2)',
                                    zeroLineColor: 'rgba(0, 0, 0, 0.5)'
                                },
                                ticks: {
                                    fontColor: '#000'
                                }
                            }]
                        },
                        legend: {
                            labels: {
                                fontColor: '#000'
                            }
                        },
                        maintainAspectRatio: false,
                        plugins: {
                            colorschemes: {
                                scheme: 'brewer.SetOne3'
                            }
                        }
                    }
                });
            });
        })($);
    </script>
@endsection
