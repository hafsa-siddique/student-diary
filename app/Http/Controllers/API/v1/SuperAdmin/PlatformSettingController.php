<?php

namespace App\Http\Controllers\API\v1\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;

class PlatformSettingController extends Controller
{
    public function index()
    {
        $settings = PlatformSetting::all()->pluck('value','key');
        return response()->json([
            'status' => true,
            'data' => $settings
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
        ]);

        foreach($request->settings as $key => $value){
            if ($request->hasFile("settings.{$key}")) {
                $file = $request->file("settings.{$key}");
                $path = $file->store('images', 'public');
                PlatformSetting::setVal($key, $path);
            } else {
                PlatformSetting::setVal($key, $value);
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Platform settings updated successfully.'
        ]);
    }
}
