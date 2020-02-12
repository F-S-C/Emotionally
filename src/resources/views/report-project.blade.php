@extends('layouts.system')

@section('title', $project->name)

@section('head')
    @parent
    <style>

        .smaller-charts {
            height: 35vh;
            width: 35vw;
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
                width: 30vh;
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
        <span class="fas fa-file" aria-hidden="true"></span>
        @lang('dashboard.report')
    </li>
@endsection

@section('inner-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-4">
                <h3>Spider Chart</h3>
                <div class="smaller-charts my-5">
                    <canvas id="radar"></canvas>
                </div>
            </div>
            <div class="col-12 col-md-4 mt-5">
                <h3>Bar Chart</h3>
                <div class="bigger-charts">
                    <canvas id="bar"></canvas>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <h3>Most frequent emotion</h3>
                <img alt="emoji: {{$project->getAverageEmotionAttribute()}}" class="mx-auto d-block my-5 emj" src="
                @switch($project->getAverageEmotionAttribute())
                @case('joy')
                {{ asset('images/emotions/joy.png') }}
                @break
                @case('sadness')
                {{ asset('images/emotions/sadness.png') }}
                @break
                @case('anger')
                {{ asset('images/emotions/anger.png') }}
                @break
                @case('contempt')
                {{ asset('images/emotions/contempt.png') }}
                @break
                @case('disgust')
                {{ asset('images/emotions/disgust.png') }}
                @break
                @case('fear')
                {{ asset('images/emotions/fear.png') }}
                @break
                @case('surprise')
                {{ asset('images/emotions/surprise.png') }}
                @break
                @default
                @endswitch">
                <p class="h2 text-center text-capitalize">{{ $project->getAverageEmotionAttribute() }}</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let data = @json($report);

        let radar = document.getElementById("radar").getContext("2d");
        let bar = document.getElementById("bar").getContext("2d");

        new Chart(radar, {
            type: 'radar',
            data: {
                labels: Object.keys(data).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                datasets: [
                    {
                        label: 'Emotions',
                        data: Object.keys(data).map(el => data[el]),
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
                labels: Object.keys(data).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                datasets: [
                    {
                        label: 'Emotions',
                        data: Object.keys(data).map(el => data[el]),
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
    </script>
@endsection
