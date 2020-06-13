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
}