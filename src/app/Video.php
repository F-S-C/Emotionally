<?php

namespace Emotionally;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * This function use to view user who uploaded video.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(){
        return $this->belongsTo('App\User');
    }

    /**
     * This function use to view video's father project.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(){
        return $this->belongsTo('App\Project');
    }
}
