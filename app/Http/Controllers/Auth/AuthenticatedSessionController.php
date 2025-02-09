<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login form.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request): View
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required'],
        ]);

        if (!\Illuminate\Support\Facades\Auth::attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            return back()->withErrors(['email' => trans('auth.failed')]);
        }

        $request->session()->regenerate();

        return redirect()->intended(match (\Illuminate\Support\Facades\Auth::user()->role) {
            'admin'  => route('admin.dashboard'),
            'driver' => route('driver.dashboard'),
            'user'   => route('user.dashboard'),
            default  => route('dashboard'),
        });
    }

    /**
     * Handle a logout request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
