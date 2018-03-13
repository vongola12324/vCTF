<?php

namespace App\Observers;


use App\Setting;

class SettingObserver
{
    /**
     * @param Setting $setting
     * @throws \Exception
     */
    public function creating(Setting $setting)
    {
        $availableType = [
            'int',
            'float',
            'string',
            'text',
            'html',
            'json',
        ];
        $setting->key = strtolower($setting->key);
        $setting->type = strtolower($setting->type);

        if (!in_array($setting->type, $availableType)) {
            throw new \Exception('Wrong type!');
        }
    }
}