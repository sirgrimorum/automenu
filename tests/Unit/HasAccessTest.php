<?php

namespace Sirgrimorum\AutoMenu\Tests\Unit;

use Sirgrimorum\AutoMenu\Tests\TestCase;
use Sirgrimorum\AutoMenu\AutoMenu;
use PHPUnit\Framework\Attributes\CoversClass;
use Illuminate\Support\Facades\Auth;
use App\User;

#[CoversClass(AutoMenu::class)]
class HasAccessTest extends TestCase
{
    public function test_has_access_true_requires_auth()
    {
        $this->assertFalse(AutoMenu::hasAccess(true));

        $user = new User();
        $this->actingAs($user);
        $this->assertTrue(AutoMenu::hasAccess(true));
    }

    public function test_has_access_false_requires_guest()
    {
        $this->assertTrue(AutoMenu::hasAccess(false));

        $user = new User();
        $this->actingAs($user);
        $this->assertFalse(AutoMenu::hasAccess(false));
    }

    public function test_has_access_with_callable()
    {
        $this->assertTrue(AutoMenu::hasAccess(fn() => true));
        $this->assertFalse(AutoMenu::hasAccess(fn() => false));
    }

    public function test_has_access_with_na_string()
    {
        $this->assertTrue(AutoMenu::hasAccess('na'));
        $this->assertTrue(AutoMenu::hasAccess('NA'));
    }

    public function test_has_access_default_is_false()
    {
        $this->assertFalse(AutoMenu::hasAccess(1));
        $this->assertFalse(AutoMenu::hasAccess(null));
        $this->assertFalse(AutoMenu::hasAccess('some string'));
    }
}
