<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segundo factor de autenticación</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ asset('css/two-factor.css') }}">
</head>

<body class="m-0 p-0 h-screen">
    @if ($errors->any())
        <div
            class="fixed top-[5%] right-5 bg-[#2f3569] rounded-[10px] border-[1px] border-[#cfd0f3] text-[#cfd0f3] z-50 py-2.5 px-4 fade-out-animation">
            <ul>
                @if ($errors->has('code'))
                    <li>El código es inválido</li>
                @endif
                @foreach ($errors->all() as $error)
                    @if (!$errors->has('code') || $error !== $errors->first('code'))
                        <li>{{ $error }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
    <div class="register-background absolute z-[1] w-full h-screen"></div>
    <main class="w-screen h-full md:h-screen relative flex justify-center items-center m-0 p-0 z-[2]">
        <div
            class="w-[90vw] md:w-[600px] flex flex-col gap-y-5 items-center px-8 py-6 md:p-10 border-white border-[1px] relative shadow-[0px_0px_5px_rgba(255,255,255,1)] rounded-[10px]">
            <a
                href="{{ route('login') }}"
                class="absolute top-10 left-7 text-[#aaabd1] z-[3] h-9 w-9 rounded-full before:transition-all before:duration-500 before:ease-in-out after:transition-all after:duration-500 after:ease-in-out before:absolute before:w-full before:h-full before:top-1/2 before:-translate-y-1/2 before:left-1/2 before:-translate-x-1/2 before:border-2 before:border-[#343550] before:rounded-full before:pointer-events-none after:opacity-0 after:absolute after:scale-150 after:w-full after:h-full after:border-2 after:border-[#cfd0f3] after:rounded-full after:top-1/2 after:-translate-y-1/2 after:left-1/2 after:-translate-x-1/2 after:pointer-events-none hover:before:scale-[20%] hover:before:opacity-0 hover:after:scale-100 hover:after:opacity-100 hover:cursor-pointer hover:text-white transition-all duration-500 ease-in-out">
                <span class="material-symbols-outlined absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2">
                    arrow_back
                </span>
            </a>

            <div class="absolute w-full h-full bg-[#ffffff10] top-0 bottom-0 left-0 right-0"></div>
            <h2 class="text-3xl font-bold text-[#cfd0f3] text-center z-[3]">Autenticación de dos factores</h2>
            <p class="text-[#cfd0f3] w-[90%] text-lg text-center">
                La autenticación en dos pasos está activada en tu cuenta. Usa el código de tu autenticador para
                continuar.
            </p>
            <form method="POST" action="{{ route('two-factor.login') }}" autocomplete="off"
                class="text-[#cfd0f3] text-center flex flex-col items-center w-[80%]">
                @csrf
                <div class="relative">
                    <div id="authentication-field"
                        class="relative my-2.5 mx-0 box-border max-w-[300px] z-[3] transition-all duration-500 ease-in-out input-field authentication-field">
                        <input type="number" name="code" autofocus placeholder="Código de autenticación"
                            class="rounded-[15px] border-t-0 border-b border-l border-r border-solid border-[#cfd0f3] px-[18px] py-[10px] pr-[35px] w-full text-[#cfd0f3] bg-transparent outline-none z-2 relative placeholder:invisible placeholder:text-transparent appearance-none peer">

                        <label for="code"
                            class="absolute top-1/2 -translate-y-1/2 left-[18px] transition-all duration-300 ease-in">
                            Código de autenticación
                        </label>
                        <div
                            class="absolute h-[calc(100%-2px)] w-[14px] left-0 top-0 border-t border-l border-b-0 border-r-0 border-solid border-[#cfd0f3] rounded-[15px_0_0_15px]">
                        </div>
                        <div
                            class="absolute h-[calc(100%-2px)] w-[calc(100%-14px)] right-0 top-0 border-t border-r border-b-0 border-l-0 border-solid border-[#cfd0f3] rounded-[0_15px_15px_0] transition-all duration-300 ease-in-out last-border">
                        </div>
                        <span
                            class="material-symbols-outlined absolute -translate-y-1/2 top-1/2 right-2.5 text-[#cfd0f3] text-[22px]">
                            pin
                        </span>
                    </div>
                    <div style="opacity: 0;" id="recuperation-field"
                        class="absolute top-0 my-2.5 mx-0 box-border max-w-[300px] transition-all duration-500 ease-in-out input-field verification-field">
                        <input type="text" name="recovery_code" autofocus placeholder="Código de verificación"
                            class="rounded-[15px] border-t-0 border-b border-l border-r border-solid border-[#cfd0f3] px-[18px] py-[10px] pr-[35px] w-full text-[#cfd0f3] bg-transparent outline-none z-2 relative placeholder:invisible placeholder:text-transparent appearance-none peer">

                        <label for="recovery_code"
                            class="absolute top-1/2 -translate-y-1/2 left-[18px] peer-focus:top-0 peer-focus:text-xs peer-focus:text-white transition-all duration-300 ease-in">
                            Código de verificación
                        </label>
                        <div
                            class="absolute h-[calc(100%-2px)] w-[14px] left-0 top-0 border-t border-l border-b-0 border-r-0 border-solid border-[#cfd0f3] rounded-[15px_0_0_15px]">
                        </div>
                        <div
                            class="absolute h-[calc(100%-2px)] w-[calc(100%-14px)] right-0 top-0 border-t border-r border-b-0 border-l-0 border-solid border-[#cfd0f3] rounded-[0_15px_15px_0] transition-all duration-300 ease-in-out last-border">
                        </div>
                        <span
                            class="material-symbols-outlined absolute -translate-y-1/2 top-1/2 right-2.5 text-[#cfd0f3] text-[22px]">
                            vpn_key
                        </span>
                    </div>
                </div>
                <hr class="w-full mt-10 mb-5 border-b-[#cfd0f3]">
                <h6 class="font-medium">¿Tienes problemas con tu autenticador?</h6>
                <span class="my-2">Puedes usar uno de tus códigos de verificación (cada código solo puede usarse una
                    vez)</span>
                <div
                    class="relative py-1 w-[120px] grid grid-cols-2 place-items-center place-content-center font-semibold rounded-full border-[1px] border-[#cfd0f3] overflow-hidden hover:cursor-pointer">
                    <input type="checkbox" name="recuperation-code" id="recuperation-code"
                        class="absolute top-0 bottom-0 left-0 right-0 w-full h-full opacity-0 peer z-[10]">
                    <div
                        class="w-1/2 h-full absolute bg-[#cfd0f3] top-0 bottom-0 left-0 z-[1] peer-checked:left-1/2 transition-all duration-300 ease-in-out rounded-l-full peer-checked:rounded-r-full peer-checked:rounded-l-none">
                    </div>
                    <span
                        class="text-black peer-checked:text-[#cfd0f3] z-[3] transition-all duration-300 ease-in-out">No</span>
                    <span
                        class="text-[#cfd0f3] peer-checked:text-black z-[3] transition-all duration-300 ease-in-out">Si</span>
                </div>
                <button type="submit"
                    class="relative mt-5 transition-all duration-300 ease-in-out shadow-[0px_10px_20px_rgba(0,0,0,0.2)] py-2.5 px-7 rounded-full flex items-center justify-center text-white gap-[10px] font-bold border-[1px] border-[#cfd0f3] outline-none overflow-hidden text-[15px] cursor-pointer hover:scale-105 hover:border-[#9d9ec6] before:absolute before:w-[100px] before:h-full before:top-0 before:-left-[100px] before:opacity-60 after:absolute after:top-0 after:left-0 after:right-0 after:bottom-0 after:m-auto after:rounded-[50%] after:block after:w-[8em] after:h-[8em] after:text-center after:transition-shadow after:duration-500 after:ease-out after:z-[-1] hover:after:shadow-[inset_0_0_0_4em_rgb(181,182,225)] hover:text-[#000]">
                    <span>Verificar</span>
                </button>
            </form>
        </div>
    </main>
    <script src="js/two-factor.js"></script>
</body>

</html>
