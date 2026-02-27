<?php

namespace Sirgrimorum\AutoMenu\Tests\Unit;

use Sirgrimorum\AutoMenu\Tests\TestCase;
use Sirgrimorum\AutoMenu\AutoMenu;
use PHPUnit\Framework\Attributes\CoversClass;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

#[CoversClass(AutoMenu::class)]
class TranslateStringTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->app['config']->set('sirgrimorum.automenu.trans_prefix', '__trans__');
        $this->app['config']->set('sirgrimorum.automenu.route_prefix', '__route__');
        $this->app['config']->set('sirgrimorum.automenu.url_prefix', '__url__');
        $this->app['config']->set('sirgrimorum.automenu.asset_prefix', '__asset__');
        $this->app['config']->set('sirgrimorum.automenu.public_prefix', '__public__');
        $this->app['config']->set('sirgrimorum.automenu.locale_key', '__getLocale__');
    }

    private function callTranslateString($item, $prefix, $function, $close = "__")
    {
        $ref = new \ReflectionClass(AutoMenu::class);
        $method = $ref->getMethod('translateString');
        $method->setAccessible(true);
        return $method->invokeArgs(null, [$item, $prefix, $function, $close]);
    }

    public function test_translate_string_no_token_returns_unchanged()
    {
        $input = "plain string";
        $result = $this->callTranslateString($input, "__trans__", "trans");
        $this->assertEquals($input, $result);
    }

    public function test_translate_string_with_trans_token()
    {
        Lang::addLines(['messages.hello' => 'Hello World'], 'en');
        $input = "Prefix __trans__messages.hello__ Suffix";
        $result = $this->callTranslateString($input, "__trans__", "trans");
        $this->assertEquals("Prefix Hello World Suffix", $result);
    }

    public function test_translate_string_with_route_token()
    {
        Route::get('/test-route', fn() => 'ok')->name('test.route');
        $input = "__route__test.route__";
        $result = $this->callTranslateString($input, "__route__", "route");
        $this->assertEquals(route('test.route'), $result);
    }

    public function test_translate_string_with_multiple_tokens()
    {
        Lang::addLines([
            'messages.a' => 'One',
            'messages.b' => 'Two'
        ], 'en');
        $input = "__trans__messages.a____trans__messages.b__";
        $result = $this->callTranslateString($input, "__trans__", "trans");
        $this->assertEquals("OneTwo", $result);
    }

    public function test_translate_string_with_json_args()
    {
        // For route with params: __route__name,{"param":"val"}__
        Route::get('/user/{id}', fn($id) => "user $id")->name('user.profile');
        
        $input = "__route__user.profile,{'id':123}__";
        $result = $this->callTranslateString($input, "__route__", "route");
        $this->assertEquals(route('user.profile', ['id' => 123]), $result);
    }
}
