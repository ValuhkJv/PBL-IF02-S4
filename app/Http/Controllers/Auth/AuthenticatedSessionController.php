<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();
        $redirectUrl = RouteServiceProvider::HOME; // Default redirect untuk customer

        // Pastikan user memiliki relasi 'role' untuk menghindari error
        if ($user->role) {
            switch ($user->role->role_name) {
                case 'admin':
                    // Gunakan named route untuk admin
                    $redirectUrl = route('admin.dashboard_admin');
                    break;
                case 'courier':
                    // Gunakan named route untuk kurir
                    $redirectUrl = route('kurir.dashboard');
                    break;
                case 'customer':
                    // Gunakan named route untuk customer (sesuai default)
                    $redirectUrl = route('dashboard');
                    break;
            }
        }

        return redirect()->intended($redirectUrl);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
