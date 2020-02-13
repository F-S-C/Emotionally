@extends('layouts.system')

@section('title', $project->name)

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
                    <div class="smaller-charts">
                    @if(!empty($video->url))
                        <video controls preload="metadata" style="max-width: 110%;">
                            <source src="{{$video->url}}" type="video/{{pathinfo($video->url,PATHINFO_EXTENSION)}}">
                        </video>
                    @endif
                    </div>
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
    <script>
        let averageReport = @json($video->average_report);
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

        let colors = ['#FF9800', '#5BC0EB', '#E55934', '#084887', '#9BC53D', '#F7F5FB', '#44AF69'];
        new Chart(line, {
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
                maintainAspectRatio: false,
                plugins: {
                    colorschemes: {
                        scheme: 'brewer.SetOne3'
                    },
                    zoom: {
                        pan: {
                            enabled: true,
                            mode: 'x',
                            rangeMin: {
                                // Format of min pan range depends on scale type
                                x: 0,
                                y: 0
                            },
                            rangeMax: {
                                // Format of max pan range depends on scale type
                                x: null,
                                y: null
                            }
                        },
                        zoom: {
                            enabled: true,
                            drag: true,
                            mode: 'xy',

                            rangeMin: {
                                // Format of min zoom range depends on scale type
                                x: null,
                                y: 0
                            },
                            rangeMax: {
                                // Format of max zoom range depends on scale type
                                x: null,
                                y: 1
                            },

                            // Speed of zoom via mouse wheel
                            // (percentage of zoom on a wheel event)
                            speed: 0.1
                        }
                    }
                }
            }
        });
    </script>
@endsection
