<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginWorks()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->assertSee('Packr');
        });
    }

    public function testLogin() {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->type('email', 'superadmin@gmail.com')
                    ->type('password', 'superadmin')
                    ->clickAndWaitForReload('@loginbutton')
                    ->assertPathIs('/')
                    ->logout();
        });
    }

    public function testRegisterButton() {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                    ->clickAndWaitForReload('@registerbutton')
                    ->assertPathIs('/register')
                    ->assertSee('Packr');
        });
    }
}
