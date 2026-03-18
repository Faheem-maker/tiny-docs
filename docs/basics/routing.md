# Routing

[[toc]]

## Basic Routing
You can define routes within `config/routes/web.php` by using the `Routes` class.
An example of defining a route might look like this:

```php
Routes::get('/', [HomeController::class, 'index']);
```

### Available Router Methods
The router allows you to register routes that respond to any HTTP verb:

```php
Routes::get('$ui', $action);
Routes::post('$ui', $action);
Routes::put('$ui', $action);
Routes::patch('$ui', $action);
Routes::delete('$ui', $action);
```

## Route Parameters
Sometimes you will need to capture segments of the URI within your route. For example, you may need to capture a user's ID from the URL. You may do so by defining route parameters:

```php
Routes::get('/users/{id}', $action);

// Controller.php
public function index($id) {

}
```

You may define as many route parameters as required by your route:

```php
Routes::get('/posts/{post}/comments/{comment}', $action);

// Controller.php
public function show(string $post, string $comment) {
    // ...
}
```

### Model Parameters
Consider the following route/action:

```php
Routes::get('/users/{userId}', $action);

// Controller.php
public function show($userId) {
    $user = User::find($user);
}
```

You can type hint the parameter name to automatiacally load the relevant record.

```php
Routes::get('/users/{user}', $action);

// Controller.php
public function show(User $user) {
    echo $user->email;
}
```

## Named Routes
You can optionally pass a 3rd parameter to the `get/post` methods to define a name:

```php
Routes::get('/', $action, 'home');
```

You can then redirect to it like this:
```php
response()->redirect(app()->url->named('home'));
```

## Route Groups
Route groups allow you to share route attributes, such as middleware, across a large number of routes without needing to define those attributes on each individual route.

Nested groups attempt to intelligently "merge" attributes with their parent group. Middleware and where conditions are merged while names and prefixes are appended. Namespace delimiters and slashes in URI prefixes are automatically added where appropriate.

```php
Routes::group('/users', function () {
    Routes::get('/', [UsersController::class, 'index']); // Similar to /users
})->middleware(AuthMiddleware::class);
```

### Middleware
Middleware can be defined by calling the `middleware` method on a route or route group. You can use either a single string or array of strings. Middleware will be executed in the order they are listed in.

```php
Routes::group('/users', function () {
    Routes::get('/', [UsersController::class, 'index']); // Similar to /users
})->middleware([Auth::class, Logger::class]);
```

## Resource Routes
Resources routes declare the following named routes automatically

| Name    | Route      | Method      |
| ------  | -------    | ------      |
| index   | /          | GET         |
| create  | /create    | GET         |
| store   | /          | POST        |
| show    | /\{id}     | GET         |
| edit    | /{id}/edit | GET         |
| update  | /\{id}     | POST|PATCH  |
| destroy | /\{id}     | DELETE      |

### Including Specific Routes
You can use the `only` option within the 3rd parameter to only add the selected routes:

```php
Routes::resource('/users', UsersController::class, [
    'only' => ['create', 'store', 'delete']
]);
```

Similarly, you can use `expect` to remove selected routes:

```php
Routes::resource('/users', UsersController::class, [
    'except' => ['create', 'edit']
]);
```

### Renaming the Resource
You can rename the resource by supplying the `resource` option within the 3rd parameter:

```php
Routes::resource('/users', UsersController::class, [
    'resource' => 'user'
]);
```

This would allow you to use `$user` as your parameter name, instead of the default `$id`:

```php
public function show (User $user) {
    
}
```