<?php

use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class TimeEntryTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreateTimeEntry() {

        Passport::actingAs(factory(App\User::class)->make());
        $data = [
            'project_id' => "1",
            'time_from' => "12:00:00",
            'time_to' => "15:00:00",
            'date' => Carbon::tomorrow()->format("d.m.Y"),
        ];
        $response = $this->post('api/time-entries', $data);
        $response->assertStatus(200);
        $response->seeJsonContains(['message' => "Produkt erstellt!"]);
    }

    public function testGetAllOwnedTimeEntries()
    {
        Passport::actingAs(factory(App\User::class)->make());
        $weekStartDate = Carbon::now()->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = Carbon::now()->endOfWeek()->format('Y-m-d H:i');
        $response = $this->get('api/user/time-entries?start='. $weekStartDate .'&end='. $weekEndDate .'');
        $response->assertStatus(200);
        $response->seeJsonStructure(['data' => [[
            "id",
            'start',
            'end',
            'title',
            'created_at',
            'updated_at'
        ]]]);
    }
    public function testGetTimeEntryById()
    {
        Passport::actingAs(factory(App\User::class)->make());
        $response = $this->get('api/time-entries/1');
        $response->assertStatus(200);
        $response->seeJsonStructure([
            "end",
            'id',
            'start',
            'title'
        ]);
    }
}
