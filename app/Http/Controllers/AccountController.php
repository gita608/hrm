<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display the account page.
     */
    public function index()
    {
        return view('pages.account.index');
    }

    /**
     * Deactivate the user's account.
     */
    public function deactivate(Request $request)
    {
        // In a real application, you would add an 'is_active' or 'deactivated_at' field
        // For now, we'll just return a message
        return redirect()->route('account.index')->with('success', 'Account deactivation feature will be implemented soon.');
    }

    /**
     * Delete the user's account.
     */
    public function delete(Request $request)
    {
        // In a real application, you would soft delete or permanently delete the account
        // For now, we'll just return a message
        return redirect()->route('account.index')->with('success', 'Account deletion feature will be implemented soon.');
    }
}
