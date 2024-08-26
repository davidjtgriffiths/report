<?php

namespace App\Services;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Cache;

class AppSettingService
{
    public function get(string $key, $default = null)
    {
        // TODO: decide on cache shizzle
        // return Cache::remember("app_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = AppSetting::where('key', $key)->first();
            return $setting ? $this->castValue($setting->value, $setting->type) : $default;
        // });
    }

    public function set(string $key, $value, string $type = 'string', string $description = null)
    {
        $setting = AppSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => (string) $value,
                'type' => $type,
                'description' => $description
            ]
        );

        Cache::put("app_setting_{$key}", $this->castValue($setting->value, $setting->type), 3600);

        return $setting;
    }

    private function castValue($value, string $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'int':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }
}