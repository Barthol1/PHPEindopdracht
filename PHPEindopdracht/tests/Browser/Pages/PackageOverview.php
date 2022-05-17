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
            '@card' => 'div > main > div > div > div > div > div:nth-child(3)',
            '@paginator' => 'div > main > div > div > div > div > nav',
            '@formSignUpPackage' => 'main > div:nth-child(2) > form',
            '@paginateToPackage' => 'main > div:first-child nav > div:nth-child(2) > div:nth-child(2) > span > a:nth-last-child(2)',
            '@changePackage' => 'main > div:first-child > div > div > div > .card:last > .card-body > div:last > a input'
        ];
    }
}
