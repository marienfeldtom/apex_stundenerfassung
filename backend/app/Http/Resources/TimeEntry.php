<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as Resource;
use App\Services\TimeEntryService as TimeEntryService;

class TimeEntry extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start' => TimeEntryService::combineDateAndTime($this->date,$this->time_from)->format('Y-m-d H:i:s'),
            'end' => TimeEntryService::combineDateAndTime($this->date,$this->time_to)->format('Y-m-d H:i:s'),
            'title' => "Test",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];



    }
}
