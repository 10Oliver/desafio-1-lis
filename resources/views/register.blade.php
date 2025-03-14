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
    <form class="register-container" autocomplete="off">
        <div class="shadow"></div>
        <div class="sponsor"></div>
        <div class="personal-info">
            <h4 class="register-title">Información personal</h4>
            <div class="input-field first-name-field">
                <input type="text" id="name" name="name" required placeholder="Primer nombre...">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="name">Primer nombre</label>
                <span class="material-symbols-outlined">
                    face
                </span>
            </div>
            <div class="input-field second-name-field">
                <input type="text" id="second_name" name="second_name" required placeholder="Segundo nombre...">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="second_name">Segundo nombre</label>
                <span class="material-symbols-outlined">
                    face
                </span>
            </div>
            <div class="input-field first-name-field">
                <input type="text" id="lastname" name="lastname" required placeholder="Primer apellido">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="lastname">Primer apellido</label>
                <span class="material-symbols-outlined">
                    face
                </span>
            </div>
            <div class="input-field second-name-field">
                <input type="text" id="second_lastname" name="second_lastname" required placeholder="Segundo apellido">
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="second_lastname">Segundo apellido</label>
                <span class="material-symbols-outlined">
                    face
                </span>
            </div>

            <div class="input-field country-field">
                <Select placeholder="Nacionalidad" required>
                    <option value="" disabled selected></option>
                    <option value="1">Nacional</option>
                    <option value="2">Extranjero</option>
                </Select>
                <div class="first-border"></div>
                <div class="last-border"></div>
                <label for="second_lastname">Nacionalidad</label>
                <span class="material-symbols-outlined">
                    face
                </span>
            </div>
        </div>
    </form>
</body>

</html>
