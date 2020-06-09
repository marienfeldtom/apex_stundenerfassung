<?php

use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetOrders()
    {
        Passport::actingAsClient(
            factory(Client::class)->create(),
            ['check-status']
        );

        $response = $this->get('/api/private/contacts');

        $response->assertEquals(200, $this->response->status());
    }

    public function testGetContacts()
    {
        Passport::actingAs(
            factory(User::class)->create(), ['*', 'api']
        );

        $response = $this->post('/api/private/contacts');

        $response->assertEquals(200, $this->response->status());
    }
}
