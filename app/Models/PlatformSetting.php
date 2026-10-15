<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PlatformSetting extends Model
{
    protected $fillable = ['key','value','group'];

    public static function getVal($key,$default=null){
        return Cache::rememberForever("platform_setting_{$key}",function () use($key,$default){
            $setting = self::where('key',$key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function setVal($key, $value, $gorup = 'ggeneral'){
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'gorup' => $gorup]
        );
        Cache::forget("platform_setting_{$key}");
    }
}
