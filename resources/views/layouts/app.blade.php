<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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


             <a href="{{ route('incomes.index') }}" class="sidebar-icon">
                <span class="material-symbols-outlined">savings</span>
                <p>Entrada</p>
             </a>

             <a href="{{ route('expenses.index') }}" class="sidebar-icon">
                 <span class="material-symbols-outlined">point_of_sale</span>
                 <p>Salida</p>
             </a>

             <a href="{{ route('dashboard') }}" class="sidebar-icon">
                <span class="material-symbols-outlined">dashboard</span>
                <p>Panel</p>
             </a>

             <a href="{{ route('accounts.index') }}" class="sidebar-icon">
                <span class="material-symbols-outlined">account_balance</span>
                <p>Cuentas</p>
             </a>


             <a href="{{ route('categories.index') }}" class="sidebar-icon">
                 <span class="material-symbols-outlined">bookmarks</span>
                 <p>Categorías</p>
             </a>

             <a href="{{ route('profile.index') }}" class="sidebar-icon">
                 <span class="material-symbols-outlined">account_box</span>
                 <p>Perfil</p>
             </a>
        </div>

        <div>
            <form action="{{ route('logout') }}" method="POST" class="sidebar-icon logout-icon" style="margin: 0; padding: 0;">
             @csrf
                <button type="submit" style="all: unset; width: 100%; height: 60px; display: flex; align-items: center; justify-content: flex-start; gap: 0;">
                 <span class="material-symbols-outlined">logout</span>
                    <p class="logout-label">Cerrar sesión</p>
                </button>
            </form>

        </div>


    </aside>
    <main class="main-layout">
        @yield('content')
    </main>

</body>
<script src="{{ asset('js/layout.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
