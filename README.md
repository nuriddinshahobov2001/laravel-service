# Laravel Service Generator (MVCS Pattern)

[![Latest Version](https://img.shields.io/packagist/v/zintel/laravel-service.svg)](https://packagist.org/packages/zintel/laravel-service)
[![License](https://img.shields.io/packagist/l/zintel/laravel-service.svg)](https://packagist.org/packages/zintel/laravel-service)

A Laravel Artisan command to generate service classes following the Model-View-Controller-Service (MVCS) pattern, promoting separation of business logic from controllers.

## Features

- 🚀 Quick service class generation
- 📁 Supports nested directory structure
- 🔗 Optional model binding
- 🛠️ Pre-configured CRUD method stubs
- ⚡ Laravel 9.x and 10.x compatible

## Installation

1. Install via Composer:

```bash
composer require zintel/laravel-service
```

2. The package will auto-register. For manual registration, add to config/app.php:
```bash
'providers' => [
    // ...
    \Zintel\LaravelService\Providers\MakeServiceCommandProvider::class,
],
```

3. Basic Command
```bash
php artisan make:service ServiceName --m=ModelName
```

4. With Model Binding
```bash
php artisan make:service ServiceName --m=ModelName
```

5Nested Services
```bash
php artisan make:service Folder/ServiceName
```