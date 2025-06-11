# 🏋️‍♂️ Gymbros - Encuentra tu compañero ideal de gimnasio
![PNG_LOGOTIPO_VERDE_GYMBROS](https://github.com/user-attachments/assets/f87fb8a6-a9f2-47b7-8491-c599e2733b0f)


## 🚀 ¿Qué es Gymbros?  
Gymbros es una plataforma web que te ayuda a encontrar compañeros de entrenamiento ideales según tus preferencias. Con Gymbros puedes:  

✅ Buscar personas según gimnasio, edad, ejercicios favoritos y hobbies.  
✅ Guardar perfiles con "Fav" para revisarlos más tarde.  
✅ Chatear con otros usuarios para coordinar entrenamientos.  
✅ Personalizar tu perfil con información relevante.  

## 🛠️ Tecnologías utilizadas  
Gymbros está desarrollado con:  

### **Backend:**  
- 🐘 **Laravel 12** (API REST para la comunicación con el frontend)  
- 🛢 **MySQL** (Base de datos para almacenar usuarios y mensajes)  

### **Infraestructura:**  
- 🌍 **VPS** (Apache, Linux, PHP y MySQL)  

## 📌 Funcionalidades principales  
- **🔐 Autenticación:** Registro y login con email y contraseña.  
- **🏠 Home:** Lista de usuarios con filtros de búsqueda.  
- **❤️ Likes:** Guarda perfiles que te interesan.  
- **💬 Mensajes:** Chatea con otros usuarios.  
- **👤 Perfil:** Personaliza tu información.  

## 📂 Estructura del Proyecto  
```bash
📦 gymbros
├── 📁 backend (Laravel)
│   ├── 📁 app (Controladores, Middlewares, Modelos, Providers)
│       ├── 📁 Http
│       ├── 📁 Models
│       ├── 📁 Providers
│   ├── 📁 bootstrap
│   ├── 📁 config (app. auth, database, sanctum, mail)
│   ├── 📁 database (Migraciones, seeds y factories)
│   ├── 📁 routes (Endpoints API REST)
│   ├── 📁 storage
│   ├── 📁 tests
│   ├── 📄 .env (Configuraciones de base de datos)
│   ├── 📄 README.md
└── 📄 README.md (Este archivo)
```


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Development server

To start a local development server, run:

```bash
php artisan serve
```

Once the server is running, open your browser and navigate to `http://127.0.0.1:8000`. The application will automatically reload whenever you modify your PHP or Blade template files.

## Code scaffolding

Laravel’s Artisan CLI includes powerful code-scaffolding tools. To generate a new controller, run:

```bash
php artisan make:controller ControllerName
```

To generate a new model **with** a migration and factory, run:

```bash
php artisan make:model ModelName -m -f
```

To generate a new migration only:

```bash
php artisan make:migration create_table_name
```

To generate a new seeder:

```bash
php artisan make:seeder SeederName
```

For a complete list of `make:*` commands, run:

```bash
php artisan list make
```

## Building

First install PHP dependencies:

```bash
composer install
```

Then install and compile your front-end assets (using Laravel Mix):

```bash
npm install
npm run dev
```

## Running unit tests

To execute your PHPUnit tests through Artisan, use:

```bash
php artisan test
```

Or run PHPUnit directly:

```bash
vendor/bin/phpunit
```

## Additional Resources

For more information on using Artisan and all available commands, visit the [Laravel Artisan CLI documentation](https://laravel.com/docs/artisan).  
For a deep dive into Laravel Mix, see the [Laravel Mix documentation](https://laravel.com/docs/mix).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
