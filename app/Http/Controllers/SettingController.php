<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $title = "Settings";
        $settings = Setting::pluck('value', 'key');
        return view('setting.index', compact('title', 'settings'));
    }

    /**
     * Update the settings in storage.
     */
    public function update(Request $request)
    {
        // field text biasa
        $data = $request->except(['_token', '_method', 'app_logo', 'app_favicon']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // handle upload logo
        if ($request->hasFile('app_logo')) {
            $oldLogo = Setting::where('key', 'app_logo')->value('value');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('app_logo')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'app_logo'], ['value' => $path]);
        }

        // handle upload favicon
        if ($request->hasFile('app_favicon')) {
            $oldFavicon = Setting::where('key', 'app_favicon')->value('value');
            if ($oldFavicon) {
                Storage::disk('public')->delete($oldFavicon);
            }
            $path = $request->file('app_favicon')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'app_favicon'], ['value' => $path]);
        }

        return redirect()->to('setting')->with('success', 'Setting updated successfully');
    }
}
