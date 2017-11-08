<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize();
            $browser->visit('/')
                    ->pause(2000)
                    ->assertPathIs('/login')
                    ->type('email', 'test@test.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->pause(1000)
                    ->assertPathIs('/')
                    ->click('#navbarDropdownMenuLink')
                    ->pause(500)
                    ->clickLink('Log Out');
        });
    }

    public function testFailedLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->maximize()
                ->visit('/')
                ->pause(2000)
                ->assertPathIs('/login')
                ->type('email', 'test@test.com')
                ->type('password', 'test123123')
                ->press("Login")
                ->waitForText('Invalid Credentials')
                ->assertSee('Invalid Credentials');
        });
    }
}
