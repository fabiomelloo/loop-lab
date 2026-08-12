<?php

namespace App\Http\Controllers;

use App\Models\Learner;
use App\Models\User;
use App\Services\ProgressService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function form(string $mode = 'login'): View
    {
        abort_unless(in_array($mode, ['login', 'cadastro']), 404);

        return view('auth', compact('mode'));
    }

    public function register(Request $request, ProgressService $progress): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'max:60'], 'email' => ['required', 'email', 'unique:users'], 'password' => ['required', 'confirmed', Password::min(8)]]);
        $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => Hash::make($data['password'])]);
        Auth::login($user);
        $progress->learner()->update(['user_id' => $user->id, 'display_name' => $user->name]);

        return redirect()->route('dashboard');
    }

    public function login(Request $request, ProgressService $progress): RedirectResponse
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);
        if (! Auth::attempt($credentials, true)) {
            return back()->withErrors(['email' => 'E-mail ou senha incorretos.'])->onlyInput('email');
        }
        $request->session()->regenerate();
        $existing = Learner::where('user_id', Auth::id())->first();
        if ($existing) {
            session()->put('learner_key', $existing->learner_key);
        } else {
            $progress->learner()->update(['user_id' => Auth::id(), 'display_name' => Auth::user()->name]);
        }

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard');
    }
}
