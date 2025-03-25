@extends('layouts.app')

@section('content')
@if (session('success'))
        <div class="success-register-toast">
            Usuario actualizado
        </div>
    @endif
    <div class="container-fluid px-5 py-5 text-white">
        <!-- #region: Title section -->
        <div class="mb-5 ">
            <h1>Configuración de perfil</h1>
        </div>
        {{-- @if (isset($errors))
            $errors
        @endif --}}
        <!-- #endregion -->
        <ul class="nav nav-tabs">
            <li class="nav-item mx-1">
                <a class="nav-link bg-dark text-white border-bottom" href="{{ route('profile.index') }}">Datos de usuario</a>
            </li>
            <li class="nav-item mx-1">
                <a class="nav-link bg-dark text-white border-bottom" href="{{ route('profile.changePassword') }}">
                    Cambiar contraseña
                </a>
            </li>
            <li class="nav-item mx-1">
                <a href="{{ route('two-factor.settings') }}" class="nav-link bg-dark text-white border">
                    Segundo factor de autenticación
                </a>
            </li>
        </ul>

    @if (auth()->user()->two_factor_secret)
        <p>✅ La autenticación en dos pasos está activada.</p>

        <form action="{{ url('/user/two-factor-authentication') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">❌ Desactivar 2FA</button>
        </form>

        <h3>Código QR</h3>
        <img src="data:image/png;base64,{{ $qrImageBase64 }}" alt="QR Code">

        <h3>Código Secreto</h3>
        <p>{{ decrypt(auth()->user()->two_factor_secret) }}</p>

        <h3>Códigos de Recuperación</h3>
        @if ($recoveryCodes && is_array($recoveryCodes))
            <ul>
                @foreach($recoveryCodes as $code)
                    <li>{{ $code }}</li>
                @endforeach
            </ul>
        @else
            <p>No hay códigos de recuperación generados.</p>
        @endif
        <form action="{{ url('/user/two-factor-recovery-codes') }}" method="POST">
            @csrf
            <button type="submit">🔄 Regenerar códigos de recuperación</button>
        </form>
    @else
        <p>❌ No tienes activado el 2FA.</p>
        <form action="{{ url('/user/two-factor-authentication') }}" method="POST">
            @csrf
            <button type="submit">✅ Activar 2FA</button>
        </form>
    @endif
</div>
@endsection