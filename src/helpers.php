<?php

use Leeovery\LaravelSettings\LaravelSettings;

if (! function_exists('userSettings')) {
    /**
     * @param  null  $baseKey
     * @param  null  $userId
     * @return LaravelSettings
     */
    function userSettings($baseKey = null, $userId = null)
    {
        $setting = app('laravel-settings-user');

        if (is_null($baseKey)) {
            return $setting;
        }

        /** @var LaravelSettings $setting */
        return $setting->baseKey($baseKey)
                       ->forEntity($userId);
    }
}
if (! function_exists('teamSettings')) {
    /**
     * @param  null  $baseKey
     * @param  null  $teamId
     * @return LaravelSettings
     */

    function teamSettings($baseKey = null, $teamId = null)
    {
        $setting = app('laravel-settings-team');

        if (is_null($baseKey)) {
            return $setting;
        }

        /** @var LaravelSettings $setting */
        return $setting->baseKey($baseKey)
                       ->forEntity($teamId);
    }
}
