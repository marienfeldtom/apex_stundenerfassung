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

    static function countTimeEntriesAtTimeFromLoggedInUser($startTime, $endTime, $date){
        return auth()->user()->timeEntries()->where(function ($query) use ($startTime, $endTime, $date) {
            $query->where(function ($query) use ($startTime, $endTime, $date) {
                $query->where('time_from', '>=', $startTime)
                    ->where('time_to', '<', $startTime)
                    ->whereDate('date', '=', date_create_from_format("d.m.Y", $date));
            })
                ->orWhere(function ($query) use ($startTime, $endTime, $date) {
                    $query->where('time_from', '<', $endTime)
                        ->where('time_to', '>=', $endTime)
                        ->whereDate('date', '=', date_create_from_format("d.m.Y", $date));
                });
        })->count();
    }
}