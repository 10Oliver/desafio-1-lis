<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Controllers\redirect;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = new UserResource(Auth::user());
        return view('profile.index', compact('user'));
    }

    public function editIndex()
    {
        $user = new UserResource(Auth::user());
        $edit = true;
        return view('profile.index', compact('user', 'edit'));
    }

    public function showPasswordView()
    {
        return view('profile.change-password');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->flash('success', 'Contraseña actualizada');
        return view('profile.change-password');
    }

    public function active2FA()
    {
        $user = Auth::user();
        $user->refresh();

        $google2fa = new Google2FA();

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->two_factor_secret
        );

        $qrCode = new QrCode($qrCodeUrl);
        $writer = new PngWriter();

        $qrImage = $writer->write($qrCode);
        $qrImageBase64 = base64_encode($qrImage->getString());

        $recoveryCodes = null;
        if (isset($user->two_factor_recovery_codes)) {
            $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
        }

        return view('auth.two-factor-settings', compact('qrImageBase64', 'recoveryCodes'));
    }

    public function updateUserData(UpdateUserRequest $request)
    {
        $user = Auth::user();

        $user->update($request->all());

        session()->flash('success', '¡Usuario actualizado!');

        $user->refresh();

        return view('profile.index', compact('user'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
