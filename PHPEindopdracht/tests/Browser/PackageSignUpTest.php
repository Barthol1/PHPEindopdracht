<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\PackageOverview;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class PackageSignUpTest extends DuskTestCase
{
    use withFaker;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testPackageSignUp()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard')
                    ->scrollTo('@formSignUpPackage')
                    ->pause(2000)
                    ->type('sender_name' , $this->faker->name())
                    ->type('sender_adres' , $this->faker->streetAddress())
                    ->type('sender_city' , $this->faker->city())
                    ->type('sender_postalcode' , $this->faker->postcode())
                    ->type('receiver_name' , $this->faker->name())
                    ->type('receiver_adres' , $this->faker->streetAddress())
                    ->type('receiver_postalcode' , $this->faker->postcode())
                    ->type('receiver_city' , $this->faker->city())
                    ->pause(2000)
                    ->press('Pakket aanmelden')
                    ->pause(2000);
        });
    }

    public function testPackageEdit()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard')
                    ->assertPresent('@paginator')
                    ->scrollTo('@paginateToPackage')
                    ->pause(2000)
                    ->clickAndWaitForReload('@paginateToPackage')
                    ->scrollTo('@editPackage')
                    ->pause(2000)
                    ->clickAndWaitForReload('@editPackage')
                    ->type('sender_name' , $this->faker->name())
                    ->type('sender_adres' , $this->faker->streetAddress())
                    ->type('sender_city' , $this->faker->city())
                    ->type('sender_postalcode' , $this->faker->postcode())
                    ->type('receiver_name' , $this->faker->name())
                    ->type('receiver_adres' , $this->faker->streetAddress())
                    ->type('receiver_postalcode' , $this->faker->postcode())
                    ->type('receiver_city' , $this->faker->city())
                    ->pause(2000)
                    ->press('Wijzigen')
                    ->pause(2000);
        });
    }

    public function testPackageDestroy()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard')
                    ->assertPresent('@paginator')
                    ->scrollTo('@paginateToPackage')
                    ->pause(2000)
                    ->clickAndWaitForReload('@paginateToPackage')
                    ->scrollTo('@removePackage')
                    ->pause(2000)
                    ->press('@removePackage')
                    ->pause(2000);
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
                    ->type('receiver_name' , $this->faker->name())
                    ->type('receiver_adres' , $this->faker->streetAddress())
                    ->type('receiver_postalcode' , $this->faker->postcode())
                    ->type('receiver_city' , $this->faker->city())
                    ->pause(2000)
                    ->press('Pakket aanmelden')
                    ->pause(2000);
        });
    }

    public function testPackageEditClient()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(4))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard')
                    ->assertPresent('@paginator')
                    ->scrollTo('@paginateToPackage')
                    ->pause(2000)
                    ->clickAndWaitForReload('@paginateToPackage')
                    ->scrollTo('@editPackage')
                    ->pause(2000)
                    ->clickAndWaitForReload('@editPackage')
                    ->type('receiver_name' , $this->faker->name())
                    ->type('receiver_adres' , $this->faker->streetAddress())
                    ->type('receiver_postalcode' , $this->faker->postcode())
                    ->type('receiver_city' , $this->faker->city())
                    ->pause(2000)
                    ->press('Wijzigen')
                    ->pause(2000);
        });
    }

    public function testPackageDestroyClient()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(4))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard')
                    ->assertPresent('@paginator')
                    ->scrollTo('@paginateToPackage')
                    ->pause(2000)
                    ->clickAndWaitForReload('@paginateToPackage')
                    ->scrollTo('@removePackage')
                    ->pause(2000)
                    ->press('@removePackage')
                    ->pause(2000);
        });
    }
}
