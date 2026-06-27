<?php

namespace App\Http\Controllers;

use App\Mail\TwoFactorMail;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PavSolController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Conta criada com sucesso! Faça seu login.');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Password is valid; issue a short-lived email code before starting the session.
            $code = rand(100000, 999999);
            $user->two_factor_code = $code;
            $user->two_factor_expires_at = Carbon::now()->addMinutes(10);
            $user->save();

            try {
                Mail::to($user->email)->send(new TwoFactorMail($code));
            } catch (\Exception $e) {
                return back()->withErrors(['email' => 'Erro no envio de email: ' . $e->getMessage()]);
            }

            return redirect()->route('verify')->with('user_id', $user->id);
        }

        return back()->withErrors(['email' => 'Dados incorretos.']);
    }

    public function showVerify()
    {
        if (! session('user_id')) {
            return redirect()->route('login');
        }

        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $user = User::find($request->user_id);

        if ($user && $user->two_factor_code == $request->code && $user->two_factor_expires_at->gt(Carbon::now())) {
            // Clear the one-time code as soon as it has opened the authenticated session.
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->save();

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Login realizado com sucesso! Bem-vindo.');
        }

        return back()->withErrors(['code' => 'Código inválido ou expirado.'])->with('user_id', $request->user_id);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Você saiu do sistema com segurança.');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function about()
    {
        return view('about');
    }

    public function listFavorites()
    {
        $stores = Store::where('user_id', Auth::id())->get();

        return view('favorites', compact('stores'));
    }

    public function saveFavorite(Request $request)
    {
        // Favorites are keyed by user and map coordinates to avoid duplicate saved stores.
        $exists = Store::where('user_id', Auth::id())
            ->where('latitude', $request->lat)
            ->where('longitude', $request->lng)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Loja já está nos favoritos!'], 409);
        }

        Store::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->lat,
            'longitude' => $request->lng,
            'phone' => $request->phone,
        ]);

        return response()->json(['success' => true]);
    }

    public function deleteFavorite($id)
    {
        Store::where('id', $id)->where('user_id', Auth::id())->delete();

        return back()->with('success', 'Fornecedor removido da sua lista!');
    }
}
