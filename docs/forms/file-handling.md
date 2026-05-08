# File Handling

[[toc]]

## Introduction
Most applications need to prompt users for file uploading, whether those are product images, or user avatars. Bolt provides a simple and efficient way to handle file uploads.

## Uploading Files
In order to upload files, we can use `Forms.FileField` widget. Here's a complete example of a simple form with file upload:

```php 
// HomeController.php
public function index(Request $request) {
    $image = $request->file('image');

    $image->move('/uploads/'); // Move to storage/uploads
}
```

Now, we can design our view
```html
// users/create.html.php
<Forms.Form action="/">
    <Forms.FileField name="avatar" />
    <Layout.Flex justify="end">
        <Forms.Button type="submit" variant="primary">Save</Forms.Button>
    </Layout.Flex>
</Forms.Form>
```

## Using Models
Models make it much easier to automatically upload and manage files.

Let's begin by creating a model.

```php
class Product extends ActiveModel {
    #[PrimaryKey]
    public int $id;
    public string $name;
    public float $price;
    public UploadedFile $image;
}
```

Now, we can use this model in our controller
```php
// HomeController.php
public function index(Request $request) {
    $product = Product::from($request->post(), $request->files());

    if ($request->method() == 'POST' && $product->validate()) {
        $product->save(); // File is uploaded automatically
    }
    else {
        return view('products.create', [
            'model' => $product
        ]);
    }
}
```

And in our view
```html
// products/create.html.php
<Forms.ActiveForm :model="$product" action="/">
    <Forms.TextField name="name" />
    <Forms.TextField name="price" />
    <Forms.FileField name="image" />
    <Layout.Flex justify="end">
        <Forms.Button type="submit" variant="primary">Save</Forms.Button>
    </Layout.Flex>
</Forms.ActiveForm>
```

Finally, when reterieving the files, we can use this code to display them.

```php
// index.html.php
$product = Product::find(1);

<img src="/app/storage/uploads{{ $product->image->name() }}" alt="{{ $product->image->name }}" />
```

::: warning
The current API is a prototype and will soon be replaced by a more robust one.
:::