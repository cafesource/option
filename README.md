## Laravel Option

<p>
<a href="https://packagist.org/packages/cafesource/option"><img src="https://img.shields.io/packagist/dt/cafesource/option" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/cafesource/option"><img src="https://img.shields.io/packagist/v/cafesource/option" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/cafesource/option" alt="License"></a>
</p>

### Installation

Require this package with composer using the following command:

```shell
composer require cafesource/option
```

- Add the following class to the `providers` array in `config/app.php`:

```php
Cafesource\Foundation\CafesourceServiceProvider::class,
Cafesource\Option\OptionServiceProvider::class,
```

If you want to use the facade, add this to your facades in app.php:

```php
'Option' => Cafesource\Option\Facades\Option::class,
```

Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="Cafesource\Option\OptionServiceProvider"
```

#### Autoload

You can save the settings with the option "autoload" so that they are loaded once when launching the program and you do
not need to receive and execute a query when using it.

### Usage

```php
option('key', 'default'); // value
option(['key','key2',...], 'default'); // options
option()->exists('key'); // bool
option()->update('key', 'value');
option()->whereIn('key', ['keys',...])->orderBy('key')->get();
option()->where('key','option')->where('format', 'numeric')->first();
option()->where('key','option')->limit(10)->groupBy('value')->get();
...
```

```php
use Cafesource\Option\Facades\Option;

Option::first('key', 'default');
Option::get(['key','key2',...])
Option::update('key', 'value')
Option::updateOrAdd('key', 'value')
Option::remove('key')
...
```

#### Option type

You can save any data without conversion and receive it in its original form when used.

```php
option()->add('key', [int|double|bool|array|object]);
optino('key'); // int,double,bool,array,object
```

example:

```php
option()->updateOrAdd('example', ['cafesource','option']);
option()->add('example2', true);
option()->add('example3', Object);
// Result 
option('example'); // ['cafesource','option']
option('example2')); // true
option('example3'); // Object
```