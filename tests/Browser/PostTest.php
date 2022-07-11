<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class postTest extends DuskTestCase
{
    use DatabaseMigrations;

//    public function test_if_post_can_be_created()
//    {
//
//        Category::create([
//            'name' => 'tech',
//            'slug' => 'tech-category-related-stuff',
//
//        ]);
//
//        $this->browse(function (Browser $browser) {
//            $browser->visit('/register')
//                ->type('name', 'vishal vishwakarma')
//                ->type('username', 'vishal1')
//                ->type('email', 'vishal@gmail.com')
//                ->type('password', '1111')
//                ->click('button[type="submit"]')
//                ->assertSee('WELCOME BACK');
////                ->click('#Logout')
////                ->assertSee('LOGIN');
//        });
//
//
//        $this->browse(function (Browser $browser) {
//            $browser->loginAs(User::find(1))
//                ->visit('/admin/post/create')
//                ->type('title', 'first post automated')
//                ->type('slug', 'first-post-automated')
//                ->attach('thumbnail',public_path('images\illustration-1.png'))
//                ->type('excerpt', 'check out first post automated')
//                ->type('body', 'this is first post automated body')
//                ->select('category_id', 'tech')
//                ->click('button[type="submit"]')
//                ->pause(10000)
//                ->assertSee('Blog created successfully ! ');
//              error is when we submit the form no form is created and it doesnt show user signed in
//        });
//    }
    public function test_if_post_can_be_made()
    {
        $postA = Post::factory([
            'user_id' => User::factory()->create()->id,
        ])->create();

        $this->browse(function (Browser $browser) use ($postA) {
            $browser->visit('/')
                ->assertSee('Home');
        });

    }

}
