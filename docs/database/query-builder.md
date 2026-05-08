# Query Builder

[[toc]]

## Introduction
Bolt PHP comes with a built-in query builder. Using which, you can write complex queries by using PHP functions.

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

You can also use a function to build more advaned groups.

```php
$orders = db()
    ->select(['id', 'customer_id', 'amount'])
    ->from('orders')
    ->where('customer_id', 3)
    ->andWhere(function (WhereClause $builder) {
        $builder->where('status', 'Shipped')
            ->orWhere('status', 'Delivered');
    })
    ->all();
```

The above code results in the following SQL query:

```sql
SELECT id, customer_id, amount
FROM orders
WHERE customer_id = 3
    AND (
        status = 'Shipped'
        OR status = 'Delivered'
    )
```

## Insert Statements
Insert statements are written by invoking `db->insert` method. It takes the table name and a list of columns. Unlike update/delete, insert is executed immediately without requiring any further method calls.

```php
db()->insert('products', [
    'name' => 'New Product',
    'price' => 2000
]);
```

::: tip
Do not call `execute` on `insert` result. Calling  insert executes the query automatically.
:::

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

## Delete Statements
Delete statements are written by invoking `db->delete` method. It takes the table name to use for deletion. You can add additional coneditions and then use `execute` to run the delete.

```php
db()
    ->delete('products')
    ->where('id', 3)
    ->execute();
```

::: danger
Always add a `where` clause before running a delete query.
:::