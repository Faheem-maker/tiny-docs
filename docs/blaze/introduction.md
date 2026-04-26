# Blaze

[[toc]]

## Introduction
Tiny PHP comes pre-built with a templating engine called blaze. It uses `.html.php` file extensions and providers several helper methods to simplify building layouts with PHP.

Blaze supports layout inheritence, parameter sharing and multiple directives. It doesn't yet support partial views and sections.

## Using Layouts
In order to inherit a layout, you need to create a file within `app/resources/views` folder.

```php
// layouts/app.html.php
<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title }}</title>
    </head>
    <body>
        <h1>My Layout</h1>
        <div>
            {{!! $content }}
        </div>
    </body>
</html>
```

Now, you can inherit this layout using the `@layout` directive.

```php
// home/index.html.php
@layout('layouts.app', [
    'title' => 'Home Page'
])

<p>Hi</p>
```

## Printing Values
Blaze supports two different directives for printing values:

### Safe Echo (<code v-pre>{{ ... }}</code>)

You can use safe echo (<code v-pre>{{ ... }}</code>) directive to print a value while automatically sanitizing it to avoid injection attacks. It would clean any HTML provided within the input.



### Unsafe Echo (<code v-pre>{{!! ... }}</code>)

In order to disply a value directly, without sanitizng it, you can use unsafe echo (<code v-pre>{{!! ... }}</code>) directive. It would print the value directly while appending any HTML directly.

::: danger
Unsafe echo should never be used to output untrusted data. Always use safe echo or sanitize the input yourself.
:::