# Security

[[toc]]

## Introduction
While you must follow best practices to ensure that your app remains secure, Tiny comes with several powerful features to ensure basic security by default. This document covers many features packaged within Tiny to protect against common attack vectors.

## XSS Injection
Consider that you have allowed the user to enter description for a product. They enter the following within description:

```html
Product description

<script>
    alert("Test");
</script>
```

If you use `echo` to print the description, it would also render the `script` tag and run the JavaScript. This can significantly impact your site's security.

Tiny automatically protects against this by escaping the output of `{{ }}` directive. If you wish to bypass the escaping, use unsafe echo by appending `!!` after the opening brackets (e.g. <span v-pre>`{{!! $html }}`</span>).

## CSRF Protection
CSRF protection prevents other sites from submitting to your forms by requiring a token appended with each form. If you use `ActiveForm` widget, a CSRF token will be appended automatically. However, you can add a token within custom forms by using this syntax:

```php
<input type="hidden" name="_csrf" value="{{ \framework\utils\security\Csrf::allocate() }}">
```

Remember that forms using `GET` method will not be validated. If you have defined the route in any file other than `web.php`, validation would be skipped for that form as well.

## Auth
The framework comes built with a minimal authentication module. You can simply require authentication on any route by appenidng a middleware like this:

```php
Routes::get('/logout', [AuthController::class, 'logout'])->middleware(Auth::class);
```