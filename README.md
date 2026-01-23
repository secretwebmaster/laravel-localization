# secretwebmaster/laravel-localization

This package is a compatibility replacement for  
`mcamara/laravel-localization`.

## Why this exists

`mcamara/laravel-localization` contains a bug in locale mapping logic
that affects projects using alias locales (e.g. `tw → zh_TW`).
The upstream package is currently unmaintained.

This package provides a **drop-in replacement** with a minimal fix,
without changing namespaces or public APIs.

## What is changed

Only one method is modified:

- `LaravelLocalization::isHiddenDefault()`

The fix ensures locale aliases are converted to full locales before
comparison.

## Compatibility

- Same namespaces
- Same service provider
- Same facade
- Same config
- No breaking changes

## Composer usage

```bash
composer require secretwebmaster/laravel-localization
