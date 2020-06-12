<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TimeEntry extends Model
{
    public $table = 'time_entries';

    protected $fillable = [
        'project_id',
        'user_id',
        'comment',
        'time_from',
        'time_to',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function time()
    {
        $start  = new Carbon($this->time_from);
        $end    = new Carbon($this->time_to);
        return $end->diffInSeconds($start);
    }
}