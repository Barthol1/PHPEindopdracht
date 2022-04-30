<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Register;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    use withFaker;

    public function testRegisterWorks()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register)
                    ->assertSee('Packr');
        });
    }

    public function testLoginButton() {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register)
                    ->clickAndWaitForReload('@loginbutton')
                    ->assertPathIs('/login')
                    ->assertSee('Packr');
        });
    }

    public function testRegister() {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register)
                    ->type('name', $this->faker->name())
                    ->type('email', $this->faker->email())
                    ->type('password', 'test123123')
                    ->type('password_confirmation', 'test123123')
                    ->clickAndWaitForReload('@registerbutton')
                    ->assertPathIs('/');
        });
    }
}
