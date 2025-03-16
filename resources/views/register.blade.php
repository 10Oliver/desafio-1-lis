<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <form class="register-container" id="register-form" method="POST" action="{{ route('register.process') }}"
        autocomplete="off">
        @csrf
        <div class="shadow"></div>
        <div id="sponsor"></div>
        <div id="personal-info">
            <h4 class="register-title">Información personal</h4>
            <div class="input-field first-name-field">
                <input type="text" id="first_name" name="first_name" required placeholder="Primer nombre...">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="first_name">Primer nombre</label>
                <span class="material-symbols-outlined">
                    face
                </span>
                @error('first_name')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-field second-name-field">
                <input type="text" id="second_name" name="second_name" placeholder="Segundo nombre...">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="second_name">Segundo nombre</label>
                <span class="material-symbols-outlined">
                    face
                </span>
                @error('second_name')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-field first-name-field">
                <input type="text" id="lastname" name="lastname" required placeholder="Primer apellido">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="lastname">Primer apellido</label>
                <span class="material-symbols-outlined">
                    face
                </span>
                @error('lastname')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-field second-name-field">
                <input type="text" id="second_lastname" name="second_lastname" placeholder="Segundo apellido">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="second_lastname">Segundo apellido</label>
                <span class="material-symbols-outlined">
                    face
                </span>
                @error('second-name')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-field country-field">
                <Select placeholder="Nacionalidad" id="nationality" name="nationality" required>
                    <option value="" disabled selected></option>
                    <option value="1">Nacional</option>
                    <option value="2">Extranjero</option>
                </Select>
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="second_lastname">Nacionalidad</label>
                <span class="material-symbols-outlined">
                    flag_circle
                </span>
                @error('nationality')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <hr>
            <!-- National (DUI) -->
            <div class="input-field dui-field hide" id="dui">
                <input type="text" id="dui" name="dui" placeholder="Segundo apellido">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="dui">DUI</label>
                <span class="material-symbols-outlined">
                    badge
                </span>
                @error('dui')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <!-- International (Passport and country) -->
            <div class="input-field document-field hide" id="document">
                <input type="text" id="document" name="document" placeholder="Segundo apellido">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="document">Documento</label>
                <span class="material-symbols-outlined">
                    badge
                </span>
                @error('document')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-field country-data-field hide" id="country_data">
                <Select placeholder="Nacionalidad" id="country_data" name="country_data">
                    <option value="" disabled selected></option>
                    @foreach ($countries as $country)
                        <option value="{{ $country['id'] }}"> {{ $country['name'] }}</option>
                    @endforeach

                    <option value="2">Extranjero</option>
                </Select>
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="country_data">Pais de origen</label>
                <span class="material-symbols-outlined">
                    flag
                </span>
                @error('country-data')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <a id="return-button" href="{{ route('login') }}" type="button" class="navigation-button">Regresar</a>
            <button id="next-step" type="button" class="navigation-button">Continuar</button>
        </div>
        <div id="contact-info">
            <h4 class="register-title">Acceso y contacto</h4>
            <div class="input-field phone-field">
                <input type="tel" id="phone" name="phone" required placeholder="Teléfono">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="phone">Teléfono</label>
                <span class="material-symbols-outlined">
                    call
                </span>
                @error('phone')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-field email-field">
                <input type="email" id="email" name="email" required placeholder="Correo">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="email">Correo</label>
                <span class="material-symbols-outlined">
                    mail
                </span>
                @error('email')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-field password-field">
                <input type="password" id="password" name="password" required placeholder="Contraseña">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="password">Contraseña</label>
                <span class="material-symbols-outlined">
                    pin
                </span>
                @error('password')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-field confirm-password-field">
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    placeholder="Contraseña">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="password_confirmation">Confirmar contraseña</label>
                <span class="material-symbols-outlined">
                    pin
                </span>
                @error('password_confirmation')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
            <button id="back-step" type="button" class="navigation-button">Regresar</button>
            <button id="finish" type="submit" class="navigation-button">Finalizar</button>
        </div>
    </form>

    <script src="{{ asset('js/register.js') }}"></script>
</body>

</html>
