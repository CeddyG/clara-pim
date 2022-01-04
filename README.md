Clara Pim
===============

Pim feature for Clara.

## Installation

```php
composer require ceddyg/clara-pim
```

Add to your providers in 'config/app.php'
```php
CeddyG\ClaraPim\PimServiceProvider::class,
```

Then to publish the files.
```php
php artisan vendor:publish --provider="CeddyG\ClaraPim\PimServiceProvider"
```
