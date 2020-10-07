---
extends: _layouts.post
section: content
title: Dive into “Elements and Forms”
date: 2019-09-15
description: Comparing the complexity of the code for different admin panels in laravel
---


The use of automated “Laravel admin areas” can be summarized as “Forms over data” as the main tool is to provide a user interface for viewing, adding, and modifying data.

In this case, the form can consist of many different fields for entering data, so how does such an important element work?

## Field view

Any field in the Orchid Platform is just a setting above the view that passes data to the template. Let's create a new class to see what it consists of:

```php
<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use Orchid\Screen\Field;

/**
 * Class MyField
 */
class MyField extends Field
{
    /**
     * Blade template
     * 
     * @var string
     */
    protected $view = '';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }
}
```


The `view` property defines the Blade template to which the data will be passed, the default values are listed in `attributes`, and `inlineAttributes` defines the keys needed to be specified in HTML format, for example:

```html
First name: <input type="text" name="name"><br>
```

In this example, the inline attribute is a type and the name specified directly in the tag. And the `make()` method is only for quick and convenient initialization since any form that needs to add or change data must have it.
Let's update just the created class and add a template:

```php
// app/Orchid/Fields/MyField.php
declare(strict_types=1);

namespace App\Orchid\Fields;

use Orchid\Screen\Field;

/**
 * Class MyField
 */
class MyField extends Field
{
    /**
     * Blade template
     *
     * @var string
     */
    protected $view = 'myField';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'title' => 'First name'
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'name',
        'type'
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }
}
// resources/views/myField.blade.php
{{$title}}: <input @include('platform::partials.fields.attributes', ['attributes' => $attributes])><br>
```


To try a new field, you need to use the built-in `render()` method:

```php
Route::get('/', function () {
    $input = MyField::make('name');
    
    return $input->render();
});
```


The browser will return the template just specified. Let's try to add some elements:

```php
Route::get('/', function () {
    $input = MyField::make('name')
        ->title('How your name?')
        ->placeholder('Sheldon Cooper')
        ->value('Alexandr Chernyaev');

    return $input->render();
});
```

After we refresh the page, it displays a new title instead of the default one, but neither the placeholder nor the value has been applied. This is because they were not specified in `inlineAttributes`. Let's fix that:

```php
/**
 * Attributes available for a particular tag.
 *
 * @var array
 */
protected $inlineAttributes = [
    'name',
    'type',
    'placeholder',
    'value'
];
```

After that, each attribute will be drawn in our template.


## But how does the form process the data?

In normal use, there is no need to render every element and fill it with data. There is a special builder for this - `Orchid\Screen\Builder`

```php
Route::get('/', function () {

    $fields[] = MyField::make('name');

    $repository = new Repository([
        'name' => 'Alexandr Chernyaev',
    ]);

    $builder = new Builder($fields, $repository);

    return $builder->generateForm();
});
```

Essentially, the builder maps the names from the store to the required form as a value. At the same time, it has the ability to enter into the depth of the object using dot-notation.

```php
Route::get('/', function () {

    $fields[] = MyField::make('name.ru');

    $repository = new Repository([
        'name' => [
            'en' => 'Alexandr Chernyaev',
            'ru' => 'Александр Черняев'
        ],
    ]);

    $builder = new Builder($fields, $repository);

    return $builder->generateForm();
});
```

You can also specify the required language and prefix, for example:

```php
Route::get('/', function () {

    $fields[] = MyField::make('name');

    $repository = new Repository([
        'en' => [
            'name' => 'Alexandr Chernyaev',
        ],
        'ru' => [
            'name' => 'Александр Черняев',
        ]
    ]);

    $builder = new Builder($fields, $repository);
    $builder->setLanguage('en');

    return $builder->generateForm();
});
```

## And it's all?

That's right. This is exactly the approach used in the Orchid admin panel for Laravel when rendering screens and allowing you to automate the construction of forms with data.
