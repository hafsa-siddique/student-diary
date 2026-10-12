<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Institute;
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
        if ($configuration?->login_logo) {
            $instituteLogo = asset(
                'storage/' . $configuration->login_logo
            );
        } elseif ($configuration?->main_logo) {
            $instituteLogo = asset(
                'storage/' . $configuration->main_logo
            );
        } else {
            $instituteLogo = null;
        }
        if ($configuration?->login_cover_image) {
            $loginCoverImage = asset(
                'storage/' . $configuration->login_cover_image
            );

        } else {
            $loginCoverImage = asset(
                'storage/images/default-school-login.jfif'
            );
        }
        $primaryColor =
            $configuration?->primary_color
            ?? '#166534';
        $secondaryColor =
            $configuration?->secondary_color
            ?? '#84CC16';

        return view(
            'auth.institute-login',
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
