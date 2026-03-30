<?php

namespace App\Services;

use App\Helpers\SettingsHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class QuickBooksService
{
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;
    protected $baseUrl;
    protected $tokenUrl;

    public function __construct()
    {
        $this->clientId = SettingsHelper::get('quickbooks_client_id') ?: config('quickbooks.client_id');
        $this->clientSecret = SettingsHelper::get('quickbooks_client_secret') ?: config('quickbooks.client_secret');
        $this->redirectUri = config('quickbooks.redirect_uri');
        $this->baseUrl = config('quickbooks.baseUrl');
        $this->tokenUrl = config('quickbooks.tokenUrl');
    }

    public function getAuthorizationUrl()
    {
        $state = bin2hex(random_bytes(16));
        session(['qb_state' => $state]);

        $query = http_build_query([
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'scope' => config('quickbooks.scope'),
            'redirect_uri' => $this->redirectUri,
            'state' => $state,
        ]);

        return $this->baseUrl . '?' . $query;
    }

    public function exchangeCodeForToken($code)
    {
        $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)
            ->post($this->tokenUrl, [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $this->redirectUri,
            ]);

        if ($response->successful()) {
            $this->storeTokens($response->json());
            return true;
        }

        Log::error('QuickBooks Token Exchange Failed', ['response' => $response->body()]);
        return false;
    }

    public function refreshAccessToken()
    {
        $refreshToken = SettingsHelper::get('quickbooks_refresh_token');

        if (!$refreshToken) {
            return false;
        }

        $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)
            ->post($this->tokenUrl, [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
            ]);

        if ($response->successful()) {
            $this->storeTokens($response->json());
            return true;
        }

        Log::error('QuickBooks Token Refresh Failed', ['response' => $response->body()]);
        return false;
    }

    protected function storeTokens(array $data)
    {
        // We use the settings table to store tokens for simplicity in this application
        $tokens = [
            'quickbooks_access_token' => $data['access_token'],
            'quickbooks_refresh_token' => $data['refresh_token'],
            'quickbooks_access_token_expires_at' => now()->addSeconds($data['expires_in'])->toDateTimeString(),
            'quickbooks_refresh_token_expires_at' => now()->addSeconds($data['x_refresh_token_expires_in'])->toDateTimeString(),
            'quickbooks_realm_id' => $data['realmId'] ?? SettingsHelper::get('quickbooks_realm_id'),
        ];

        foreach ($tokens as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }

        SettingsHelper::clearCache();
    }

    public function isConnected()
    {
        return !empty(SettingsHelper::get('quickbooks_access_token'));
    }

    public function disconnect()
    {
        $keys = [
            'quickbooks_access_token',
            'quickbooks_refresh_token',
            'quickbooks_access_token_expires_at',
            'quickbooks_refresh_token_expires_at',
            'quickbooks_realm_id'
        ];

        DB::table('settings')->whereIn('key', $keys)->delete();
        SettingsHelper::clearCache();
    }
}
