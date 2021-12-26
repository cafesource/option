## Laravel Option

### Installation

Require this package with composer using the following command:

```shell
composer require cafesource/option
```

- Add the following class to the `providers` array in `config/app.php`:

```php
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

### Usage

```php
option('key', 'default'); // Value
option()->update('key', 'value');
option(['key','key2',...], 'default') // options
...
```

```php
Option::first('key', 'default');
Option::get(['key','key2',...])
Option::update('key', 'value')
Option::updateOrAdd('key', 'value')
Option::remove('key')
...
```
