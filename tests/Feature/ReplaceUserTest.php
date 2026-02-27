<?php

namespace Sirgrimorum\AutoMenu\Tests\Feature;

use Sirgrimorum\AutoMenu\Tests\TestCase;
use Sirgrimorum\AutoMenu\AutoMenu;
use PHPUnit\Framework\Attributes\CoversClass;
use Illuminate\Support\Facades\Auth;
use App\User;

#[CoversClass(AutoMenu::class)]
class ReplaceUserTest extends TestCase
{
    public function test_replace_user_not_logged_in_returns_unchanged()
    {
        Auth::shouldReceive('check')->andReturn(false);
        $config = ['replaces' => ['{name}' => 'name']];
        $input = "Hello {name}";
        
        $result = AutoMenu::replaceUser($input, $config);
        $this->assertEquals($input, $result);
    }

    public function test_replace_user_logged_in_replaces_attribute()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        
        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('id')->andReturn($user->id);
        Auth::shouldReceive('user')->andReturn($user);

        $config = ['replaces' => ['{name}' => 'name', '{email}' => 'email']];
        $input = "User: {name} ({email})";
        
        $result = AutoMenu::replaceUser($input, $config);
        $this->assertEquals("User: John Doe (john@example.com)", $result);
    }
}
