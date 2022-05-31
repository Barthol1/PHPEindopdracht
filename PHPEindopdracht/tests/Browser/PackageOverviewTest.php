<?php

namespace Tests\Browser;

use App\enum\PackageStatus;
use App\Models\package;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\PackageOverview;
use Tests\DuskTestCase;

class PackageOverviewTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testPackageOverviewWorks() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->assertSee('Dashboard');
        });
    }

    public function testFileUpload()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->attach('#csvfile', storage_path('app/public/CSVImport.csv'))
                    ->clickAndWaitForReload('#filesubmit')
                    ->assertSee('Data Geimporteerd');
        });
    }

    public function testFilter() {
        $package = Package::factory()->create(['status' => PackageStatus::AFGELEVERD]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->select('Status', 'Aangemeld')
                    ->press('@sortingbutton')
                    ->assertSeeIn('@card', 'Aangemeld');
        });

        Package::destroy($package->id);
    }

    public function testSorting() {
        $package = Package::orderBy('name', 'desc')->first();
        $this->browse(function (Browser $browser) use ($package) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->select('Sorting', 'name')
                    ->clickAndWaitForReload('@sortingbutton')
                    ->assertSeeIn('@card', $package->name);
        });
    }

    public function testPagination() {
        $ids = array();

        for($i = 0; $i < 9; $i++) {
            $package = Package::factory($i)->create();
            $ids[] = $package;
        }

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->assertPresent('@paginator');
        });

        for($i = 0; $i < count($ids); $i++) {
            Package::destroy($ids[$i]);
        }
    }
}
