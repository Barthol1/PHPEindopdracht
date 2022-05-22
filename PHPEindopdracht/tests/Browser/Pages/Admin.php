<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Admin extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/admindashboard';
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
            '@updateClientForm' => 'main > div:last-child > form',
            '@clientTable' => 'main > div:last-child > div > table',
            '@updateClient' => 'main > div:last-child > form button',
            '@pickUpDate' => 'main > div:first-child > div > div > div > form:last-child input[name=date]',
            '@pickUpTime' => 'main > div:first-child > div > div > div > form:last-child input[name=time]',
            '@pickupPackage' => 'main > div:first-child > div > div > div > form:last-child a > input[type=submit]',
            '@searchbar' => 'main > div:first-child > div > div > div > form:nth-child(2) input[name=search]',
            '@search' => 'main > div:first-child > div > div > div > form:nth-child(2) > div > a > button',
            '@downloadLabel' => 'main > div:first-child > div > div > div > form:last-child > div:last-child a'
        ];
    }
}
