<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;

class SettingComposer
{
    public static function compose()
    {
        $locale = app()->getLocale();

        $settings = cache()->remember("settings", now()->addMinutes(60), function () use ($locale) {
            return Setting::get()
                ->mapWithKeys(function ($setting) use ($locale) {
                    $key = strtolower($setting->group . '.' . $setting->key);
                    $value = $setting->getTranslation('value', $locale)
                        ?: collect(optional($setting)->getTranslations('value'))->first()
                        ?: null;
                    return [$key => $value];
                })
                ->toArray();
        });

        View::composer(
            ['layouts.app'],
            function ($view) use ($settings) {
                $view->with('settings', $settings);
            }
        );

        app()->instance('settings', $settings);
    }
}
