<?php

namespace Mcamara\LaravelLocalization\Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;
use Mcamara\LaravelLocalization\Tests\TestCase;

class LaravelLocalizationLaravel13Test extends TestCase
{
    public function test_hidden_default_alias_is_recognized(): void
    {
        $this->assertTrue($this->app['laravellocalization']->isHiddenDefault('tw'));
        $this->assertFalse($this->app['laravellocalization']->isHiddenDefault('en'));
    }

    public function test_translated_route_generation_accepts_mapped_locale_aliases(): void
    {
        $url = $this->app['laravellocalization']->getURLFromRouteNameTranslated('tw', 'routes.about');

        $this->assertSame('http://localhost/guan-yu', $url);
    }

    public function test_get_localized_url_can_translate_an_alias_localized_route(): void
    {
        $this->app['config']->set('laravellocalization.hideDefaultLocaleInURL', false);

        $url = $this->app['laravellocalization']->getLocalizedURL('en', 'http://localhost/tw/guan-yu');

        $this->assertSame('http://localhost/en/about', $url);
    }

    public function test_session_redirect_middleware_redirects_to_non_default_locale(): void
    {
        $request = Request::create('http://localhost/contact', 'GET');
        $session = $this->app['session.store'];
        $session->start();
        $session->put('locale', 'en');
        $request->setLaravelSession($session);

        $this->refreshLocalizationForRequest($request);

        $response = (new LocaleSessionRedirect())->handle($request, fn ($request) => response('ok'));

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertSame('http://localhost/en/contact', $response->getTargetUrl());
    }

    public function test_localization_redirect_filter_strips_hidden_default_alias(): void
    {
        $request = Request::create('http://localhost/tw/contact', 'GET');

        $this->refreshLocalizationForRequest($request);

        $response = (new LaravelLocalizationRedirectFilter())->handle($request, fn ($request) => response('ok'));

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertSame('http://localhost/contact', $response->getTargetUrl());
    }
}
