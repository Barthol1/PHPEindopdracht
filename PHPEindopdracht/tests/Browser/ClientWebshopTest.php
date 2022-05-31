<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Webshop;
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
        $webshop = Webshop::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $webshop) {
            $browser->loginAs(User::find(1))
                    ->visit(new Admin)
                    ->assertSee('AdminDashboard')
                    ->scrollTo('@updateClientForm')
                    ->pause(2000)
                    ->select('client', $user->id)
                    ->select('webshop', $webshop->id)
                    ->press('@updateClient')
                    ->pause(2000)
                    ->scrollTo('@clientTable')
                    ->pause(2000);
        });

        User::destroy($user->id);
        Webshop::destroy($webshop->id);
    }
}
