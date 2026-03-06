<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\TranslationHelper;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if locale is set in session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            if (array_key_exists($locale, TranslationHelper::LANGUAGES)) {
                App::setLocale($locale);
            }
        } 
        // Check if locale is set in cookie
        elseif (Cookie::has('locale')) {
            $locale = Cookie::get('locale');
            if (array_key_exists($locale, TranslationHelper::LANGUAGES)) {
                App::setLocale($locale);
                Session::put('locale', $locale);
            }
        }
        // Check if locale is in URL parameter (for language switcher)
        elseif ($request->has('lang')) {
            $locale = $request->get('lang');
            if (array_key_exists($locale, TranslationHelper::LANGUAGES)) {
                App::setLocale($locale);
                Session::put('locale', $locale);
                Cookie::queue('locale', $locale, 60 * 24 * 30); // 30 days
            }
        }
        
        return $next($request);
    }
}