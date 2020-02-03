<?php

namespace Emotionally;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * This function use to view users of the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User')
            ->withPivot('read', 'modify', 'add', 'remove')
            ->withTimestamps();
    }

    /**
     * This function use to view project's author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * This function use to view project's videos.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany('App\Video');
    }

    /**
     * This function use to view project's sub projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sub_projects()
    {
        return $this->hasMany('App\Project', 'father_id');
    }

    /**
     * This function use to view a sub project's father project.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function father_project()
    {
        return $this->belongsTo('App\Project', 'father_id');
    }
}
