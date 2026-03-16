# ORM

[[toc]]

## Introduction
ORM (Object Relationship Mappers) allow you to work with database by using simple PHP objects. Instead of writing SQL like this:

```sql
INSERT INTO users (username, email)
VALUES ('username', 'email')
```

You can use PHP objects like this:
```php
$user = new User();
$user->username = 'username';
$user->email = 'email';
if ($user->validate()) {
    $user->save();
}
```

## Writing Models
In order to write a PHP class to manipulate a database table, you must write a class extending from `\framework\db\ActiveModel`. The syntax remains similar to [models](/docs/forms/models.md) and form generation can work consistently.

```php
use framework\db\ActiveModel;
use framework\web\models\attributes\Required;
use framework\web\models\attributes\Email;
use framework\web\models\attributes\Length;
use framework\web\models\attributes\PrimaryKey;

class User extends ActiveModel {
    #[PrimaryKey]
    public int $id;

    #[Required]
    #[Length(min: 3, max: 50)]
    public string $username;

    #[Required]
    #[Email]
    #[Length(min: 8)]
    public string $email;
}
```

At least one field must be marked with the `PrimaryKey` attribute.

## Reading Data
You can fetch data by using the `all` and `find` method. If you want more control, you can use `where` method to write queries using the query builder.

Here are a few examples:


### Using `find` to Fetch a Record
```php
$user = User::find(1); // Find the user with id = 1
echo $user->username;
```

### Using `all` to Read All Records
```php
$users = User::all(); // Fetch all users at once

foreach ($users as $user) {
    echo $user->username . '<br>';
}
```

### Using `where` for Custom Queries
```php
// Fetch users with username = Tom
// and either Paris or New York as their city
$users = User::where('username', 'Tom')
    ->andWhere(function (WhereClause $builder) {
        $builder->where('city', 'Paris');
        $builder->where('city', 'New York');
    })->all();
```


## Creating Data
In order to create new records, simply use `new` keyword to make a new object, then save it by calling `->save()`.

```php
// Can also do "new User" and manually set the fields
$user = User::from([
    'username' => 'Tom',
    'email' => 'abc@gmail.com'
]);
$user->save();
```

::: tip
You can use `from` to generate models from arrays request data.
:::

## Updating Data
In order to update data, read it by using any of the select statements above, then use `save` to persist the records.

```php
$user = User::find(2);
$user->email = 'abc@gmail.com';
$user->save();
```

::: tip
If you are building forms, include `id` as a hidden field, then use `Model::from` to quickly read all data in one go.
:::

## Deleting Data
You can delete records by using `->delete` method.

```php
$user = User::find(1);
$user->delete();
```