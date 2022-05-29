<?php

namespace Tests\Browser;

use App\enum\PackageStatus;
use App\Models\User;
use App\Models\Package;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin;
use Tests\DuskTestCase;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;

class PackagePickUpTest extends DuskTestCase
{
    use WithFaker;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testPickupPackage()
    {
        $package = Package::factory()->create(['status' => PackageStatus::UITGEPRINT]);
        $date = Carbon::now()->timezone('Europe/Amsterdam');

        $this->browse(function (Browser $browser) use ($package, $date) {
            $browser->loginAs(User::find(5))
                    ->visit(new Admin)
                    ->assertSee('AdminDashboard')
                    ->pause(2000)
                    ->type('@searchbar', $package->name)
                    ->press('@search')
                    ->assertSee($package)
                    ->pause(2000)
                    ->keys('@pickUpDate', $date->addDays(2)->day, $date->month, $date->year)
                    ->keys('@pickUpTime', $date)
                    ->check('selectedPackage[]')
                    ->pause(2000)
                    ->press('@pickupPackage')
                    ->pause(2000)
                    ->type('@searchbar', $package->name)
                    ->press('@search')
                    ->assertSee($package)
                    ->pause(2000);
        });

        Package::destroy($package->id);
    }
}
