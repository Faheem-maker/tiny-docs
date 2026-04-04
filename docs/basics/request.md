# Request

[[toc]]

## Introduction
`Request` (`\framework\web\request\Request`) class is used to manipulate received `GET/POST` data without
having to manually work with superglobals.

## Reading Data
In order to access the request object, you can typehint the class to automatically inject an instance within your action.

Example:

```php
use \framework\web\request\Request;

public function index(Request $request) {
    echo $request->get('id', 1);
}
```

You can also use `request()` helper function.

```php
public function index() {
    echo request()->get('id', 1);
}
```

::: danger
There's a known bug with `request` where the returned instance doesn't
contain attached data.
:::

### Reading GET data
You can use `get($key, $default)` method to read the data from `$_GET` superglobal.

```php
echo $request->get('name');
echo $request->get('name', 'Tom'); // get with default

$data =  $request->get(); // Read all data at once
```

### Reading POST data
You can use `post($key, $default)` method to read the data from `$_POST` superglobal.

```php
echo $request->post('name');
echo $request->post('name', 'Tom'); // get with default

$data =  $request->post(); // Read all data at once
```

### Reading REQUEST data
You can use `input($key, $default)` method to read the data from `$_REQUEST` superglobal. Note that if keys overlap, POST will take presedence over GET.

```php
echo $request->input('name');
echo $request->input('name', 'Tom'); // get with default

$data =  $request->input(); // Read all data at once
```

## Working With Files
In order to work with files, you need to use the `file` method, which returns an `UploadedFile` instance or `null`.

Example:

```php
$file = $request->file('profile_image');

$file->move('/uploads/'); // Move the file to /uploads within the storage folder
```