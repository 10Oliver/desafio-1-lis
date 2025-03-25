<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use PragmaRX\Google2FA\Google2FA;
use Laravel\Fortify\Http\Requests\TwoFactorLoginRequest;

class TwoFactorVerificationController extends TwoFactorAuthenticatedSessionController
{
    public function save(TwoFactorLoginRequest $request)
    {
        $user = $request->user();
        $google2fa = new Google2FA();

        // Verifica el código ingresado contra el secreto almacenado del usuario
        if ($google2fa->verifyKey(decrypt($user->two_factor_secret), $request->code)) {
            // Si es válido, actualiza el campo two_factor_confirmed_at si es necesario
            $user->forceFill([
                'two_factor_confirmed_at' => now(),
            ])->save();

            return view('auth.two-factor-settings');
        } else {
            // Si es incorrecto, redirige a la vista de configuración con error
            return redirect()->route('two-factor.settings')
                ->withErrors(['code' => 'El código ingresado es incorrecto. Inténtalo de nuevo.']);
        }
    }
}
