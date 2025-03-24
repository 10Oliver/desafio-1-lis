@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5 py-5 text-white">
        <!-- #region: Title section -->
        <div class="mb-5 ">
            <h1>Configuración de perfil</h1>
        </div>
        <!-- #endregion -->
        <ul class="nav nav-tabs">
            <li class="nav-item mx-1">
                <a class="nav-link bg-dark text-white border-bottom"
                    href="{{ route('profile.index') }}">Datos de usuario</a>
            </li>
            <li class="nav-item mx-1">
                <a class="nav-link bg-dark text-white border"
                    href="{{ route('profile.changePassword') }}">
                    Cambiar contraseña
                </a>
            </li>
            <li class="nav-item mx-1">
                <a href="{{ route('profile.twoFactor') }}"
                    class="nav-link bg-dark text-white border-bottom">
                    Segundo factor de autenticación
                </a>
            </li>
        </ul>
    </div>
@endsection
