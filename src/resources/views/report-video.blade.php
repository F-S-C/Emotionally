@extends('layouts.system')

@section('title', $project->name)

@section('head')
    @parent
    <style>

        .smaller-charts {
            height: 35vh;
            position: relative;
        }

        .bigger-charts {
            height: 30vh;
        }

        .emj {
            width: 150px;
        }

        @media only screen and (max-width: 600px) {
            .emj {
                width: 100px;
            }

            .smaller-charts {
                height: 30vh;
            }
        }
    </style>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('system.home')}}">
            <span class="fas fa-home" aria-hidden="true"></span>
            @lang('dashboard.home')
        </a>
    </li>
    @foreach($path as $father)
        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
            <a href="{{route('system.project-details', $father->id)}}">
                <span class="fas fa-folder" aria-hidden="true"></span>
                {{$father->name}}
            </a>
        </li>
    @endforeach
    <li class="breadcrumb-item active" aria-current="page">
        <span class="fas fa-video" aria-hidden="true"></span>
        {{$video->name}}
    </li>
@endsection

@section('inner-content')
    <div class="container-fluid">
        <div class="card-deck">
            <div class="card el-0dp">
                <div class="card-body">
                    <h3 class="card-title">Spider Chart</h3>
                    <div class="smaller-charts">
                        <canvas id="radar"></canvas>
                    </div>
                </div>
            </div>
            <div class="card el-0dp">
                <div class="card-body">
                    <h3 class="card-title">Bar Chart</h3>
                    <div class="smaller-charts">
                        <canvas id="bar"></canvas>
                    </div>
                </div>
            </div>
            <div class="card el-0dp">
                <div class="card-body">
                    <h3 class="card-title">Video</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3>Line Chart</h3>
                <canvas id="line"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let averageReport = @json(\Emotionally\Http\Controllers\ReportController::getEmotionValues(\Emotionally\Http\Controllers\ReportController::average($video->report)));
        let fullReport = @json(\Emotionally\Http\Controllers\ReportController::getEmotionValues($video->report));

        let radar = document.getElementById("radar").getContext("2d");
        let line = document.getElementById("line").getContext("2d");
        let bar = document.getElementById("bar").getContext("2d");

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
                        color: 'rgba(255, 255, 255, 0.5)'
                    },
                    gridLines: {
                        color: 'rgba(255, 255, 255, 0.5)'
                    },
                    pointLabels: {
                        fontColor: 'rgba(255,255,255,0.7)',
                        fontSize: 12
                    },
                    ticks: {
                        showLabelBackdrop: false,
                        fontColor: 'rgba(255, 255, 255, 0.7)'
                    }
                },
                legend: {
                    labels: {
                        fontColor: '#aaa'
                    }
                },
                maintainAspectRatio: false
            }
        });

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
                            color: 'rgba(255, 255, 255, 0.2)',
                            zeroLineColor: 'rgba(255, 255, 255, 0.5)'
                        },
                        ticks: {
                            fontColor: '#ccc'
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: 'rgba(255, 255, 255, 0.2)',
                            zeroLineColor: 'rgba(255, 255, 255, 0.5)'
                        },
                        ticks: {
                            fontColor: '#ccc'
                        }
                    }]
                },
                legend: {
                    labels: {
                        fontColor: '#ccc'
                    }
                },
                maintainAspectRatio: false
            }
        });

        function hexToRgb(hex) {
            // Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
            var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
            hex = hex.replace(shorthandRegex, function(m, r, g, b) {
                return r + r + g + g + b + b;
            });

            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        }
        let colors = ['#FF9800', '#5BC0EB', '#E55934', '#084887', '#9BC53D', '#F7F5FB', '#44AF69'];
        new Chart(line, {
            type: 'line',
            data: {
                labels: fullReport.map((_, i) => i), //TODO: Insert framerate as labels?
                datasets: Object.keys(fullReport[0]).map((key,i) => {
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
                            color: 'rgba(255, 255, 255, 0.2)',
                            zeroLineColor: 'rgba(255, 255, 255, 0.5)'
                        },
                        ticks: {
                            fontColor: '#ccc'
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: 'rgba(255, 255, 255, 0.2)',
                            zeroLineColor: 'rgba(255, 255, 255, 0.5)'
                        },
                        ticks: {
                            fontColor: '#ccc'
                        }
                    }]
                },
                legend: {
                    labels: {
                        fontColor: '#ccc'
                    }
                },
                plugins: {
                    colorschemes: {
                        scheme: 'brewer.SetOne3'
                    }
                }
            }
        });
    </script>
@endsection
