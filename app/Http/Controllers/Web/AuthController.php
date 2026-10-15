<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Institute;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showInstituteLogin(Request $request)
    {
        $instituteCode = $request->route('institute');
        $institute = Institute::with('configuration')
            ->where('code',  $request->route('institute'))
            ->firstOrFail();
            
        if (!$institute->status) {
            return response()->view('errors.institute-inactive', [], 403);
        }    
        $configuration = $institute->configuration;
        $logoPath = $configuration?->login_logo ?: $configuration?->main_logo ?: PlatformSetting::getVal('default_login_logo');
        $logoPath = $logoPath ? preg_replace('#^/?storage/#', '', $logoPath) : null;
        $instituteLogo = $logoPath ? asset('storage/' . ltrim($logoPath, '/')) : null;
        // dd([
        //     'login_logo' => $configuration?->login_logo,
        //     'main_logo' => $configuration?->main_logo,
        //     'default_logo' => PlatformSetting::getVal('default_login_logo'),
        //     'logo_url' => $instituteLogo,
        // ]);
        $coverPath = $configuration?->login_cover_image ?? PlatformSetting::getVal('default_login_cover');
        $loginCoverImage = $coverPath 
            ? asset('storage/' . ltrim($coverPath, '/')) 
            : asset('storage/images/default-school-login.jfif');
        $primaryColor =
            $configuration?->primary_color
            ?? PlatformSetting::getVal('default_primary_color')
            ?? '#166534';
        $secondaryColor =
            $configuration?->secondary_color
            ?? PlatformSetting::getVal('default_secondary_color')
            ?? '#84CC16';
        $activeLayout = $configuration?->login_layout ?? PlatformSetting::getVal('login_layout', 'layout_one');
        $viewName = ($activeLayout === 'layout_two') ? 'auth.login-two' : 'auth.institute-login';
        return view(
            $viewName,
            compact(
                'institute',
                'configuration',
                'instituteLogo',
                'loginCoverImage',
                'primaryColor',
                'secondaryColor'
            )
        );    
    }
}
