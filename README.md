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

## Advance Usage

### Using Custom Laravel Query Builder

In case you want to use your own laravel query builder, you need to follow this setup:

```php
// app/QueryBuilders/UserQueryBuilder.php

<?php

namespace App\QueryBuilders;

use Timedoor\LaravelFilter\LaravelFilterQueryBuilder;

class UserQueryBuilder extends LaravelFilterQueryBuilder
{

}
```

Make sure your query builder is extended to LaravelFilterQueryBuilder class

```php
// app/Models/User.php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Timedoor\LaravelFilter\Concerns\Filterable;
use App\QueryBuilders\UserQueryBuilder;

class User extends Model
{
    use Filterable; 
    
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \App\QueryBuilders\UserQueryBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new UserQueryBuilder($query);
    }

    /**
     * @param  stdClass  $subject
     * @param  \Illuminate\Http\Request|null  $request
     * @param  array<string, mixed>  $options
     * @return \App\QueryBuilders\UserQueryBuilder
     */
    public static function applyFilter($subject, $options = [], Request $request = null)
    {
        /** @var \App\QueryBuilders\UserQueryBuilder $builder */
        $builder = (new static)->newQuery();

        return $builder->applyFilter($subject, $options, $request);
    }
}
```

Now you can implement filter with your own query builder.

### Using with Options

There are 2 options that available `include` and `exclude` you can pass the options inside applyFilter() method

```php
User::applyFilter(UserFilter::class, [
    'include' => [
        'name' => 'John',
        'email' => 'fhuel@example.org'
    ],
    'exclude' => ['address']
])
```

#### Include

This option is when you want to call filter method even if the request params is not set. For example you want to filter user by their names and your endpoint looks like this `http://localhost/user?name=John`. But if the request doesn't have `name` query your filter method will not called. If you want to always call your filter method even if the request doesn't have query, you can use `include` option

```php
User::applyFilter(UserFilter::class, [
    'include' => ['name' => 'John']
])
```

#### Exclude

This option is for prevent the filter method called. For example you have `name()` method inside your filter class and the request query looks like this `http://localhost/user?name=John`. But you don't want `name()` method called, you can use exclude option

```php
User::applyFilter(UserFilter::class, [
    'exclude' => ['name']
])
```

## Chaining Filter

If you want to use more than 1 filter class, you can chain the `applyFilter` method, so it will looks like this:

```php
User::applyFilter(Foo::class)
    ->applyFilter(Bar::class)
    ->get()
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
