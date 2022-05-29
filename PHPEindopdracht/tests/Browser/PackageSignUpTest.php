<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Package;
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
    public function testSignUpPackage()
    {
        $package = Package::factory()->make();

        $this->browse(function (Browser $browser) use ($package) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard')
                    ->scrollTo('@formSignUpPackage')
                    ->pause(2000)
                    ->type('sender_name' , $package->sender_name)
                    ->type('sender_adres' , $package->sender_adres)
                    ->type('sender_city' , $package->sender_city)
                    ->type('sender_postalcode' , $package->sender_postalcode)
                    ->type('receiver_name' , $package->receiver_name)
                    ->type('receiver_adres' , $package->receiver_adres)
                    ->type('receiver_postalcode' , $package->receiver_postalcode)
                    ->type('receiver_city' , $package->receiver_city)
                    ->pause(2000)
                    ->press('Pakket aanmelden')
                    ->pause(2000);
        });

        Package::orderBy('id', 'desc')->first()->delete();
    }

    public function testEditPackage()
    {
        $package = Package::factory()->create();

        $this->browse(function (Browser $browser) use ($package) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard');
                    if($browser->element('@paginator')) {
                        $browser->scrollTo('@paginateToPackage')
                        ->pause(2000)
                        ->clickAndWaitForReload('@paginateToPackage')
                        ->scrollTo('@editPackagePagination')
                        ->pause(2000)
                        ->clickAndWaitForReload('@editPackagePagination');
                    }
                    else {
                        $browser->scrollTo('@editPackage')
                        ->pause(2000)
                        ->clickAndWaitForReload('@editPackage');
                    }
                    $browser->type('sender_name' , $this->faker->name())
                    ->type('sender_adres' , $this->faker->streetAddress())
                    ->type('sender_postalcode' , $this->faker->postcode())
                    ->type('sender_city' , $this->faker->city())
                    ->type('receiver_name' , $this->faker->name())
                    ->type('receiver_adres' , $this->faker->streetAddress())
                    ->type('receiver_postalcode' , $this->faker->postcode())
                    ->type('receiver_city' , $this->faker->city())
                    ->pause(2000)
                    ->press('Wijzigen')
                    ->pause(2000);
        });

        Package::destroy($package->id);
    }

    public function testDestroyPackage()
    {
        Package::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard');
                    if($browser->element('@paginator')) {
                        $browser->scrollTo('@paginateToPackage')
                        ->pause(2000)
                        ->clickAndWaitForReload('@paginateToPackage')
                        ->scrollTo('@removePackagePagination')
                        ->pause(2000)
                        ->pressAndWaitFor('@removePackagePagination');
                    }
                    else {
                        $browser->scrollTo('@removePackage')
                        ->pause(2000)
                        ->pressAndWaitFor('@removePackage');
                    }
                    $browser->pause(2000);
        });
    }

    public function testClientSignUpPackage()
    {
        $package = Package::factory()->create(['users_id' => 4]);

        $this->browse(function (Browser $browser) use ($package) {
            $browser->loginAs(User::find(4))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard')
                    ->scrollTo('@formSignUpPackage')
                    ->pause(2000)
                    ->type('receiver_name' , $package->receiver_name)
                    ->type('receiver_adres' , $package->receiver_adres)
                    ->type('receiver_postalcode' , $package->receiver_postalcode)
                    ->type('receiver_city' , $package->receiver_city)
                    ->pause(2000)
                    ->press('Pakket aanmelden')
                    ->pause(2000);
        });

        Package::destroy($package->id);
    }

    public function testClientEditPackage()
    {
        $package = Package::factory()->create(['users_id' => 4]);

        $this->browse(function (Browser $browser) use ($package) {
            $browser->loginAs(User::find(4))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard');
                    if($browser->element('@paginator')) {
                        $browser->scrollTo('@paginateToPackage')
                        ->pause(2000)
                        ->clickAndWaitForReload('@paginateToPackage')
                        ->scrollTo('@editPackagePagination')
                        ->pause(2000)
                        ->clickAndWaitForReload('@editPackagePagination');
                    }
                    else {
                        $browser->scrollTo('@editPackage')
                        ->pause(2000)
                        ->clickAndWaitForReload('@editPackage');
                    }
                    $browser->type('receiver_name' , $this->faker->name())
                    ->type('receiver_adres' , $this->faker->streetAddress())
                    ->type('receiver_postalcode' , $this->faker->postcode())
                    ->type('receiver_city' , $this->faker->city())
                    ->pause(2000)
                    ->press('Wijzigen')
                    ->pause(2000);
        });

        Package::destroy($package->id);
    }

    public function testClientDestroyPackage()
    {
        Package::factory()->create(['users_id' => 4]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(4))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard');
                    if($browser->element('@paginator')) {
                        $browser->scrollTo('@paginateToPackage')
                        ->pause(2000)
                        ->clickAndWaitForReload('@paginateToPackage')
                        ->scrollTo('@removePackagePagination')
                        ->pause(2000)
                        ->pressAndWaitFor('@removePackagePagination');
                    }
                    else {
                        $browser->scrollTo('@removePackage')
                        ->pause(2000)
                        ->pressAndWaitFor('@removePackage');
                    }
                    $browser->pause(2000);
        });
    }
}
