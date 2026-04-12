---
layout: doc
sidebar: false
aside: false
title: What is Tiny PHP?
description: Learn about Tiny PHP and how it works.
date: 2026-04-12
---

# What is Tiny PHP?

Here's a common scenario, you are building a new app and you need a simple api for your app. You can use laravel for that but it's too heavy for a simple api. So you decide to use a micro framework like slim or lumen. But then you realize that you need a simple way to handle authentication, logging, and other common tasks. So you start adding packages to your micro framework. And before you know it, you have a full-blown framework with hundreds of dependencies and complex configuration files. 

> 90% of the time, you need to build generic, simple apps that reuse the same features you have implemented hundrends of times before.

## Meet Tiny PHP
I made Tiny PHP as a solution to this problem. It is a simple, lightweight framework that is easy to use and understand. It abstracts away the reusable parts of the application, so you can focus on declaring intents, while Tiny PHP handles the rest.

## File Uploading Example
Let's take a simple example, you are trying to make a CRUD for a product system, and you want to allow uploading images for each product. With laravel, you will do something like this:

```php
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imagePath = $request->file('image')->store('products');

    $product = Product::create([
        'name' => $request->name,
        'image_path' => $imagePath,
    ]);
}
```

With Tiny PHP, you will do this:

```php
// models/Product.php
public UploadedFile $image;

// app/Http/Controllers/ProductController.php
public function store(Request $request)
{
    $model = Product::from($request->post(), $request->files());
    $model->save();
}
```

You don't need to worry about where and how to store your images, you simply need to know how to reterive and protect them, and this is exactly where Tiny excels at.

## Roadmap

I'm planning on continuing support and updating the framework. The framework still lacks features such as proper storage and has security issues.

I shall work upon improving the overall reliability and ensuring that the framework is production ready. I'll be working on it in my free time, so don't expect frequent updates. But I'll try my best to release updates as soon as possible.

Once the framework is adopted by someone, I shall start working on features and attempt to provide features for faster scaffolding and prototyping.