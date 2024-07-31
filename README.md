# A MVCS pattern create a service command for Laravel

# Install
```bash
composer require zintel/laravel-service
```
### Change config file
```php
<?php
// config/app.php

'providers' => ServiceProvider::defaultProviders()->merge([
        //...
        
        \Zintel\LaravelService\Providers\MakeServiceCommandProvider::class,
        
    ])->toArray(),
```

### Usage
```bash
$ php artisan make:service {name : Create a service class} {--m= : Optional of import a model}
```
### Example
```bash
$ php artisan make:service User/UserService --m=User
```
