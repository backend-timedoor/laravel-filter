# Laravel Filter

This package is used to filter data from request in a simple way.

## Installation

You can install the package via composer:

```bash
composer require timedoor/laravel-filter
```

## Usage

### Create a filter class

```bash
php artisan make:filter UserFilter
```

In default, all filter class are stored inside app/Http/Filters folder. If you want to store it in another folder, you can pass the full namespace instead of the name

```bash
php artisan make:filter App/Foo/Bar/YourFilter
```

After you successfully create the filter class, it will look like this:

```php
<?php

namespace App\Filters;

class UserFilter
{
    public function keyword($builder, $value)
    {
        //
    }
}

```

### Use Filterable trait

Add the Filterable trait inside your model.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Timedoor\LaravelFilter\Concerns\Filterable;

class User extends Model
{
    use Filterable; 
}
```

### Filtering Data

After you finished the required setup, now you can filter data in your controller:

```php
use App\Http\Filters\UserFilter;

$users = User::applyFilter(UserFilter::class)->get();
```

## Cases

Let's say your application inside `http://your-domain.com` and you want to filter user data by their name, so the request will be like `http://your-domain.com?name=John` you can handle it like this:

```php
// app/Http/Filters/UserFilter.php

<?php

namespace App\Filters;

class UserFilter
{
    public function name($builder, $value)
    {
        return $builder->where('name', 'LIKE', "%{$value}%");
    }
}
```

```php
// app/Http/Controllers/HomeController.php

<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::applyFilter(UserFilter::class)->get()
        
        return $users;
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Rizky Nur Hidayattulloh](https://github.com/rizkyhidayattulloh)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
