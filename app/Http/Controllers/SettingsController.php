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
        $appLogoSmall = SettingsHelper::get('app_logo_small');

        $quickbooksClientId = SettingsHelper::get('quickbooks_client_id');
        $quickbooksClientSecret = SettingsHelper::get('quickbooks_client_secret');
        $isQuickBooksConnected = !empty(SettingsHelper::get('quickbooks_access_token'));

        return view('pages.settings.index', compact(
            'appName', 
            'appLogo', 
            'appLogoSmall', 
            'quickbooksClientId', 
            'quickbooksClientSecret', 
            'isQuickBooksConnected'
        ));
    }

    /**
     * Update settings.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'app_logo_small' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'quickbooks_client_id' => 'nullable|string|max:255',
            'quickbooks_client_secret' => 'nullable|string|max:255',
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
            }
            
            DB::table('settings')->updateOrInsert(
                ['key' => 'app_logo'],
                ['value' => $logoPath, 'updated_at' => now()]
            );
        }

        // Handle small logo upload
        if ($request->hasFile('app_logo_small')) {
            // Delete old small logo if exists
            $oldSmallLogo = DB::table('settings')->where('key', 'app_logo_small')->value('value');
            if ($oldSmallLogo && Storage::disk('public')->exists($oldSmallLogo)) {
                Storage::disk('public')->delete($oldSmallLogo);
            }

            // Store new small logo
            $smallLogoPath = $request->file('app_logo_small')->store('logos', 'public');
            
            // Process image: remove background and convert to PNG
            try {
                $processedPath = ImageHelper::removeWhiteBackground($smallLogoPath);
                $smallLogoPath = $processedPath;
            } catch (\Exception $e) {
                // If processing fails, use original
            }
            
            DB::table('settings')->updateOrInsert(
                ['key' => 'app_logo_small'],
                ['value' => $smallLogoPath, 'updated_at' => now()]
            );
        }

        // Update QuickBooks Credentials
        if ($request->has('quickbooks_client_id')) {
            DB::table('settings')->updateOrInsert(
                ['key' => 'quickbooks_client_id'],
                ['value' => $validated['quickbooks_client_id'], 'updated_at' => now()]
            );
        }

        if ($request->has('quickbooks_client_secret')) {
            DB::table('settings')->updateOrInsert(
                ['key' => 'quickbooks_client_secret'],
                ['value' => $validated['quickbooks_client_secret'], 'updated_at' => now()]
            );
        }

        // Clear settings cache
        SettingsHelper::clearCache();

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
