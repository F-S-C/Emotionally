<div class="col mb-4">
    <div class="project-detail-card card h-100 text-white square">
        <div class="bg-video-placeholder-container">
            <div class="bg-video-placeholder"
                 style="background-image: url('{{$video->thumbnail}}')"></div>
        </div>
        <div class="video-background card-img-top"></div>
        <div class="card-img-overlay project-detail-card-title" id="card-title-video-{{$video->id}}">
            <span class="sr-only">Video: </span>
            <h5 class="card-title">{{$video->name}}</h5>
        </div>
        {{-- TODO: Change route --}}
        <a class="project-card-link" href="{{route('system.project-details', $video->id)}}" aria-labelledby="card-title-video-{{$video->id}}"></a>
        <div class="card-img-overlay project-detail-card-options">
            <div class="dropdown">
                <button class="btn btn-outline-light border-0 rounded-circle dropdown-toggle"
                        type="button" id="more-video-{{$video->id}}" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"
                        title="More options (video {{$video->name}})">
                    <span class="sr-only">More options (video {{$video->name}})</span>
                    <span class="fas fa-ellipsis-v" aria-hidden="true"></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="more-video-{{$video->id}}">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
    </div>
</div>
