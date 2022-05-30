<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Package;

class PackageSignUpTest extends TestCase
{
    use withFaker;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_package_sign_up()
    {
        $user = User::find(1);
        $package = Package::factory()->make();

        $this->actingAs($user, 'web');

        $formData = [
            'sender_name' => $package->sender_name,
            'sender_adres' => $package->sender_adres,
            'sender_postalcode' => $package->sender_postalcode,
            'sender_city' => $package->sender_city,
            'receiver_name' => $package->receiver_name,
            'receiver_adres'=> $package->receiver_adres,
            'receiver_postalcode' => $package->receiver_postalcode,
            'receiver_city' => $package->receiver_city,
        ];

        $result = $this->postJson(route('storePackage'), $formData)
        ->assertStatus(200);

        $package = Package::orderBy('id', 'desc')->first();

        $result->assertJson(['result' => "package created " . $package->name]);

        $package->delete();
    }
}
