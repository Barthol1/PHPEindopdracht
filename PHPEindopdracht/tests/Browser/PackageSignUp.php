<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\PackageOverview;
use Tests\DuskTestCase;

class PackageSignUp extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    // public function testPackageSignUp()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(1))
    //                 ->visit(new PackageOverview)
    //                 ->assertSee('Dashboard')
    //                 ->scrollTo('@formSignUpPackage')
    //                 ->pause(2000)
    //                 ->type('sender_name' , 'John')
    //                 ->type('sender_adres' , 'van den Eijsselweg 1')
    //                 ->type('sender_city' , 'Den Bosch')
    //                 ->type('sender_postalcode' , '1212AA')
    //                 ->type('receiver_name' , 'Damian')
    //                 ->type('receiver_adres' , 'van den Eijsselweg 1')
    //                 ->type('receiver_postalcode' , '2121AA')
    //                 ->type('receiver_city' , 'Den Bosch')
    //                 ->pause(2000)
    //                 ->press('Pakket aanmelden')
    //                 ->pause(2000);
    //     });
    // }

    public function testPackageEdit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard')
                    ->assertPresent('@paginator')
                    ->scrollTo('@paginateToPackage')
                    ->pause(2000)
                    ->click('@paginateToPackage')
                    ->pause(2000)
                    ->scrollTo('@changePackage')
                    ->pause(2000)
                    ->clickLink('@changePackage')
                    ->pause(20000);
        });
    }

    public function testPackageSignUpClient()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(4))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard')
                    ->scrollTo('@formSignUpPackage')
                    ->pause(2000)
                    ->type('receiver_name' , 'Damian')
                    ->type('receiver_adres' , 'van den Eijsselweg 1')
                    ->type('receiver_postalcode' , '2121AA')
                    ->type('receiver_city' , 'Den Bosch')
                    ->pause(2000)
                    ->press('Pakket aanmelden')
                    ->pause(2000);
        });
    }
}
