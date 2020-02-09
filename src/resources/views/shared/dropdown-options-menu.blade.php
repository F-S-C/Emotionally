<div class="dropdown more-icon">
    <button class="btn btn-outline-light border-0 rounded-circle dropdown-toggle"
            type="button" id="{{$id}}" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"
            title="{{$title}}">
        <span class="sr-only">{{$title}}</span>
        <span class="fas fa-ellipsis-v" aria-hidden="true"></span>
    </button>
    {{-- TODO: Edit options --}}
    <div class="dropdown-menu" aria-labelledby="{{$id}}">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
    </div>
</div>
