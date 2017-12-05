<?php

namespace Tests\Browser;

use App\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TodoTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCreateTodo()
    {
        $today = Carbon::now()->format('F d Y');
        $this->browse(function(Browser $browser) use($today) {
            $this->loginUsing($browser, 1);

            $browser->visit('/')
                ->pause('500')
                ->clickLink('Create Todo Item')
                ->type('title', 'Test Todo Item')
                ->type('description', 'Test')
                ->click('.datepicker')
                ->click('.calendar-date-selected')
                ->click("#createItemButton")
                ->pause(500)
                ->assertSee($today);
        });
    }
}
