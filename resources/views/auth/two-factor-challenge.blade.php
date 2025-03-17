<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segundo factor de autenticación</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="m-0 p-0 register-background">
    <main class="w-screen h-screen relative flex justify-center items-center m-0 p-0">
        <div
            class="w-[600px] flex flex-col gap-y-5 items-center p-10 border-white border-[1px] shadow-[0px_0px_5px_rgba(255,255,255,1)] rounded-[10px]">
            <h2 class="text-3xl font-bold text-[#cfd0f3]">Autenticación de dos factores</h2>
            <p class="text-[#cfd0f3] w-[90%] text-lg">
                Tu cuenta tiene activada la autenticación de dos factores, por favor ingresa el
                código generado en tu aplicación.
            </p>
            <form method="POST" action="{{ route('two-factor.login') }}" autocomplete="off"
                class="text-[#cfd0f3] text-center">
                @csrf
                <div class="relative my-2.5 mx-0 box-border">
                    <input type="text" name="code" autofocus
                        class="relative w-full h-full top-0 left-0 right-0 bottom-0 border-b-[1px] border-r-[1px] border-l-[1px] border-[#cfd0f3] rounded-[15px] outline-0 pl-[35px] pr-[18px] py-2.5">
                    <label for="code"
                        class="absolute top-1/2 -translate-y-1/2 left-[35px]">
                        Código de autenticación
                    </label>
                    <div class="border-l-[1px] border-t-[1px] border-b-0 border-r-0 border-[#cfd0f3] absolute h-[calc(100%-2px)] w-[14px] top-0 rounded-t-[15px] rounded-l-[15px]"></div>
                    {{-- <div class="last-border"></div> --}}
                   {{--  <span class="material-symbols-outlined">
                        pin
                    </span> --}}
                </div>
                <input type="checkbox" name="recuperation-code" id="recuperation-code">
                <p>O usa un código de recuperación:</p>
                <input type="text" name="recovery_code">
                <button type="submit">Verificar</button>
            </form>
        </div>
    </main>
</body>

</html>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap");

    .register-background {
        background-image: url("./resources/images/two-factor-wallpaper.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
