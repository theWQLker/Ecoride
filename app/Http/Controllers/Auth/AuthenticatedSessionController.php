<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => trans('auth.failed')]);
        }

        $request->session()->regenerate();

        return redirect()->intended(match (Auth::user()->role) {
            'admin' => route('admin.dashboard'),
            'driver' => route('driver.dashboard'),
            'user' => route('user.dashboard'),
            default => route('login'), // Prevents unknown users from getting stuck
        });
    }
}
