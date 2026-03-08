# Reactivity

[[toc]]

## Introduction
Most applications require some JavaScript to build functionality and support interactions. In our application, we are using it to count the letters of the entered text.

However, managing the DOM manually is redundant and error-prone. We can, instead, rely on tiny to manage that for us.

### Tiny.js
Tiny comes packed with `tiny.js`, a reactive library that allows you to write such applications cleanly and in a very maintainable way. It doesn't require a build-step and is included in each project by default.

## Writing Reactive Views
Let's modify our view to write it using `tiny.js`. We can rewrite it like this:

```html
<Ui.Card data-scope="counter: {text: ''}">
    <Layout.Row cols="2" cols-md="4">
        <Ui.TitleCard
            color="primary"
            data-text="counter.text.length"
            title="Characters"
            />
    </Layout.Row>

    <Forms.TextArea
        data-bind="counter.text"
        placeholder="Start typing or paste your text here..."/>
</Ui.Card>

<!-- Remove all JavaScript -->
```

There are 3 main changes that we need to understand:

* `data-scope="counter: {text: ''}"`

It creates a scope that's available within our `Ui.Card`.
We also create a "text" variable which is empty by default.

* `data-bind="counter.text"`

`data-bind` creates a two-way binding to `counter.text`. It means that when we type anything in the text area, it updates `counter.text` automatically. Similarly, when we update `counter.text` using JavaScript, it would change the text area automatically.

* `data-text="counter.text.length"`

It creates a one-way binding to `innerText` of this element. Whenever `counter.text` is updated by typing within the textarea, it updates the title card automatically to `counter.text.length`, or the number of characters.


### Using `data-controller`
As your JavaScript expands, it becomes hard to manage it using HTML attributes. Tiny provides a feature called "controllers" to adress this. These controllers are different from PHP controllers and allow you to isolate your business logic and UI.

Let's convert our code using a controller:

Create a new file under `assets/js/counter.js`
```js
class Counter {
    text = "";

    get letters {
        return this.text.length;
    }

    clear() {
        this.text = "";
        Ui.toast.success("Text cleard successfully");
    }
}
```
This creates a simple class with options to get text's length and clear it. It relies on Tiny's built-in `Ui` library to display a success message.

Let's use it within our view:
```html
<!-- Load Our Script Libraries -->
@{
    // Load our JS file
    app()->assets->addScript('js/counter.js');
    // Load tiny's UI library to access toast
    app()->assets->addScript('js/ui/toast.js');
}

<Ui.Card data-controller="counter: Counter">
    <Layout.Row cols="2" cols-md="4">
        <Ui.TitleCard
            color="primary"
            data-text="counter.letters"
            title="Characters"
            />
    </Layout.Row>

    <Forms.TextArea
        data-bind="counter.text"
        placeholder="Start typing or paste your text here..."/>
    
    <Layout.Flex justify="end">
        <Forms.PillButton data-onclick="counter.clear()">
            Clear Text
        </Forms.PillButton>
    </Layout.Flex>
</Ui.Card>
```

There are some important changes that we have made:

* `data-controller="counter: Counter"`

In order to use a controller, we use the `data-controller` attribute, and provide a name followed by our controller name (`counter: Counter`).

* `data-onclick="counter.clear()"`

`data-on` syntax is used to attach event listeners. Tiny attaches an event listener to your button, and when it's clicked, calls the `counter.clear` method. Within that method, we are calling `this.text = ""`, clearing the text, and updating the text area / word count automatically.