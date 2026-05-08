# Views

[[toc]]

## Introduction
Of course, it's not practical to return entire HTML documents strings directly from your routes and controllers. Thankfully, views provide a convenient way to place all of our HTML in separate files.

Views separate your controller / application logic from your presentation logic and are stored in the `assets/views` directory. When using Bolt, view templates are written using a built-in templating language similar to blade. A simple view might look something like this:

```html
<!-- View stored in assets/views/greeting.html.php -->
<html>
    <body>
        <h1>Hello, {{ $name }}</h1>
    </body>
</html>
```

From our controller, we can render this view by using the global `view` helper function:

```php
public function index() {
    return view('greeting');
}
```

## Creating and Rendering Views
You can create a file within `assets/views` with the `.html.php` extension to create a view. Views are rendered using Bolt's built-in templating language that provides several powerful features like easily echoing values, writing if conditions are more.

Let's create a new file within `views/home/index.html.php` with this code:

```html
<html>
    <body>
        <h1>Letter Counter</h1>
        <input type="text" id="text">
        <div>letter Count: <span id="char-count"></span></div>

        <script>
            document.getElementById('char-count').addEventListener('change', function updateCount(e) {
                document.getElementById('char-count').innerText = e.target.value.length;
            })
        </script>
    </body>
</html>
```

We shall now modify our controller to use it like this:

```php
public function index() {
    return view('home.index');
}
```

### Using a Layout
Generally, we don't want to write our head, navigation bar, sidebar, etc. on every single page, therefore, we can write a single layout that can be reused for all views.

Bolt comes with a pre-built layout view with tailwind CSS. In order to use it, remove the `html` tag and add the following at the top:

```php
@layout('layout.main', [
    'title' => 'Word Counter'
])
```

You can modify `views/layouts/main.html.php` to suit the layout to your needs.

### Using Widgets
Bolt comes with several built-in widgets to help faster prototyping. A full list of these widgets will be available soon.
However, we can rewrite our view like this to automatically apply consistent styling across each:

```html
<Ui.Card>
    <Layout.Row cols="2" cols-md="4">
        <Ui.TitleCard
            color="primary"
            id="char-count"
            title="Characters"
            />
    </Layout.Row>

    <Forms.TextArea
        id="text"
        placeholder="Start typing or paste your text here..."/>
</Ui.Card>

<!-- Same JavaScript as before -->
```

This would create a beautiful, complete application that counts letters of given text.