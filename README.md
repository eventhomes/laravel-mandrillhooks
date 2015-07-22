# Laravel 5 / Lumen 5 Fractal Api Controller
A simple api controller helper utilizing league fractal. You also get all the functionality provided by https://github.com/eventhomes/laravel-apicontroller

## Installation
```composer require eventhomes/laravel-fractalhelper```

## Basic Usage
By default, this helper will use ArraySerializer(), no setup required. You may, however, need to parse the GET includes.
```php
...
use EventHomes\Api\FractalHelper;

class MyController extends Controller {

    use FractalHelper;

    public function __construct(Request $request)
    {
        $this->parseIncludes($request->get('includes', ''));
    }
}
```

## Customize Fractal
If you need to change the default ArraySerializer(), you can modify.
```php
...
use EventHomes\Api\FractalHelper;

class MyController extends Controller {

    use FractalHelper;

    public function __construct(Manager $manager, Request $request)
    {
        $manager->setSerializer(new JsonApiSerializer);
        $this->setFractal($manager)->parseIncludes($request->get('includes', ''));
    }
}
```

## Respond with item
```php
public function show($id)
{
    $user = User::find($id);
    return $this->respondWithItem($user, new UserTransformer);
}
```

## Respond with collection
```php
public function index()
{
    $users = User::all();
    return $this->respondWithCollection($users, new UserTransformer);
}
```

## Respond with collection, paginated
```php
public function index()
{
    $users = User::paginate(10);
    return $this->respondWithCollection($users, new UserTransformer);
}
```