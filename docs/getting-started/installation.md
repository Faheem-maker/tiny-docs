# Installation

[[toc]]

## Meet Tiny
Tiny PHP is a simple, light-weight and self-contained
PHP framework. It comes with powerful features to help you build small, simple applications fast.

Tiny is modeled after laravel, but focused to allow minimal configuration and customization. This reduces flexiblity, but allows rapid prototyping.

## Creating a Tiny Application

### Installing PHP and Git
Before creating an application, you need to ensure that your local machine has [PHP](https://www.php.net/downloads.php) and [Composer](https://getcomposer.org/download/) installed.

### Creating an Application
After you have installed PHP and Composer, you can create a new project using this commands:

```bash
composer create-project tinyframework/tiny my-app
cd my-app
```
Now, you can launch the application using this command
```bash
php -S localhost:8000
```

## Initial Configuration
All configuration files are stored with `app/config` folder. The application is already configured to run out of the box, however, there are a few options you might need to configure according to your application.

1. Setup `.env` file

Rename the `.env.example` file to `.env`.

2. Base URL

If your application is being hosted in a sub-directory, you would need to set the base URL within `.env` as follows:

```
BASE_URL=/my-subfolder/
```

3. Database Configuration

Modify the `.env` to add database configuration for your database:

```
DB_HOST=localhost
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=
DB_DATABASE=tiny
```

### Environment Based Configuration
Since many config options are dependant on whether the application is running on your local machine or a production server, these options are defined through `.env` file. Any option defined within that file are available through the `env()` method.

## Next Steps
Now that you have created the application, you be be wondering how to proceed further. We recommend following the "Getting Started" tutorial to build a complete app in under 30 minutes. This should give you the knowledge required to build more advanced apps.

* [Controllers](controllers.md)
* [Views](views.md)
* [Reactivity](reactivity.md)

We can't wait to see what you build!