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
        <ul class="nav nav-tabs mb-5">
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
        <div class="row">
            <!-- #region Active process -->
            <div class="col">
                @if (isset($inactive) && $inactive)
                    <!-- Activation request -->
                    <form action="{{ route('active.two-factor') }}" method="post" autocomplete="off">
                        @csrf
                        <h3>Segundo factor de autenticación desactivado</h3>
                        <p>El segundo factor de autenticación aumenta considerablemente la seguridad de tu cuenta.</p>
                        <button class="btn btn-secondary px-4 py-2 mt-4" type="submit">Activar</button>
                    </form>
                @elseif (isset($user) && !$user->two_factor_confirmed_at)
                    <!-- Activation in process -->
                    <form action="{{ route('two-factor.verify') }}" method="post" autocomplete="off"
                        class="d-flex flex-column align-items-start">
                        @csrf
                        <h3>Habilitación en proceso</h3>
                        <p>Estás a punto de aumentar la seguridad de la cuenta.</p>
                        <img src="data:image/png;base64,{{ $qrImageBase64 }}" alt="QR Code">
                        <span class="my-3">Escanea el código con tu autenticador o ingresa el código para enlazar tu
                            dispositivo.</span>
                        <h4>Código Secreto</h4>
                        <p>{{ decrypt(auth()->user()->two_factor_secret) }}</p>

                        <span>Cuando tengas enlazado tu dispositivo, coloca el código para verificar que puedas
                            acceder.</span>
                        <input type="text" name="code" autofocus placeholder="Código de autenticación"
                            class="form-control bg-dark text-white border w-50 my-3">
                        @if ($errors->has('code'))
                            <div class="alert alert-danger">
                                {{ $errors->first('code') }}
                            </div>
                        @endif
                        <button class="btn btn-secondary px-4 py-2 mt-4" type="submit">Activar</button>
                    </form>
                @else
                    <!-- Desactive process -->
                    <form action="{{ route('destroy.two-factor') }}" method="post" autocomplete="off"
                        class="d-flex flex-column">
                        @csrf
                        @method('DELETE')
                        <h3>Segundo factor activado</h3>
                        <span class="my-4">Con este medida habilitada, tu cuenta estará más segura.</span>
                        <p>
                            Si deseas desactivar el segundo factor de autenticación solo debes de colocar tu contraseña y
                            hacer clic en desactivar.
                        </p>
                        <input type="password" name="password" autofocus placeholder="Contraseña actual"
                            class="form-control bg-dark text-white border w-50 my-3">
                        @if ($errors->has('password'))
                            <div class="alert alert-danger">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <button class="btn btn-secondary px-4 py-2" type="submit"
                            style="max-width: max-content;">Desactivar</button>
                    </form>
                @endif
            </div>
            <!-- #endregion -->

            <!-- #region Codes -->
            <div class="col">
                @if (isset($recoveryCodes) && !$user->two_factor_confirmed_at)
                    <h3 class="mb-3">Códigos secretos</h3>
                    <p>Como medida adicional, si alguna vez no tienes acceso a tu dispositivo, puedes ingresar uno de los
                        siguientes códigos para ingresar a tu cuenta.</p>
                    @if ($recoveryCodes && is_array($recoveryCodes))
                        <ul class="my-3">
                            @foreach ($recoveryCodes as $code)
                                <li class="fs-5">{{ $code }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="alert alert-warning" role="alert">
                        Toma en cuenta que cada código es de un único uso.
                    </div>
                @endif
            </div>
        </div>
        <!-- #endregion -->
    </div>
@endsection
