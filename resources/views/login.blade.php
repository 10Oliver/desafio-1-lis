<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    @if (session('success'))
        <div class="success-register-toast">
            ¡Registro completado!
        </div>
    @endif

    <div class="login-container">
        <div class="shadow"></div>
        <div class="login-form">
            <h4 class="login-title">Inicio de sesión</h4>
            <form action="{{ route('login.process') }}" method="POST" autocomplete="off">
                @csrf
                <div class="input-field email-input-field">
                    <input type="email" id="email" name="email" required placeholder="Usuario">
                    <div class="first-border"></div>
                    <div class="last-border"></div>
                    <label for="email">Usuario</label>
                    <span class="material-symbols-outlined">
                        account_circle
                    </span>
                </div>
                <div class="input-field password-input-field">
                    <input type="password" id="password" name="password" required placeholder="Contraseña">
                    <div class="first-border"></div>
                    <div class="last-border"></div>
                    <label for="password">Contraseña</label>
                    <span class="material-symbols-outlined">
                        lock
                    </span>
                </div>
                <div class="error-message">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    @endif
                </div>
                <button type="submit" class="submit-button">Iniciar sesión</button>
                <div class="register-text">
                    <p>¿Aún no tienes cuenta?</p>
                    <a href="{{ route('register') }}">Registrate</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
