# Desafio 1 LIS - 2025

### 📓 Descripción de proyecto

Aplicación web para el control de finanzas personales, basado en entradas y salidas. Está creado usando Laravel 12 + Blade, el cual posee las siguientes funcionalidades:

-   Registro de entradas y salidas
-   Creación de cuentas y categorías personalizadas para realizar las transacciones
-   Gráficos y reportes
-   Registro de nuevo usuarios y autenticación con dos factores.

### 🧑‍🤝‍🧑 Integrantes de equipo

-   David Ernesto Ramos Vásquez RV230544
-   Melissa Vanina López Peña LP223029
-   Vladimir Alexander Ayala Sánchez AS180120
-   Bryan Rubén De Paz Rivera DR202095
-   Oliver Alejandro Erazo Reyes ER231663
-   Rodrigo André Henríquez López HL211477

## 🔧 Instalación

> [!IMPORTANT]
> El proyecto requiere del gestor de paquetes `composer` para su uso, y este no se encuentra instalado por defecto, por lo que es obligatoria su instalación.

#### 1. Configuración de php 🔨

El proyecto está pensado para utilizar `MySQL`, y posee características para envío y recepción de archivos internamente y externamente con otras **API'S**, por lo que es necesario realizar la siguiente modificación en el archivo `php.ini`.

```
;extension=gd // Descomentar esta línea
```

#### 2. Variables de entorno ⚒

Para la creación de la base de datos y posteriormente el uso del proyecto, es indispensable colocar correctamente las variables de entorno, para ello se debe de crear el archivo `.env` basado de `.env.example`.

En estos archivos, las variables realmente importantes son las encargadas de la conexión con la base de datos y el ID del proyecto.

> [!NOTE]
> Para la creación del ID, se recomienda usar el comando `php artisan key:generate`.

#### 3. Instalación de dependencias ➕

Además del Framework de Laravel, el proyecto utiliza una serie de dependencias indispensables para su funcionamientos, tales como **Fortify**, **dompdf** y **google2fa**. Para instalarlas basta con ejecutar el siguiente comando:

```bash
composer install
```

#### 4. Base de datos 🗄

Con las dependencias ya instaladas, se puede crear la base de datos y poblarla con los datos iniciales.

Para ello se utilizan los siguientes comandos:

```bash
# Migraciones
php artisan migrate

# Poblar la base de datos
php artisan db:seed
```

#### 5. Uso del sistema 🤝

Con todo esto configurado, el proyecto debería de funcionar con normalidad.

Para iniciar el proyecto, se usa el comando:

```bash
php artisan serve
```

## 📔 Flujo del sistema

Una vez iniciada la sesión (y creado el usuario) se deberá de registrar cuentas para realizar transacciones, ya sean de entradas o salidas, ya que sin estas, no se podrán agregar ninguna transacción.

En el caso que se deseen agregar más tipos de transacciones se podrán añadir sin ningún inconveniente en el apartado del menú correspondiente.

En el panel principal, se podrá visualizar datos relevantes de la cuenta e incluso la generación de un reporte en `pdf`

En el apartado de perfil se podrán realizar modificaciones tales como `cambios de datos básicos`, `cambio de contraseña` y `activación del segundo factor de autenticación`.

## 🌐 Consideraciones adicionales

El proyecto hace uso obligatorio de librerías para terceros como [restcountries.com](https://restcountries.com) y [quickchart.io](https://quickchart.io) por lo que la conexión a Internet es indispensable.
