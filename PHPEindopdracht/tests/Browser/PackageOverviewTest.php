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
                    ->attach('#csvupload', storage_path('app/public/CSVImport2.csv'))
                    ->clickAndWaitForReload('#csvsubmit')
                    ->assertSee('Data Geimporteerd');
        });
    }

    public function testFilter() {
        package::factory()->create(['status' => PackageStatus::AFGELEVERD]);
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->select('Status', 'Aangemeld')
                    ->clickAndWaitForReload('#sortingbutton')
                    ->assertDontSeeIn('@card', 'Afgeleverd');
        });
    }

    public function testSorting() {
        $package = package::orderBy('name', 'desc')->first();
        $this->browse(function (Browser $browser) use ($package) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->select('Sorting', 'name')
                    ->clickAndWaitForReload('#sortingbutton')
                    ->assertSeeIn('@card', $package->name);
        });
    }
    public function testPagination() {
        package::factory(9)->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit(new PackageOverview)
                    ->assertPresent('@paginator');
        });
    }
}
