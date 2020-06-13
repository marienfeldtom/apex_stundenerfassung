<?php

namespace App\Services;
use Carbon\Traits\Timestamp;
use DateTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as Collection;

class TimeEntryService {
    static function combineDateAndTime(String $date, String $time){
        try {
            return new DateTime(Carbon::parse($date)->format('Y-m-d') . ' ' . Carbon::parse($time)->format('H:i:s'));
        } catch (Exception $e) {

        } catch (\Exception $e) {
        }
    }

    static function mapTimeEntries(Collection $timeEntries){
        return $timeEntries->map(function ($item, $key) {
              $merge1 = \App\Services\TimeEntryService::combineDateAndTime($item->date,$item->time_from);
              $merge2 = TimeEntryService::combineDateAndTime($item->date,$item->time_to);
              $data["id"] = $item->id;
              $data["start"] = $merge1->format('Y-m-d H:i:s');
              $data["end"] = $merge2->format('Y-m-d H:i:s');
              $data["title"] = "Test";  // $item->project->name
              return $data;
          });
    }
}