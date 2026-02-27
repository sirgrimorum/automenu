<?php

namespace Sirgrimorum\AutoMenu\Tests\Unit;

use Sirgrimorum\AutoMenu\Tests\TestCase;
use Sirgrimorum\AutoMenu\AutoMenu;
use PHPUnit\Framework\Attributes\CoversClass;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

#[CoversClass(AutoMenu::class)]
class TranslateConfigTest extends TestCase
{
    private function callTranslateConfig(array $array)
    {
        $ref = new \ReflectionClass(AutoMenu::class);
        $method = $ref->getMethod('translateConfig');
        $method->setAccessible(true);
        return $method->invokeArgs(null, [$array]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure default prefixes are set in config
        $this->app['config']->set('sirgrimorum.automenu.locale_key', '__getLocale__');
        $this->app['config']->set('sirgrimorum.automenu.trans_prefix', '__trans__');
        $this->app['config']->set('sirgrimorum.automenu.route_prefix', '__route__');
        $this->app['config']->set('sirgrimorum.automenu.url_prefix', '__url__');
        $this->app['config']->set('sirgrimorum.automenu.asset_prefix', '__asset__');
        $this->app['config']->set('sirgrimorum.automenu.public_prefix', '__public__');
    }

    public function test_translate_config_replaces_keys()
    {
        App::setLocale('es');
        $input = [
            'menu___getLocale__' => 'value'
        ];
        $result = $this->callTranslateConfig($input);
        $this->assertArrayHasKey('menu_es', $result);
    }

    public function test_translate_config_replaces_values()
    {
        Lang::addLines(['messages.msg' => 'Hola'], 'es');
        App::setLocale('es');
        
        $input = [
            'greeting' => '__trans__messages.msg__'
        ];
        $result = $this->callTranslateConfig($input);
        $this->assertEquals('Hola', $result['greeting']);
    }

    public function test_translate_config_recurses_nested_arrays()
    {
        Lang::addLines(['nested.key' => 'Value'], 'en');
        App::setLocale('en');

        $input = [
            'level1' => [
                'level2' => '__trans__nested.key__'
            ]
        ];
        $result = $this->callTranslateConfig($input);
        $this->assertEquals('Value', $result['level1']['level2']);
    }
}
