<?php

namespace Tests\Browser;

use App\enum\PackageStatus;
use App\Models\package;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Tracing;
use Tests\DuskTestCase;

class TracingTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Tracing)
                    ->click('@loginbutton')
                    ->assertSee('Packr');
        });
    }
    public function testPackageSearch() {
        $package = package::factory()->create();
        $packagename = $package->name;
        $this->browse(function (Browser $browser) use ($packagename) {
            $browser->visit(new Tracing)
                    ->type('@packagenumber', $packagename)
                    ->clickAndWaitForReload('@package')
                    ->assertSee($packagename);
        });
    }
}
