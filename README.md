# automenu

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Easy Menu builder for Laravel using Bootstrap framework.
## Install

Via Composer

``` bash
$ composer require sirgrimorum/automenu
```
 Then publish de configuration files for the auto generated menus:

First the configuration file (general configuration for a menu)
``` bash
$ php artisan vendor:publish --tag=config
```

Then the lang file (especific localizable configuration for a menu)
``` bash
$ php artisan vendor:publish --tag=lang
```

Optionally, you can publish the blade views that generate the menus if needed to be changed (not recommended)
``` bash
$ php artisan vendor:publish --tag=views
```

## Usage

 In a blade layout use
``` html
{!! AutoMenu::buildAutoMenu()!!}
```
 or the blade directive
``` html
@load_automenu()
```

This will use the default parameters, givin the menu an id of "menu" and using the configurations in app/config/sirgrimorum/automenu.php and resources/lang/vendor/automenu/en/automenu.php

To use a diferent configuration, create a copy of the two configuration files and follow the instructions and give the call strings (the same for the config() and trans() commands) in the second and third parameters of the function call

``` php
AutoMenu::buildAutoMenu("menu_id","menus.new_config","menu_new_lang");
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email andres.espinosa@grimorum.com instead of using the issue tracker.

## Credits

- [SirGrimorum][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sirgrimorum/automenu.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/sirgrimorum/automenu/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/sirgrimorum/automenu.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/sirgrimorum/automenu.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sirgrimorum/automenu.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sirgrimorum/automenu
[link-travis]: https://travis-ci.org/sirgrimorum/automenu
[link-scrutinizer]: https://scrutinizer-ci.com/g/sirgrimorum/automenu/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/sirgrimorum/automenu
[link-downloads]: https://packagist.org/packages/sirgrimorum/automenu
[link-author]: https://github.com/sirgrimorum
[link-contributors]: ../../contributors
