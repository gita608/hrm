<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\SettingsHelper;
use App\Helpers\ImageHelper;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $appName = SettingsHelper::get('app_name', config('app.name', 'SmartHR'));
        $appLogo = SettingsHelper::get('app_logo');

        return view('pages.settings.index', compact('appName', 'appLogo'));
    }

    /**
     * Update settings.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update app name
        DB::table('settings')->updateOrInsert(
            ['key' => 'app_name'],
            ['value' => $validated['app_name'], 'updated_at' => now()]
        );

        // Handle logo upload
        if ($request->hasFile('app_logo')) {
            // Delete old logo if exists
            $oldLogo = DB::table('settings')->where('key', 'app_logo')->value('value');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Store new logo
            $logoPath = $request->file('app_logo')->store('logos', 'public');
            
            // Process image: remove background and convert to PNG
            try {
                $processedPath = ImageHelper::removeWhiteBackground($logoPath);
                $logoPath = $processedPath;
            } catch (\Exception $e) {
                // If processing fails, use original
                // Log error if needed: \Log::error('Logo processing failed: ' . $e->getMessage());
            }
            
            DB::table('settings')->updateOrInsert(
                ['key' => 'app_logo'],
                ['value' => $logoPath, 'updated_at' => now()]
            );
        }

        // Clear settings cache
        SettingsHelper::clearCache();

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
