<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_view_home()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->assertSee($user->username)
                ->assertSee('Load More')
                ->assertSee('Post')
                ->assertSee('like')
                ->assertSee('likes')
                ->assertSee('Suggesstion For You')
                ->assertSee('See All')
                ->assertSee('Follow')
                ->assertSee('user1')
                ->assertSee('user2')
                ->assertSee('user3')
                ->assertSee('View')
                ->assertSee('comments')
                ->type('comment', 'jabsdjh');
        });
    }

    public function test_check_exists_element_on_view_()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->assertSee($user->username)
                ->assertPresent('#navbarDropdown')
                ->assertPresent('#search')
                ->assertPresent('#loadPost')
                ->assertPresent('#listComment29')
                ->assertPresent('.show_comment86')
                ->assertPresent('.avatar-img')
                ->assertPresent('.profile-info-username')
                ->assertPresent('.search-input')
                ->assertPresent('.button-like')
                ->assertPresent('.button-unlike')
                ->assertPresent('.icon')
                ->assertPresent('.card')
                ->assertPresent('.img-profile');
        });
    }

    public function test_language_vietnamese()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->mouseover('@change-language')
                ->click('@vi')
                ->assertSee('Đăng')
                ->assertSee('Gợi ý theo dõi cho bạn')
                ->assertSee('Xem tất cả')
                ->assertSee('Theo dõi')
                ->assertSee('Lượt thích')
                ->assertSee('Xem')
                ->assertSee('bình luận')
                ->assertSee('Tải thêm');
        });
    }

    public function test_language_english()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs(User::find(1))
                ->visit('/home')
                ->mouseover('@change-language')
                ->click('@en')
                ->assertSee('Post')
                ->assertSee('Suggesstion For You')
                ->assertSee('See All')
                ->assertSee('Follow')
                ->assertSee('like')
                ->assertSee('likes')
                ->assertSee('View')
                ->assertSee('comments')
                ->assertSee('Load More');
        });
    }
}
