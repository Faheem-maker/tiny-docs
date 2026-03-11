# Query Builder

[[toc]]

## Introduction
Tiny PHP comes with a built-in query builder. Using which, you can write complex queries by using PHP functions.

The query builder is database-agnostic, which means that you can swap the database with another one and all queries will work as expected. It's mostly strongly typed, however, a few areas continue to return `mixed` or `object` types due to language constraints.

### Example
```php
$customers = db()->select('*')
    ->from('customers')
    ->all();
```

## Select Statements
Select statements are written by invoking `db->select` method. It takes a list of columns as an array or string.

You must invoke a `first()` or `all()` method to actually execute the query and fetch the data.

```php
$orders = db()
    ->select('id, customer_id, amount')
    ->from('orders')
    ->all();

// Can also be written like this
$orders = db()
    ->select(['id', 'customer_id', 'amount'])
    ->from('orders')
    ->all();
```

### Joins
Joins can be added by invoking the `join($table, $condition, $type = 'LEFT')` method. There are also dedicated methods available like `leftJoin`, `innerJoin`, `rightJoin` and `fullJoin`.

```php
$orders = db()
    ->select(['id', 'orders.customer_id', 'customer_name', 'amount'])
    ->from('orders')
    ->leftJoin('customers', 'customers.customer_id = orders.customer_id')
    ->all();
```

### Where Clause
A where clause can be added by invoking `where($condition, $params = [])` method. Currently, nested clauses aren't supported. You can use `orWhere` to add a where with "OR" operator.

```php
$orders = db()
    ->select(['id', 'customer_id', 'amount'])
    ->from('orders')
    ->where('customer_id = :id', [':id' => 3])
    ->all();
```

In the above example, we use `:id` parameter to avoid SQL Injection.

For "=" conditions, we also have a shorthand that can be invoked like this:

```php
// Same as above query
$orders = db()
    ->select(['id', 'customer_id', 'amount'])
    ->from('orders')
    ->where('customer_id', 3)
    ->all();
```

## Update Statements
Update statements are written by invoking `db->update` method. It takes the table name and the values to update.

You must invoke `execute()` to ensure that the statement is actually executed.

```php
db()->update('orders', [
    'status' => 'Shipped'
])->execute();
```

### Where Clause
In order to add a where clause, simply call the `where` method before invoking `execute`. All methods available within a SELECT statement are supported.

```php
db()->update('orders', [
        'status' => 'shipped'
    ])
    ->where('order_id', 1)
    ->execute();
```