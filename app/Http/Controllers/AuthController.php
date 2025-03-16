<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function showRegister()
    {
        $response = Http::get('https://restcountries.com/v3.1/all', [
            'fields' => 'translations,cca3'
        ]);

        if ($response->successful()) {
            $countries = $response->json();

            $result = array_map(function ($country) {
                return [
                    'name' => $country['translations']['spa']['common'] ?? $country['cca3'],
                    'id'   => $country['cca3'] ?? null,
                ];
            }, $countries);

            return view('register', ['countries' => $result]);
        }
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        unset($data['nacionality']);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $countryId = $data['country_data'];
        // Get country json
        $response = Http::get("https://restcountries.com/v3.1/alpha/{$countryId}", []);

        if ($response->successful()) {
            $country = $response->json()[0];

            $countryData = [
                'name' => $country['translations']['spa']['common'] ?? null,
                'code' => $country['cca3'] ?? null,
                'flag' => $country['flags']['svg'] ?? $country['flags']['png'] ?? null,
            ];

            $data['country_data'] = json_encode($countryData);
        }

        $data = array_filter($data, fn($value) => $value !== '');
        User::create($data);

        return redirect()->route('login')->with('success', 'Usuario registrado exitosamente. ¡Inicia sesión!');
    }
}
