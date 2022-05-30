<?php

namespace Tests\Unit;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_login()
    {
        $response = $this->call('GET','/login', ['email' => 'superadmin@gmail.com', 'password' => 'superadmin']);
        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
    }

    public function test_registration()
    {
        $response = $this->call('GET','/register', 
        ['email' => 'test@test', 
        'password' => 'testaccount',
        'password_confirmation' => 'testaccount'
        ]);
        $response->assertStatus(200);
    }
}
