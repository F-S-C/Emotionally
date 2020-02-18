<?php

namespace Emotionally;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $appends = ["thumbnail"];

    /**
     * This function use to view user who uploaded video.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('Emotionally\User');
    }

    /**
     * This function use to view video's father project.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('Emotionally\Project');
    }

    /**
     * Get the thumbnail of a video.
     * @return string The thumbnail.
     */
    public function getThumbnailAttribute()
    {
        return 'https://picsum.photos/848/480'; // TODO: Implement thumbnail
    }
}
