<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Administrador</title>
</head>

<body>
    
    <navbar class="mobile-navbar">
        <span class="material-symbols-outlined" id="navbar-menu-button">
            menu
        </span>
    </navbar>
    <aside class="sidebar" id="sidebar-menu">
        <div class="user-sidebar">
            <img src="{{ asset('resources/images/user-layout.png') }}" alt="">
        </div>
        <div class="navigation-bar">
            <div class="sidebar-icon">
                <span class="material-symbols-outlined">
                    dashboard
                </span>
                <p>Panel</p>
            </div>
            <div class="sidebar-icon">
                <span class="material-symbols-outlined">
                    savings
                </span>
                <p>Entrada</p>
            </div>

            <div class="sidebar-icon">
                <span class="material-symbols-outlined">
                    point_of_sale
                </span>
                <p>Salida</p>
            </div>

            <div class="sidebar-icon">
                <span class="material-symbols-outlined">
                    account_balance
                </span>
                <p>Cuentas</p>
            </div>

            <div class="sidebar-icon">
                <span class="material-symbols-outlined">
                    bookmarks
                </span>
                <p>Categorías</p>
            </div>
            <div class="sidebar-icon">
                <span class="material-symbols-outlined">
                    account_box
                </span>
                <p>Perfil</p>
            </div>
        </div>

        <div class="sidebar-icon logout-icon">
            <span class="material-symbols-outlined">
                logout
            </span>
            <p>Cerrar sesión</p>
        </div>
    </aside>
    <main class="main-layout">
        @yield('content')
    </main>
</body>
<script src="{{ asset('js/layout.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

</html>