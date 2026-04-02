<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HotpatchApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    // ─── Web (session-based) auth ───

    public function webLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));
        $user->update(['last_login_at' => now()]);
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    public function webRegister(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'id'            => (string) Str::uuid(),
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
            'display_name'  => $request->name,
            'is_verified'   => false,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/dashboard');
    }

    public function webLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'name'     => 'required|string',
        ]);

        $user = User::create([
            'id'            => (string) Str::uuid(),
            'email'         => $request->email,
            'password_hash' => Hash::make($request->password),
            'display_name'  => $request->name,
            'is_verified'   => false,
            'verification_token' => Str::random(60),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user->update(['last_login_at' => now()]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function issueTokenFromApiKey(Request $request)
    {
        $request->validate(['api_key' => 'required|string']);
        
        $key = \App\Models\ApiKey::where('key_hash', hash('sha256', $request->api_key))->firstOrFail();
        $app = HotpatchApp::findOrFail($key->app_id);
        $user = User::findOrFail($app->owner_id);

        $token = $user->createToken('cli-access', ['*'], now()->addHours(2));

        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_in' => 7200,
            'app' => [
                'id' => $app->id,
                'name' => $app->name,
                'tier' => $app->tier,
            ],
        ]);
    }

    public function createApp(Request $request)
    {
        // Go implementation didn't require JWT for initial setup, but might require it.
        // If JWT required, add middleware.
        $request->validate([
            'name'     => 'required|string|unique:apps',
            'platform' => 'required|string|in:android,ios',
            'tier'     => 'nullable|string|in:free,pro,enterprise',
        ]);

        // If authenticated, use Auth::id()
        $owner_id = Auth::id() ?? $request->input('owner_id');

        if (!$owner_id) {
             return response()->json(['error' => 'Owner ID required or must be authenticated'], 400);
        }

        $app = HotpatchApp::create([
            'id'            => (string) Str::uuid(),
            'name'          => $request->name,
            'platform'      => $request->platform,
            'api_key'       => Str::random(32),
            'encryption_key'=> Str::random(32),
            'owner_id'      => $owner_id,
            'tier'          => $request->tier ?? 'free',
        ]);

        return response()->json($app, 201);
    }
}
