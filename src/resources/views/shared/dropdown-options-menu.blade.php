<style>
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
</style>
<!--<a class="dropdown-item" href="{{route('system.delete-project',$item_id)}}">Delete</a>
        <a class="dropdown-item" href="#" name="rename" value="{{$item_id }}">Rename</a>
        <a class="dropdown-item" href="#">Something else here</a>-->
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
        <button class="dropdown-item btn btn-link delete-project-btn" value="{{$item_id}}">Delete</button>
        <button class="dropdown-item btn btn-link rename-project-btn" value="{{$item_id}}">Rename</button>
        <button class="dropdown-item btn btn-link move-project-btn" value="{{$item_id}}">Move</button>

    </div>
</div>
