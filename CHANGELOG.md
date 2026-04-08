# Changelog

All notable changes to `secretwebmaster/laravel-localization` will be documented in this file.

## [2.4.0] - 2026-04-08

- Added Laravel 13 support on the `2.4.x` minor line with PHP 8.4, Testbench 11, and PHPUnit 12.5.
- Added package-level Testbench coverage for localization, translated routing, and middleware redirect flows under Laravel 13.
- Fixed translated route generation and translated route lookup when locale aliases are used through `localesMapping` such as `tw -> zh_TW`.
- Documented the `2.4.x` release line as the supported minor branch for WNCMS consumers.
