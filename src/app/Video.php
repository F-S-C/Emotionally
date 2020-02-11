<?php

namespace Emotionally;

use Emotionally\Http\Controllers\ReportController;
use Illuminate\Database\Eloquent\Model;
use function MongoDB\BSON\toJSON;

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

    public function getAverageEmotion(){
        $report = json_decode($this->report, true);
        $average = array('joy' => 0, 'sadness' => 0, 'anger' => 0, 'contempt' => 0, 'disgust' => 0, 'fear' => 0, 'surprise' => 0);
        $i = 0;
        foreach ($report as $frame) {
            $average['sadness'] += $frame['sadness'];
            $average['contempt'] += $frame['contempt'];
            $average['disgust'] += $frame['disgust'];
            $average['fear'] += $frame['fear'];
            $average['surprise'] += $frame['surprise'];
            $average['joy'] += $frame['joy'];
            $average['anger'] += $frame['anger'];
            $i++;
        }
        $average['sadness'] = $average['sadness']/$i;
        $average['contempt'] = $average['contempt']/$i;
        $average['disgust'] = $average['disgust']/$i;
        $average['fear'] = $average['fear']/$i;
        $average['surprise'] = $average['surprise']/$i;
        $average['joy'] = $average['joy']/$i;
        $average['anger'] = $average['anger']/$i;
        return json_encode($average);
    }
}
