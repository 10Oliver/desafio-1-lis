<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h2>Autenticación en dos pasos</h2>

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
</body>

</html>
