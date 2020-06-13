<?php

namespace App\Http\Controllers;
use App\Services\TimeEntryService;
use App\TimeEntry;
use App\User;
use Illuminate\Http\Request;
use Auth;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TimeEntry as TimeEntryResource;
use Illuminate\Validation\ValidationException;

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

        try {
            $this->validate($request, [
                'project_id' => 'required',
                'time_from' => 'required',
                'time_to' => 'required|greater_than_field:time_from',
                'date' => 'required'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e.response], 400);
        }

        if ($request->time_to <= $request->time_from) {
            return response()->json(['message' => 'Die Endzeit darf nicht vor der Startzeit liegen!'], 400);
        }

        $eventsCount = TimeEntryService::countTimeEntriesAtTimeFromLoggedInUser($request->time_from, $request->time_to, $request->date);

        if ($eventsCount > 0) {
            return response()->json(['message' => 'Zu dieser Zeit ist bereits ein Eintrag vorhanden!'], 400);
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

        if ( $timeEntry->user_id == auth()->user()->id ) {
            return new TimeEntryResource($timeEntry);
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
