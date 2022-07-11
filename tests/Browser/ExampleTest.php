<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    use DatabaseMigrations;
    public function testHomePageVue()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('ALL POSTS');
        });
    }

    public function testHomePageDataVue()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVue('dataLoaded', false, '@navbar');
        });
    }
}
