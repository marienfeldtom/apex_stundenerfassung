<?php

namespace App\Http\Controllers;
use App\TimeEntry;
use App\User;
use Illuminate\Http\Request;
use Auth;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TimeEntry as TimeEntryResource;

class TimeEntryController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function index()
    {
        return response()->json(TimeEntry::all());
    }

    public function indexOwned(Request $request)
    {
        $timeEntries = $this->user->timeEntries()->whereBetween('date', [Carbon::parse($request->start), Carbon::parse($request->end)])->get();
        return TimeEntryResource::collection($timeEntries);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'date' => 'required'
        ]);
        $startTime = $request->time_from;
        $endTime = $request->time_to;
        $date = $request->date;

        $eventsCount = auth()->user()->timeEntries()->where(function ($query) use ($startTime, $endTime, $date) {
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

        if ($request->time_to <= $request->time_from) {
            return response()->json(['message' => 'Die Endzeit darf nicht vor der Startzeit liegen!'], 400);
        }

        if ($eventsCount > 0) {
            return response()->json(['message' => 'Zu dieser Zeit ist bereits ein Eintrag vorhanden!'], 400);
        }

        if ($validator->fails()) {
            return response()->json(['message' => 'Es gab einen Fehler bei der Validierung!'], 400);
        }


        $time_entry = TimeEntry::create([
            'project_id' => $request->project_id,
            'user_id' => auth()->user()->id,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'comment' => $request->comment ? $request->comment : "Kein Kommentar",
            'date' => date_create_from_format("d.m.Y", $request->date),
        ]);

        return response()->json([
            'status' => (bool) $time_entry,
            'data'   => $time_entry,
            'message' => $time_entry ? 'Produkt erstellt!' : 'Fehler'
        ]);

    }

    public function show($id)
    {
        $timeEntry = TimeEntry::find($id);

        if ( $timeEntry->id == auth()->user()->id ) {
            $merge1 = new DateTime(Carbon::parse($timeEntry->date)->format('Y-m-d') . ' ' . Carbon::parse($timeEntry->time_from)->format('H:i:s'));
            $merge2 = new DateTime(Carbon::parse($timeEntry->date)->format('Y-m-d') . ' ' . Carbon::parse($timeEntry->time_to)->format('H:i:s'));
            $timeEntry["id"] = $timeEntry->id;
            $timeEntry["start"] = $merge1->format('Y-m-d H:i:s');
            $timeEntry["end"] = $merge2->format('Y-m-d H:i:s');
            $timeEntry["title"] = "Test";  // $item->project->name
            return $timeEntry;
        }

        return response()->json(['message' => 'Zugriff auf diese Ressource verweigert!'], 403);

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
