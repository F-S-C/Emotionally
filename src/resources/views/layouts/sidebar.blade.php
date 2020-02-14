@extends('layouts.master')

@section('head')
    @parent
    <style>
        #main {
            padding: 15px 15px 64px;
            width: 100%;
            min-height: 100%;
            transition: all 0.3s;
        }

        #main {
            width: 100%;
        }

        .input-color {
            background-color: #232323 !important;
            color: white !important;
        }

        .modal-close {
            color: white !important;
            background-color: transparent;
            border: none;
        }

        .modal-close:hover {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #232323 inset;
            -webkit-text-fill-color: white;
            caret-color: white;
        }
    </style>
@endsection

@section('body')
    <div class="wrapper">
        <nav class="sidebar el-8dp scrollbar-inner" id="main-navigation" aria-label="Sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand text-center w-100  d-flex" style="text-decoration: none;"
                   href="{{route('system.home')}}">
                    <img src="{{asset('/logo.png')}}" width="64"
                         height="64"
                         class="d-inline-block d-md-inline-block align-center mx-auto" alt="Emotionally's logo">
                    <img src="{{asset('/app_name.svg')}}" width="16"
                         height="64"
                         class="d-none d-md-inline-block flex-fill" alt="Emotionally">
                </a>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item active">
                    @if(!Auth::user()->projects->isEmpty())
                        <div class="btn-group collapse-button-container">
                            <a type="button" class="nav-link collapse-button d-none d-md-block" data-toggle="collapse"
                               href="#projects-container"
                               role="button" aria-expanded="false" aria-controls="projects-container"></a>
                            <a class="nav-link text-center text-md-left" href="{{route('system.home')}}">
                                <span aria-hidden="true" class="fas fa-home mr-0 mr-md-1 text-md-center"></span>
                                <span class="d-none d-md-inline">Projects</span>
                            </a>
                        </div>
                    @else
                        <a class="nav-link text-center text-md-left" href="{{route('system.home')}}">
                            <span aria-hidden="true" class="fas fa-home mr-0 mr-md-1 text-md-center"></span>
                            <span class="d-none d-md-inline">Projects</span>
                        </a>
                    @endif
                    <ul class="collapse el-3dp nav flex-column flex-nowrap" id="projects-container">
                        @each('partials.project-tree-view', Auth::user()->projects->where('father_id', null), 'main_project')
                    </ul>
                </li>
                <li class="nav-item text-center text-md-left">
                    <a class="nav-link text-center text-md-left" href="#">
                        <span aria-hidden="true" class="fas fa-info-circle mr-0 mr-md-1 text-md-center"></span>
                        <span class="d-none d-md-inline">About</span>
                    </a>
                </li>
                <li class="nav-item text-center text-md-left">
                    <a class="nav-link" href="#">
                        <span aria-hidden="true" class="fas fa-file-alt mr-0 mr-md-1 text-md-center"></span>
                        <span class="d-none d-md-inline">Portfolio</span>
                    </a>
                </li>
                <li class="nav-item text-center text-md-left">
                    <a class="nav-link" href="#">
                        <span aria-hidden="true" class="fas fa-phone-alt mr-0 mr-md-1 text-md-center"></span>
                        <span class="d-none d-md-inline">Contact</span>
                    </a>
                </li>
                <li class="nav-item text-center text-md-left">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <span aria-hidden="true" class="fas fa-sign-out-alt mr-0 mr-md-1 text-md-center"></span>
                        <span class="d-none d-md-inline">Logout</span>
                    </a>
                </li>
            </ul>

        </nav>
        <div class="content sidebar-content">
            <nav class="navbar navbar-expand-lg navbar-dark el-0dp" style="padding: 20px 30px;" aria-label="navbar">
                <div class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2 rounded-pill" type="search" placeholder="Search"
                           aria-label="Search" id="search-bar">
                </div>
                <div class="ml-auto btn-group dropleft">
                    <button class="btn btn-outline-primary rounded-pill" type="button" id="add-video"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            title="{{trans('dashboard.upload_video')}}">
                        <span class="fa fa-plus-circle mr-1" aria-hidden="true"></span>
                        Add
                    </button>
                    <div class="dropdown-menu" aria-labelledby="add-video">
                        @if( $project->father_id == "")
                            <button class="dropdown-item" id="create-project" data-toggle="modal"
                                    data-target="create-project-modal"
                                    data-modal="create-project-modal">{{trans('dashboard.add_project')}}
                            </button>
                            @if(Request::segment(2) == "project")
                                <div class="dropdown-divider"></div>
                            @endif
                        @endif
                        @if( Request::segment(2) == "project")
                            <button class="dropdown-item" id="upload-video" data-toggle="modal"
                                    data-target="upload-video-modal"
                                    data-modal="upload-video-modal">{{trans('dashboard.upload_video')}}</button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" id="realtime-video" data-toggle="modal"
                                    data-target="realtime-video-modal"
                                    data-modal="realtime-video-modal">{{trans('dashboard.realtime_video')}}</button>
                        @endif
                    </div>
                </div>
                {{--                <button class="navbar-toggler" type="button" data-toggle="collapse"--}}
                {{--                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"--}}
                {{--                        aria-expanded="false" aria-label="Toggle navigation">--}}
                {{--                    <span class="navbar-toggler-icon"></span>--}}
                {{--                </button>--}}

                {{--                <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
                {{--                    <ul class="navbar-nav mr-auto">--}}
                {{--                        <li class="nav-item active">--}}
                {{--                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
                {{--                        </li>--}}
                {{--                        <li class="nav-item">--}}
                {{--                            <a class="nav-link" href="#">Link</a>--}}
                {{--                        </li>--}}
                {{--                    </ul>--}}
                {{--                </div>--}}
            </nav>
            <!-- Modal 1 -->
            <div class="modal fade" id="upload-video-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content el-16dp">
                        <div class="modal-header">
                            <h5 class="modal-title" id="UploadVideoLabel">{{trans('dashboard.upload_video')}}</h5>
                            <button type="button" class="modal-close" data-dismiss="modal"
                                    aria-label="{{trans('dashboard.close')}}">
                                <span class="fas fa-times"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="video-upload-complete" class="alert alert-success" role="alert"
                                 style="display:none;">
                                {{trans('dashboard.upload_successful')}}
                            </div>
                            <div id="video-upload-notcomplete" class="alert alert-danger" role="alert"
                                 style="display:none;">
                                {{trans('dashboard.upload_failed')}}
                            </div>
                            <form method="POST" action="{{ route('system.videoUpload') }}" enctype="multipart/form-data"
                                  id="video-form">
                                @csrf
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-color"
                                              for="customVideo">{{trans('dashboard.upload_video')}}</span>
                                    </div>
                                    <div class="custom-file">
                                        <input multiple="multiple" type="file" class="custom-file-input input-color"
                                               id="customVideo" name="videos[]"
                                               accept="video/*">
                                        <label id="customVideoLabel" class="custom-file-label input-color "
                                               for="customVideo">{{trans('dashboard.choose_file')}}</label>
                                    </div>
                                </div>
                                <input type="text" name="project_id" value="{{$project->id}}" hidden>
                                <div class="collapse multi-collapse" id="duration-fps-collapse-menu">

                                    <div class="card card-body el-16dp">
                                        <div class="form-inline">
                                            <label for="framerate">Framerate:</label>
                                            <!---TODO: Cambiare da framerate a "Tempo tra una rilevazione e l'altra"--->
                                            <input type="number" id="framerate" name="framerate"
                                                   class="form-control mx-sm-3" min="1" max="60" value="30">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">
                                        {{trans('dashboard.close')}}
                                    </button>
                                    <input type="submit" value="{{ trans('dashboard.upload') }}" class="btn btn-primary"
                                           style="color: white;">
                                </div>
                            </form>
                            <div id="progress-container" style="display: none;">
                                <div class="progress">
                                    <div id="progress"
                                         class="progress-bar progress-bar-striped progress-bar-animated"
                                         role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                         style="width: 0%"></div>
                                </div>
                                <p class="text-center"> {{trans('dashboard.uploading')}}
                                    <span id="upload-text"></span>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!---Modal 2 Realtime--->
            <div class="modal fade" id="realtime-video-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content el-16dp">
                        <div class="modal-header">
                            <h5 class="modal-title" id="UploadVideoLabel">{{trans('dashboard.realtime_video')}}</h5>
                            <button type="button" class="modal-close" data-dismiss="modal"
                                    aria-label="{{trans('dashboard.close')}}">
                                <span class="fas fa-times"></span>
                            </button>
                        </div>
                        <div class="modal-body el-16dp">
                            <button id="btnStart">START RECORDING</button><br/>
                                <button id="btnStop">STOP RECORDING</button>

                            <video controls></video>

                            <video id="vid2" controls></video>
                        </div>
                    </div>
                </div>
            </div>

            <!---Modal 3 create project--->
            <div class="modal fade" id="create-project-modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content el-16dp">
                        <div class="modal-header">
                            <h5 class="modal-title" id="UploadVideoLabel">{{trans('dashboard.add_project')}}</h5>
                            <button type="button" class="modal-close" data-dismiss="modal"
                                    aria-label="{{trans('dashboard.close')}}">
                                <span class="fas fa-times"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="newproject-complete" class="alert alert-success" role="alert"
                                 style="display:none;">
                                {{trans('dashboard.project_created')}}
                            </div>
                            <div id="newproject-notcomplete" class="alert alert-danger" role="alert"
                                 style="display:none;">
                                {{trans('dashboard.err_creating_project')}}
                            </div>
                            <div id="newproject-creating" class="alert alert-warning" role="alert"
                                 style="display:none;">
                                {{trans('dashboard.creating_project')}}
                            </div>
                            <form method="POST" action="{{ route('system.newProject') }}" enctype="multipart/form-data"
                                  id="project-form">
                                @csrf
                                @if(Request::segment(2) == "project")
                                    <input type="hidden" name="father_id" value="{{ $project->id }}">
                                @endif
                                <label for="project_name">{{trans('dashboard.project_name')}}</label>
                                <input type="text" class="form-control input-color" id="project_name"
                                       name="project_name" placeholder="{{trans('dashboard.name')}}">

                                <div class="modal-footer mt-3">
                                    <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">
                                        {{trans('dashboard.close')}}
                                    </button>
                                    <input type="submit" value="{{ trans('dashboard.submit') }}" class="btn btn-primary"
                                           style="color: white;">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <main id="main">
                @yield('content')
            </main>
        </div>
    </div>
@endsection

@section('footer-class', 'fixed-bottom')

@section('scripts')
    <script type="text/javascript">
        (function ($) {
            $(document).ready(function () {
                $('.sidebarCollapse').on('click', function () {
                    $('.sidebar, #main').toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
                $('.sidebar').scrollbar();

                $('#create-project').on('click', function () {
                    $('#create-project-modal').modal('show');
                });

                $('#realtime-video').on('click', function () {
                    $('#realtime-video-modal').modal('show');
                });

                $('#upload-video').on('click', function () {
                    $('#upload-video-modal').modal('show');
                });

                $('#customVideo').on('change', function () {
                    $('#customVideoLabel').text($('#customVideo').val().replace(/C:\\fakepath\\/i, ''));
                    $('#duration-fps-collapse-menu').collapse('show');
                });

                $('#video-form').on('submit', function (event) {
                    event.preventDefault();
                    let bar = $("#progress");
                    let container = $("#progress-container");
                    let text = $("#upload-text");
                    let form = $('#video-form');
                    let video = $('#customVideo');
                    let alertComplete = $('#video-upload-complete');
                    let alertNotComplete = $('#video-upload-notcomplete');
                    let formDrop = $('#duration-fps-collapse-menu');
                    let videoLabel = $('#customVideoLabel');
                    container.show();
                    form.hide();
                    alertComplete.hide();
                    alertNotComplete.hide();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: this.action,
                        type: this.method,
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        xhr: function () {
                            let xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    let percentComplete = parseInt((evt.loaded / evt.total) * 100);
                                    bar.attr('aria-valuenow', percentComplete);
                                    bar.width(percentComplete + '%');
                                    text.text(percentComplete + "%");
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            container.hide();
                            if (JSON.parse(data)['result']) {
                                alertComplete.show();
                                $('#upload-video-modal').on('hidden.bs.modal', function () {
                                    location.reload(false);
                                });
                            } else {
                                alertNotComplete.show();
                            }

                            video.val('');
                            videoLabel.text('{{trans('dashboard.choose_file')}}');
                            formDrop.collapse('hide');
                            form.show();
                        },
                        error: function (data) {
                            container.hide();
                            alertNotComplete.show();
                            console.log(data);

                            video.val('');
                            videoLabel.text('{{trans('dashboard.choose_file')}}');
                            formDrop.collapse('hide');
                            form.show();
                        }
                    });
                });
                let constraintObj = {
                    audio: false,
                    video: {
                        facingMode: "user",
                        width: { min: 200, ideal: 400, max: 500 },
                        height: { min: 100, ideal: 250, max: 300 }
                    }
                };
                // width: 1280, height: 720  -- preference only
                // facingMode: {exact: "user"}
                // facingMode: "environment"

                //handle older browsers that might implement getUserMedia in some way
                $('#realtime-video').on('click', function () {
                    if (navigator.mediaDevices === undefined) {
                        navigator.mediaDevices = {};
                        navigator.mediaDevices.getUserMedia = function(constraintObj) {
                            let getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                            if (!getUserMedia) {
                                return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
                            }
                            return new Promise(function(resolve, reject) {
                                getUserMedia.call(navigator, constraintObj, resolve, reject);
                            });
                        }
                    }else{
                        navigator.mediaDevices.enumerateDevices()
                            .then(devices => {
                                devices.forEach(device=>{
                                    console.log(device.kind.toUpperCase(), device.label);
                                    //, device.deviceId
                                })
                            })
                            .catch(err=>{
                                console.log(err.name, err.message);
                            })
                    }

                    navigator.mediaDevices.getUserMedia(constraintObj)
                        .then(function(mediaStreamObj) {
                            //connect the media stream to the first video element
                            let video = document.querySelector('video');
                            if ("srcObject" in video) {
                                video.srcObject = mediaStreamObj;
                            } else {
                                //old version
                                video.src = window.URL.createObjectURL(mediaStreamObj);
                            }

                            video.onloadedmetadata = function(ev) {
                                //show in the video element what is being captured by the webcam
                                video.play();
                            };

                            //add listeners for saving video/audio
                            let start = document.getElementById('btnStart');
                            let stop = document.getElementById('btnStop');
                            let vidSave = document.getElementById('vid2');
                            let mediaRecorder = new MediaRecorder(mediaStreamObj);
                            let chunks = [];

                            start.addEventListener('click', (ev)=>{
                                mediaRecorder.start();
                                console.log(mediaRecorder.state);
                            })
                            stop.addEventListener('click', (ev)=>{
                                mediaRecorder.stop();
                                console.log(mediaRecorder.state);
                            });
                            mediaRecorder.ondataavailable = function(ev) {
                                chunks.push(ev.data);
                            }
                            mediaRecorder.onstop = (ev)=>{
                                let blob = new Blob(chunks, { 'type' : 'video/mp4;' });
                                chunks = [];
                                let videoURL = window.URL.createObjectURL(blob);
                                vidSave.src = videoURL;
                            }
                        })
                        .catch(function(err) {
                            console.log(err.name, err.message);
                        });
                });

                $('#project-form').on('submit', function (event) {
                    event.preventDefault();
                    let alertComplete = $('#newproject-complete');
                    let alertNotComplete = $('#newproject-notcomplete');
                    let creating = $('#newproject-creating');
                    let form = $('#project-form');
                    form.hide();
                    alertComplete.hide();
                    alertNotComplete.hide();
                    creating.show();
                    $.ajax({
                        url: this.action,
                        type: this.method,
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (data) {
                            creating.hide();
                            alertComplete.show();
                            $('#project_name').val('');
                            $('#create-project-modal').on('hidden.bs.modal', function () {
                                location.reload();
                            });
                            form.show();
                        },
                        error: function (data) {
                            creating.hide();
                            alertNotComplete.show();
                            console.log(data);
                            form.show();
                        }
                    });
                });
            });
        })(jQuery);
    </script>
@endsection
