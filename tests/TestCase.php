<?php

namespace Mcamara\LaravelLocalization\Tests;

use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelLocalizationServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('app.key', 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=');
        $app['config']->set('app.locale', 'zh_TW');
        $app['config']->set('app.fallback_locale', 'en');
        $app['config']->set('session.driver', 'array');
        $app['config']->set('laravellocalization.supportedLocales', [
            'zh_TW' => [
                'name' => 'Traditional Chinese',
                'script' => 'Hans',
                'native' => '繁體中文',
                'regional' => 'zh_TW',
            ],
            'en' => [
                'name' => 'English',
                'script' => 'Latn',
                'native' => 'English',
                'regional' => 'en_GB',
            ],
        ]);
        $app['config']->set('laravellocalization.localesMapping', [
            'zh_TW' => 'tw',
        ]);
        $app['config']->set('laravellocalization.hideDefaultLocaleInURL', true);
        $app['config']->set('laravellocalization.useAcceptLanguageHeader', false);
        $app['config']->set('laravellocalization.urlsIgnored', []);
        $app['config']->set('laravellocalization.httpMethodsIgnored', []);
    }

    protected function defineRoutes($router)
    {
        $router->middleware('web')->group(function ($router) {
            $router->get('/contact', fn () => 'contact')
                ->middleware(\Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class);

            $router->get('/en/contact', fn () => 'contact-en');

            $router->get('/tw/contact', fn () => 'contact-default-alias')
                ->middleware(\Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class);
        });
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['translator']->addLines([
            'routes.about' => 'guan-yu',
        ], 'zh_TW');

        $this->app['translator']->addLines([
            'routes.about' => 'about',
        ], 'en');

        $this->app['laravellocalization']->transRoute('routes.about');
    }

    protected function refreshLocalizationForRequest(Request $request)
    {
        $this->app->instance('request', $request);
        $this->app->instance(Request::class, $request);
        $this->app->forgetInstance('laravellocalization');
        $this->app->forgetInstance(\Mcamara\LaravelLocalization\LaravelLocalization::class);

        return $this->app->make('laravellocalization');
    }
}
