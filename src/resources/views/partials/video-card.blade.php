<div class="col mb-4">
    <div class="project-detail-card card h-100 text-white square">
        <div class="bg-video-placeholder-container">
            <div class="bg-video-placeholder"
                 style="background-image: url('{{$video->thumbnail}}')"></div>
        </div>
        <div class="video-background card-img-top"></div>
        <div class="card-img-overlay project-detail-card-title" id="card-title-video-{{$video->id}}">
            <span class="sr-only">@lang('project-details.video'): </span>
            <h5 class="card-title">{{$video->name}}</h5>
        </div>
        {{-- TODO: Change route --}}
        <a class="project-card-link" href="{{route('system.report-video', $video->id)}}"
           aria-labelledby="card-title-video-{{$video->id}}"></a>
        <div class="card-img-overlay project-detail-card-options">
            @include('shared.dropdown-options-menu', ['id'=>'more-video-'.$video->id,'title'=>trans('project-details.more_options_video', ['name'=>$video->name])])
        </div>
    </div>
</div>
