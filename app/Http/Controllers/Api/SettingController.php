<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = WebSetting::first();
        if ($setting && $setting->logo_web) {
            $setting->logo_web = asset('storage/' . $setting->logo_web);
        }
        return response()->json($setting);
    }

}
