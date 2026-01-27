<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    /**
     * Get a setting value by key.
     */
    public static function get($key, $default = null)
    {
        try {
            return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
                if (!DB::getSchemaBuilder()->hasTable('settings')) {
                    return $default;
                }
                $setting = DB::table('settings')->where('key', $key)->first();
                return $setting ? $setting->value : $default;
            });
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Get app name from settings or config.
     */
    public static function appName()
    {
        return self::get('app_name', config('app.name', 'SmartHR'));
    }

    /**
     * Get app logo from settings.
     */
    public static function appLogo()
    {
        $logo = self::get('app_logo');
        if ($logo) {
            return asset('storage/' . $logo);
        }
        return null; // No default logo
    }

    /**
     * Get app logo (white version) from settings.
     */
    public static function appLogoWhite()
    {
        $logo = self::get('app_logo');
        if ($logo) {
            return asset('storage/' . $logo);
        }
        return null; // No default logo
    }

    /**
     * Get small app logo from settings.
     */
    public static function appLogoSmall()
    {
        $logo = self::get('app_logo_small');
        if ($logo) {
            return asset('storage/' . $logo);
        }
        // Fallback to favicon if no small logo is set
        return asset('assets/img/favicon.png');
    }

    /**
     * Clear settings cache.
     */
    public static function clearCache()
    {
        try {
            Cache::forget('setting_app_name');
            Cache::forget('setting_app_logo');
            Cache::forget('setting_app_logo_small');
        } catch (\Exception $e) {
            // If cache driver fails, try to flush all cache
            try {
                Cache::flush();
            } catch (\Exception $e2) {
                // Ignore cache errors
            }
        }
    }
}
