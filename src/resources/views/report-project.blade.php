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
        <span class="fas fa-file" aria-hidden="true"></span>
        @lang('dashboard.report')
    </li>
@endsection

@section('inner-content')
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-8">
                <h3>Spider Chart</h3>
                <canvas id="radar"></canvas>
            </div>
            <div class="col-4">
                <h3>Most frequent emotion</h3>
                <img class="mx-auto d-block m-3" src="
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
                <h5>{{ $project->getAverageEmotionAttribute() }}</h5> <!--TODO: Rimuovere linea di test-->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3>Bar Chart</h3>
                <canvas id="bar"></canvas>
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
                labels: Object.keys(data[0]).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                datasets: [
                    {
                        label: 'Emotions',
                        data: Object.keys(data[0]).map(el => data[0][el] * 100),
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
                }
            }
        });

        new Chart(bar, {
            type: 'bar',
            data: {
                labels: Object.keys(data[0]).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                datasets: [
                    {
                        label: 'Emotions',
                        data: Object.keys(data[0]).map(el => data[0][el] * 100),
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
                }
            }
        });
    </script>
@endsection
