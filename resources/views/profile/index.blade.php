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
                <a class="nav-link bg-dark text-white border" href="{{ route('profile.index') }}">Datos de usuario</a>
            </li>
            <li class="nav-item mx-1">
                <a class="nav-link bg-dark text-white border-bottom" href="{{ route('profile.changePassword') }}">
                    Cambiar contraseña
                </a>
            </li>
            <li class="nav-item mx-1">
                <a href="{{ route('two-factor.settings') }}" class="nav-link bg-dark text-white border-bottom">
                    Segundo factor de autenticación
                </a>
            </li>
        </ul>
        <form action="{{ route('profile.edit') }}" method="POST" autocomplete="off" class="mt-5 mb-3 row">
            @csrf
            <div class="col-6">
                <h3 class="mb-5">Información personal</h3>
                <div class="row mb-3">
                    <div class="col">
                        <label for="first_name" class="form-label">Primer nombre:</label>
                        <input type="text" name="first_name" id="first_name" {{ isset($edit) ? '' : 'disabled' }}
                            class="form-control bg-dark text-white border border-secondary" value="{{ $user->first_name }}">
                    </div>
                    <div class="col">
                        <label for="second_name" class="form-label">Segundo nombre:</label>
                        <input type="text" name="second_name" id="second_name" {{ isset($edit) ? '' : 'disabled' }}
                            class="form-control bg-dark text-white border border-secondary"
                            value="{{ $user->second_name }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="lastname" class="form-label">Primer apellido:</label>
                        <input type="text" name="lastname" id="lastname" {{ isset($edit) ? '' : 'disabled' }}
                            class="form-control bg-dark text-white border border-secondary" value="{{ $user->lastname }}">
                    </div>
                    <div class="col">
                        <label for="second_lastname" class="form-label">Segundo apellido:</label>
                        <input type="text" name="second_lastname" id="second_lastname"
                            {{ isset($edit) ? '' : 'disabled' }}
                            class="form-control bg-dark text-white border border-secondary"
                            value="{{ $user->second_lastname }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="phone" class="form-label">Teléfono:</label>
                        <input type="tel" name="phone" id="phone" {{ isset($edit) ? '' : 'disabled' }}
                            class="form-control bg-dark text-white border border-secondary" value="{{ $user->phone }}">
                    </div>
                    <div class="col">
                        <label for="email" class="form-label">Correo:</label>
                        <input type="text" name="email" id="email" {{ isset($edit) ? '' : 'disabled' }}
                            class="form-control bg-dark text-white border border-secondary" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-evenly">
                    @if (isset($edit))
                    <a href="{{ route('profile.index') }}" class="btn btn-secondary px-4">Cancelar</a>
                        <button type="submit" class="btn btn-secondary px-4">Guardar</button>
                    @else
                        <a href="{{ route('profile.edit') }}" class="btn btn-secondary px-4">Habilitar</a>
                    @endif
                </div>
            </div>
        </form>
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
            animation: fade-out 10s forwards;
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
