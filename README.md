## Installation

### 1. Depedency

Using <a href="https://getcomposer.org/" target="_blank">composer</a>, execute the following command to automatically update your `composer.json`:

```shell
composer require brenodouglas/laraveljwt
```

or manually update your `composer.json` file

```json
{
    "require": {
        "brenodouglas/laraveljwt": "~dev1.0"
    }
}
```

### 2. Provider

You need to update your application configuration in order to register the package, so it can be loaded by Laravel.
Just update your `config/app.php` file adding the following code at the end of your `'providers'` section:

```php
// file START ommited
    'providers' => [
        // other providers ommited
        \LaravelJwt\JwtProvider::class,
    ],
// file END ommited
```

### 3. Publishing configuration file
To publish the default configuration file
```shell
php artisan vendor:publish
```

### 4. Using the middleware

To protect your routes, you can use the built-in middlewares.

#### Verify token and regenerate new token in get or header with key 'access-token' : authjwt

```php
Route::get('foo', ['middleware' => ['authjwt'], function()
{
    return 'Yes I can!';
}]);
```

Or within controllers:
```php
$this->middleware('auth:jwt');
```

### 5. Auth and Facade

Register facade and use Jwt authentication.
Just update your `config/app.php` file adding the following code at the end of your `'aliases'` section:

```php
// file START ommited
    'aliases' => [
        // other providers ommited
       'JWT' => \LaravelJwt\Facades\JwtAuthFacade::class
    ],
// file END ommited
```
One example route auth and protected route with jwt:

```php
Route::post("auth", function(\Illuminate\Http\Request $request) {
    return response()->json(['token'=> \JWT::authenticate($request)]);
});

Route::group(['middleware' => ['authjwt']], function($router) {
    $router->get('users', function() {
        return 'Yes, a can!';
    });
});
```

Send POST for 'auth' route with raw body json:
{
    "email": "email@foryouruser.com",
    "password": "password"
}

The return is json with a key 'token'.