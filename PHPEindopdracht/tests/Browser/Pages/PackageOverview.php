<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class PackageOverview extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/dashboard';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@card' => 'main > div:first-child > div > div > div .card',
            '@paginator' => 'main > div > div > div > div > nav',
            '@formSignUpPackage' => 'main > div:last-child > form',
            '@paginateToPackage' => 'main > div:first-child nav > div:nth-child(2) > div:nth-child(2) > span > a:nth-last-child(2)',
            '@editPackage' => 'main > div:first-child > div > div > div > .card:last-child > .card-body > div:last-child > a',
            '@editPackagePagination' => 'main > div:first-child > div > div > div > .card:nth-last-child(2) > .card-body > div:last-child > a',
            '@removePackage' => 'main > div:first-child > div > div > div > .card:last-child > .card-body > div:last-child > form > a',
            '@removePackagePagination' => 'main > div:first-child > div > div > div > .card:nth-last-child(2) > .card-body > div:last-child > form > a',
            '@sortingbutton' => 'main > div:first-child > div > div > div > form:nth-child(2) button'
        ];
    }
}
