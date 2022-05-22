<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin;
use Tests\DuskTestCase;

class ClientWebshopTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUpdateClientWebshop()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs(User::find(1))
                    ->visit(new Admin)
                    ->assertSee('AdminDashboard')
                    ->scrollTo('@updateClientForm')
                    ->pause(2000)
                    ->select('client', $user->name)
                    ->select('webshop')
                    ->press('@updateClient')
                    ->pause(2000)
                    ->scrollTo('@clientTable')
                    ->pause(2000);
        });

        User::destroy($user->id);
    }
}
