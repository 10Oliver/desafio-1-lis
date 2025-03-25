@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="success-register-toast">
            Contraseña cambiada con éxito
        </div>
    @endif
    <div class="container-fluid px-5 py-5 text-white">
        <!-- #region: Title section -->
        <div class="mb-5 ">
            <h1>Configuración de perfil</h1>
        </div>
        <!-- #endregion -->
        <ul class="nav nav-tabs">
            <li class="nav-item mx-1">
                <a class="nav-link bg-dark text-white border-bottom" href="{{ route('profile.index') }}">Datos de usuario</a>
            </li>
            <li class="nav-item mx-1">
                <a class="nav-link bg-dark text-white border" href="{{ route('profile.changePassword') }}">
                    Cambiar contraseña
                </a>
            </li>
            <li class="nav-item mx-1">
                <a href="{{ route('two-factor.settings') }}" class="nav-link bg-dark text-white border-bottom">
                    Segundo factor de autenticación
                </a>
            </li>
        </ul>

        <!-- #region Change password -->
        <form action="{{ route('profile.changePassword') }}" method="POST" autocomplete="off"
            class="mt-5 mb-3 d-flex flex-column align-items-center w-25">
            @csrf
            <h3 class="mb-5">Cambio de contraseña</h3>
            <div class="mb-3">
                <label for="old_password" class="form-label">Contraseña actual:</label>
                <input type="password" name="old_password" id="old_password" required
                    class="form-control bg-dark text-white border border-secondary">
                @if ($errors->has('old_password'))
                    <ul class="mt-3">
                        @foreach ($errors->get('old_password') as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña:</label>
                <input type="password" name="password" id="password" required
                    class="form-control bg-dark text-white border border-secondary">
                @if ($errors->has('password'))
                    <ul class="mt-3">
                        @foreach ($errors->get('password') as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="form-control bg-dark text-white border border-secondary">
            </div>
            <button type="submit" class="btn btn-secondary px-4 py-2 mt-4" style="max-width: max-content">
                Actualizar
            </button>
        </form>
        <!-- #endregion -->
    </div>
    <style>
        .success-register-toast {
            position: fixed;
            top: 5%;
            right: 20px;
            background-color: #2f3569;
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #cfd0f3;
            color: #cfd0f3;
            animation: fade-out 5s forwards;
        }

        @keyframes fade-out {
            0% {
                opacity: 1;
            }

            85% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                display: none;
            }
        }
    </style>
@endsection
