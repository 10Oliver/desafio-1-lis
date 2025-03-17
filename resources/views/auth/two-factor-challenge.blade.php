<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segundo factor de autenticación</title>
</head>
<body>
    <div class="">
        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf
            <label for="code">Código de autenticación</label>
            <input type="text" name="code" autofocus>
            <p>O usa un código de recuperación:</p>
            <input type="text" name="recovery_code">
            <button type="submit">Verificar</button>
        </form>
    </div>
</body>
</html>