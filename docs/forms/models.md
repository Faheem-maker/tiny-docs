# Models

[[toc]]

## Introduction
Every web-app needs forms to read and process user data. Tiny provides several powerful features to make building, validating and processing forms easier and faster.

Models provide a central and consistent way to generate and validate forms.

## Building a Model
In order to write a model, create a new class within `app\http\models` and extend it from `\framework\models\Model`.

```php
namespace app\http\models;

use framework\web\models\Model;

class User extends Model {
    public int $id;
    public string $name;
    public string $email;
}
```

### Validation Using Attributes
You can use validation attributes to mark elements for validation. Let's try using a few attributes to mark our fields:

```php
namespace app\http\models;

use framework\web\models\attributes\Required;
use framework\web\models\attributes\Length;
use framework\web\models\attributes\Email;
use framework\web\models\Model;

class User extends Model {
    public int $id;
    
    #[Required]
    #[Length(min:3, max: 255)]
    public string $name;

    #[Required]
    #[Email]
    #[Length(min:3, max: 255)]
    public string $email;
}
```
### Validation Using Rules
We can also override the `rules` method to provide custom rules for validation. Here's an example of using `rules` to validate email:

```php
class User extends Model {
    public function rules() {
        return [
            'email' => 'email|required'
        ],
    }
}
```

## Building Forms
In order to build a form, we can use `Forms.ActiveForm` widget with our model. Here's a complete example of a simple form built with above widget:

```php 
// HomeController.php
public function index(Request $request) {
    $user = User::from($request);

    if ($request->method() == 'POST' && $user->validate()) {
        echo 'user is valid';
        // Do something with the user
    }
    else {
        return view('users.create', [
            'model' => $model
        ]);
    }
}
```

Now, we can design our view
```html
// users/create.html.php
<Forms.ActiveForm :model="$model" action="/">
    <Forms.TextField name="username" />
    <Forms.TextField name="email" />
    <Layout.Flex justify="end">
        <Forms.Button type="submit" variant="primary">Save</Forms.Button>
    </Layout.Flex>
</Forms.ActiveForm>
```

This would generate a form with consistent styling and automatic validation.