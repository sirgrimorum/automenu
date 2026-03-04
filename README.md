# AutoMenu

![Latest Version on Packagist](https://img.shields.io/packagist/v/sirgrimorum/automenu.svg?style=flat-square)
![PHP Version](https://img.shields.io/packagist/php-v/sirgrimorum/automenu.svg?style=flat-square)
![Total Downloads](https://img.shields.io/packagist/dt/sirgrimorum/automenu.svg?style=flat-square)
![License](https://img.shields.io/packagist/l/sirgrimorum/automenu.svg?style=flat-square)

A dynamic, hierarchical Bootstrap navigation builder for Laravel. Generate full multi-level navbars from PHP configuration arrays — with user data interpolation, locale-aware links, access control, and zero HTML boilerplate.

## Features

- **No HTML required** — generate a complete Bootstrap navbar from a configuration array
- **Multi-level dropdowns** — unlimited nesting depth
- **User data interpolation** — embed `{name}`, `{email}`, or any user attribute/method into labels and URLs
- **Dynamic value prefixes** — `__route__`, `__url__`, `__trans__`, `__asset__`, `__getLocale__` are evaluated at render time
- **Per-item access control** — closures, `Auth::check()`, or the `"na"` (always-visible) constant
- **Blade stack injection** — push extra items into the menu at render time via named stacks
- **Fully configurable styling** — every Bootstrap class (navbar, brand, nav, items, dropdowns) is overridable in config

## Requirements

- PHP >= 8.2
- Laravel >= 9.0

## Installation

```bash
composer require sirgrimorum/automenu
```

### Publish configuration

```bash
php artisan vendor:publish --provider="Sirgrimorum\AutoMenu\AutoMenuServiceProvider" --tag=config
```

Publishes `config/sirgrimorum/automenu.php`.

### Publish views (optional)

```bash
php artisan vendor:publish --provider="Sirgrimorum\AutoMenu\AutoMenuServiceProvider" --tag=views
```

Publishes to `resources/views/vendor/sirgrimorum/automenu/`.

## Configuration

`config/sirgrimorum/automenu.php`

### Blade stacks

Items pushed onto these stacks are injected into the rendered navbar:

```php
'menu_stack'              => 'menuobj',    // main injection stack
'menuitem_izquierda_stack' => 'menuleft',  // left nav items
'menuitem_derecha_stack'   => 'menuright', // right nav items
```

### Bootstrap classes

```php
'classes' => [
    'navbar'        => 'navbar navbar-expand-md navbar-dark bg-dark',
    'brand'         => 'navbar-brand',
    'nav_izquierda' => 'navbar-nav mr-auto',
    'nav_derecha'   => 'navbar-nav ml-auto',
    'item'          => 'nav-item',
    'link'          => 'nav-link',
    'dropdown'      => 'nav-item dropdown',
    'dropdown_menu' => 'dropdown-menu',
    'dropdown_item' => 'dropdown-item',
    'button'        => 'btn btn-outline-light',
],
```

### User field replacements

Placeholders in labels and URLs are replaced with values from `Auth::user()`:

```php
'replaces' => [
    '{name}'  => 'name',       // property access
    '{email}' => 'email',
    '{image}' => 'getAvatar',  // method call if callable
],
```

### Dynamic value prefixes

| Prefix | Resolves to |
|--------|-------------|
| `__route__routeName` | `route('routeName')` |
| `__url__/path` | `url('/path')` |
| `__trans__key` | `trans('key')` |
| `__asset__path/file.js` | `asset('path/file.js')` |
| `__getLocale__` | `App::getLocale()` |

## Defining a Menu

The menu structure is a PHP array with three sections: `top`, `izquierdo` (left), and `derecha` (right). Store it in a config file or a translation file.

```php
// config/sirgrimorum/menus/main.php
return [
    'top'       => [],
    'izquierdo' => [
        [
            'label'  => '__trans__nav.home',
            'url'    => '__route__home',
            'access' => 'na',                          // always visible
        ],
        [
            'label'    => '__trans__nav.admin',
            'url'      => '#',
            'access'   => fn() => Auth::user()?->isAdmin(),
            'children' => [
                [
                    'label' => '__trans__nav.users',
                    'url'   => '__route__admin.users.index',
                ],
            ],
        ],
    ],
    'derecha' => [
        [
            'label'  => 'Hello, {name}',
            'url'    => '__route__profile',
            'access' => fn() => Auth::check(),
        ],
        [
            'label'  => '__trans__nav.login',
            'url'    => '__route__login',
            'access' => fn() => !Auth::check(),
        ],
    ],
];
```

## Usage

### Blade directive

```blade
{{-- render with explicit id, config path, and menu structure --}}
@load_automenu('main-nav', 'sirgrimorum/menus/main')

{{-- all three parameters are optional; falls back to config defaults --}}
@load_automenu()
```

### Facade

```blade
{!! AutoMenu::buildAutoMenu('main-nav', 'sirgrimorum/menus/main') !!}
```

### Injecting extra items at runtime

In any view rendered before the menu layout:

```blade
@push('menuobj')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('cart') }}">Cart ({{ $cartCount }})</a>
    </li>
@endpush
```

### Integration with sirgrimorum/pages

```php
use Sirgrimorum\Pages\Pages;

$menuWithPages = Pages::getAutoMenuConfig(2, 'izquierdo', config('sirgrimorum/menus/main'));
echo AutoMenu::buildAutoMenu('main-nav', '', $menuWithPages);
```

## API Reference

### `AutoMenu::buildAutoMenu()`

```php
AutoMenu::buildAutoMenu(
    string $id       = 'menu',  // HTML id for the <nav> element
    mixed  $config   = '',      // Config array or dot-path string to a config file
    mixed  $automenu = ''       // Menu structure array or translation key
): string
```

Returns the full Bootstrap navbar HTML string.

### `AutoMenu::replaceUser()`

```php
AutoMenu::replaceUser(string $string, mixed $config = ''): string
```

Replaces `{field}` placeholders in `$string` with values from the authenticated user.

### `AutoMenu::hasAccess()`

```php
AutoMenu::hasAccess(mixed $rule): bool
```

Evaluates an access rule: `'na'` → always `true`; `callable` → invokes it; otherwise returns `Auth::check()`.

### Blade directive

```blade
@load_automenu(string $id = 'menu', mixed $config = '', mixed $automenu = '')
```

## License

The MIT License (MIT). See [LICENSE.md](LICENSE.md).
