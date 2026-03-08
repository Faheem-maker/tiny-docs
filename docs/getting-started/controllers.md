# Controllers

[[toc]]

## Introduction
Instead of defining all of your request handling logic in one place, you may wish to organize this behavior using "controller" classes. Controllers can group related request handling logic into a single class. For example, a    `UserController` class might handle all incoming requests related to users, including showing, creating, updating, and deleting users. By default, controllers are stored in the `app/http/controllers` directory.

### Writing Controllers
Let's begin by creating a new file under `app/http/controllers` called `HomeController.php`. We are going to add the following code within it.


```php
<?php
namespace app\http\controllers;

class HomeController {
    public function index() {
        return response()->send('Hello');
    }
}

```

The controller declares a single **action**, that responds by writing **Hello World** to the webpage.

However, we still need to define its route. A route is a way to tell tiny when to use your controller.

We shall add the following code within `app/config/routes.php`

```php
use app\http\controllers\HomeController;

// Rest of the code

Routes::get('/', [HomeController::class, 'index']);
```

Now, once you open the browser, it would show you "Hello World" as the output.