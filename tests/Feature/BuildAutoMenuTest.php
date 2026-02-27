<?php

namespace Sirgrimorum\AutoMenu\Tests\Feature;

use Sirgrimorum\AutoMenu\Tests\TestCase;
use Sirgrimorum\AutoMenu\AutoMenu;
use PHPUnit\Framework\Attributes\CoversClass;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as IlluminateView;

#[CoversClass(AutoMenu::class)]
class BuildAutoMenuTest extends TestCase
{
    public function test_build_auto_menu_with_array_config_and_array_menu()
    {
        $config = [
            'classes' => [
                'navbar_extra' => 'my-navbar-class',
            ]
        ];
        $menu = [
            'izquierdo' => [
                'Home' => [
                    'item' => '/',
                    'logedin' => 'na',
                ]
            ]
        ];

        $result = AutoMenu::buildAutoMenu('nav1', $config, $menu);

        $this->assertInstanceOf(IlluminateView::class, $result);
        $rendered = $result->render();
        $this->assertStringContainsString('id="nav1"', $rendered);
        $this->assertStringContainsString('my-navbar-class', $rendered);
        $this->assertStringContainsString('Home', $rendered);
    }

    public function test_build_auto_menu_loads_config_from_string_key()
    {
        $configData = [
            'classes' => [
                'navbar_extra' => 'config-class',
            ]
        ];
        Config::set('sirgrimorum.automenu.test', $configData);
        
        $menu = ['top' => []];

        $result = AutoMenu::buildAutoMenu('nav2', 'sirgrimorum.automenu.test', $menu);

        $rendered = $result->render();
        $this->assertStringContainsString('id="nav2"', $rendered);
        $this->assertStringContainsString('config-class', $rendered);
    }

    public function test_build_auto_menu_loads_menu_from_lang_key()
    {
        $config = [
            'classes' => [
                'navbar_extra' => 'navbar-dark bg-dark sticky-top',
            ]
        ];
        Lang::addLines([
            'automenu.izquierdo.About Us.item' => '/about',
            'automenu.izquierdo.About Us.logedin' => 'na'
        ], 'en', 'automenu');

        $result = AutoMenu::buildAutoMenu('nav3', $config, 'automenu::automenu');

        $rendered = $result->render();
        $this->assertStringContainsString('About Us', $rendered);
    }
}
