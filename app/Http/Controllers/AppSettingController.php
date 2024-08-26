<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    public function index()
    {
        $appSettings = AppSetting::all();
        return response()->json($appSettings);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'key' => 'required|string|unique:app_settings,key',
            'value' => 'required|string',
            'type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $appSetting = AppSetting::create($validatedData);
        return response()->json($appSetting, 201);
    }

    public function show(AppSetting $appSetting)
    {
        return response()->json($appSetting);
    }

    public function update(Request $request, AppSetting $appSetting)
    {
        $validatedData = $request->validate([
            'value' => 'required|string',
            'type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $appSetting->update($validatedData);
        return response()->json($appSetting);
    }

    public function destroy(AppSetting $appSetting)
    {
        $appSetting->delete();
        return response()->json(null, 204);
    }
}
