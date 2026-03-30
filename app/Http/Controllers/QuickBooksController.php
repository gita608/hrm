<?php

namespace App\Http\Controllers;

use App\Services\QuickBooksService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuickBooksController extends Controller
{
    protected $qbService;

    public function __construct(QuickBooksService $qbService)
    {
        $this->qbService = $qbService;
    }

    public function index()
    {
        $quickbooksClientId = \App\Helpers\SettingsHelper::get('quickbooks_client_id');
        $quickbooksClientSecret = \App\Helpers\SettingsHelper::get('quickbooks_client_secret');
        $isQuickBooksConnected = $this->qbService->isConnected();
        
        return view('pages.quickbooks.index', compact(
            'quickbooksClientId', 
            'quickbooksClientSecret', 
            'isQuickBooksConnected'
        ));
    }

    public function connect()
    {
        return redirect()->away($this->qbService->getAuthorizationUrl());
    }

    public function callback(Request $request)
    {
        $code = $request->query('code');
        $state = $request->query('state');
        $realmId = $request->query('realmId');

        if (!$code || $state !== session('qb_state')) {
            return redirect()->route('settings.index')->with('error', 'QuickBooks connection failed: Invalid state or code.');
        }

        if ($this->qbService->exchangeCodeForToken($code)) {
            return redirect()->route('settings.index')->with('success', 'Successfully connected to QuickBooks!');
        }

        return redirect()->route('settings.index')->with('error', 'Failed to connect to QuickBooks. Please check your credentials.');
    }

    public function disconnect()
    {
        $this->qbService->disconnect();
        return redirect()->route('settings.index')->with('success', 'Disconnected from QuickBooks.');
    }
}
