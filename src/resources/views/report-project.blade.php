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
        <div class="row">
            <div class="col-4">
                <h3>Spider Chart</h3>
                <canvas id="radar"></canvas>
            </div>
            <div class="col-4">
                <h3>Line Chart</h3>
                <canvas id="bar"></canvas>
            </div>
            <div class="col-4">
                <h3>Most frequent emotion</h3>
                <img class="mx-auto d-block m-3" src="{{ asset('images/emotions/sadness.png') }}">
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
        var canvas = document.getElementById("line").getContext("2d");

        var chart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [1, 2, 3].map(function (i) {
                    return {
                        label: 'Dataset ' + i,
                        data: [0, 0, 0, 0, 0, 0, 0].map(Math.random),
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
