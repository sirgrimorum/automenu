# Changelog

All notable changes to AutoMenu will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.3.4] - 2026-03-01

### Added
- Laravel 12 support
- `id` attribute on the rendered `<nav>` element (was only on the inner container before)

### Changed
- Minimum PHP version raised to 8.2

## [1.3.3] - 2026-03-01

### Added
- Scrutinizer CI configuration using PHP 8.2 and PHPUnit 10

## [1.3.2] - 2026-03-01

### Fixed
- Reverted a breaking change to the navbar `id` attribute introduced in 1.3.1
- Fixed `translateString()` JSON branch returning incorrect values when the config value was a JSON string

## [1.3.1] - 2026-02-26

### Added
- Comprehensive test suite using MySQL (orchestra/testbench)

### Fixed
- PHP 8.2 compatibility issues throughout the codebase

## [1.3.0] - 2026-02-23

### Changed
- Updated compatibility to PHP ^8.x and Laravel ^9.0|^10.0|^11.0
- Minimum PHP raised from 7.x to 8.x

## [1.2.27] - 2021-02-25

### Fixed
- Array functions compatibility update

## [1.2.26] - 2021-01-11

### Fixed
- Dropdown rendering corrections

## [1.2.25] - 2021-01-05

### Changed
- Logo image height made configurable
- Improved helper handling

## [1.2.24] - 2020-03-04

### Added
- Sticky-top class support fix for navbar

## [1.2.23] - 2019-08-05

### Added
- Integration with CrudGenerator's `get()` method in `replaceUser()` when the package is present
- Configurable `mr-auto`/`ml-auto` classes for left/right nav flexibility
- Dropdown rendered as Bootstrap dropdown component
- Extra style support for first and inner menu items
- Dynamic "active" class on the current URL menu item

### Fixed
- Active item detection with `request()` helper
- Icon handling

---

> Versions prior to 1.2.23 are not documented here.

[Unreleased]: https://github.com/sirgrimorum/automenu/compare/1.3.4...HEAD
[1.3.4]: https://github.com/sirgrimorum/automenu/compare/1.3.3...1.3.4
[1.3.3]: https://github.com/sirgrimorum/automenu/compare/1.3.2...1.3.3
[1.3.2]: https://github.com/sirgrimorum/automenu/compare/1.3.1...1.3.2
[1.3.1]: https://github.com/sirgrimorum/automenu/compare/1.3.0...1.3.1
[1.3.0]: https://github.com/sirgrimorum/automenu/compare/1.2.27...1.3.0
[1.2.27]: https://github.com/sirgrimorum/automenu/compare/1.2.26...1.2.27
[1.2.26]: https://github.com/sirgrimorum/automenu/compare/1.2.25...1.2.26
[1.2.25]: https://github.com/sirgrimorum/automenu/compare/1.2.24...1.2.25
[1.2.24]: https://github.com/sirgrimorum/automenu/compare/1.2.23...1.2.24
[1.2.23]: https://github.com/sirgrimorum/automenu/releases/tag/1.2.23
