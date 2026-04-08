# secretwebmaster/laravel-localization

This package is a maintained compatibility replacement for
`mcamara/laravel-localization`, kept compatible with WNCMS and modern Laravel.

## Release line

`2.4.x` is the active minor line for the Laravel 13 upgrade track.

- PHP: `^8.4`
- Laravel: `^13.0`
- Testbench: `^11.0`
- PHPUnit: `^12.5`

## Why this exists

The upstream package is effectively unmaintained for our use case, while WNCMS
depends on locale alias behavior such as `tw -> zh_TW`.

This fork keeps the original namespaces and public APIs so it can remain a
drop-in replacement, while carrying the compatibility fixes needed by WNCMS.

## What changed in 2.4.x

- Laravel 13 / PHP 8.4 dependency baseline
- Verified middleware redirect behavior under Laravel 13
- Verified localized URL generation and translated route lookup under Laravel 13
- Fixed translated route generation and lookup when `localesMapping` aliases are used

## Compatibility

- Same namespaces
- Same service provider
- Same facade
- Same config contract
- Intended as a drop-in replacement for `mcamara/laravel-localization`

## Validation scope

The package now includes Testbench-based coverage for:

- mapped default locale handling with `hideDefaultLocaleInURL`
- translated route URL generation
- translated route lookup from alias-based localized URLs
- session-based locale redirection middleware
- hidden default locale redirection middleware

## Composer usage

```bash
composer require secretwebmaster/laravel-localization:^2.4
```
