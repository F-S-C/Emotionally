<style>
    .dropleft .dropdown-toggle::before {
        display: none;
    }
</style>
<div class="dropdown more-icon dropleft">
    <button class="btn btn-outline-light border-0 rounded-circle dropdown-toggle"
            type="button" id="{{$id}}" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"
            title="{{$title}}">
        <span class="sr-only">{{$title}}</span>
        <span class="fas fa-ellipsis-v" aria-hidden="true"></span>
    </button>
    <div class="dropdown-menu" aria-labelledby="{{$id}}">
        <button class="dropdown-item btn btn-link rename-video-btn">Rename</button>
        <button class="dropdown-item btn btn-link move-video-btn">Move</button>
        <div class="dropdown-divider"></div>
        <button class="dropdown-item btn btn-link delete-video-btn">Delete</button>
    </div>
</div>
