<?php

use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetContacts()
    {
        Passport::actingAsClient(
            factory(App\User::class)->make([
                'password_client' => '1',
            ])
        );

        $response = $this->post('/api/private/contacts');

        $response->assertEquals(200, $this->response->status());
    }
}
