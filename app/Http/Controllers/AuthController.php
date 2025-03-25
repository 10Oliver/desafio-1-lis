<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterSecondStepRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Controllers\redirect;
use App\Http\Requests\RegisterFirstStepRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            if (!empty($user->getRawOriginal('two_factor_secret'))) {
                $request->session()->put('login.id', $user->getAuthIdentifier());
                return redirect()->route('two-factor.login');
            }
            Auth::login($user);
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

    public function checkFirstStep(RegisterFirstStepRequest $request)
    {
        return response()->json([
            'step' => 2,
            'route' => route('register.second')
        ]);
    }

    public function checkSecondStep(RegisterSecondStepRequest $request)
    {
        return response()->json([
            'step' => 3,
            'route' => route('register.process')
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        unset($data['nacionality']);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        if (isset($data['country_data'])) {
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
        }

        $data = array_filter($data, fn($value) => $value !== '');
        User::create($data);

        session()->flash('success', '¡Registro exitoso!');

        return redirect()->route('login');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
