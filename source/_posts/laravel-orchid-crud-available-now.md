---
extends: _layouts.post
section: content
title: Laravel Orchid CRUD Available Now
date: 2020-11-05
description: We have created a new package aimed at developers who want to quickly create a user interface for eloquent models with functions such as creating, reading, updating, and deleting
cover_image: /assets/img/laravel-orchid-crud-available-now/crud.jpg
---

Last month, we announced a new package for developers looking to quickly create a user interface for eloquent models with features like create, read, update, and delete.

We now cover not only complex administration systems but also effective for home projects. So, you can create a simple application in no time with auto-generated CRUD views for each of your models for starters. But then you can go ahead and customize these views and forms as needed.

## How it works?

Laravel Orchid CRUD follows general industry guidelines *(Hi Nova, Backpack, SleepingOwl)*, where you describe the entire process in one file called a resource.

<iframe width="100%" height="400" src="https://www.youtube.com/embed/SukE7tNdU7A" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

## Defining Resources

Resources are stored in the `app/Orchid/Resources` directory of your application.
You may generate a new resource using the `orchid:resource` Artisan command:

```bash
php artisan orchid:resource PostResource
```

The most basic and fundamental property of a resource is its `model` property. 
This property tells the generator which Eloquent model the resource corresponds to:

```php
use App\Models\Post;

/**
 * The model the resource corresponds to.
 *
 * @var string
 */
public static $model = Post::class;
```

Freshly created resources contain nothing. Don't worry, we'll add more fields to our resource soon.

## Expanding of Model

Many features of the Orchid platform relies on model customization. You can add or remove traits depending on your goals. But we will assume that you have set these for your model:

```php
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use AsSource, Filterable, Attachable;
}
```


## Registering Resources

By default, all resources within the `app/Orchid/Resources` directory will automatically be registered.
You are not required to manually register them.


## Permissions Resources

Each resource contains a `permission` method. Which should return the string key that the user needs to access this resource. By default, all resources are available to every user.

```php
/**
 * Get the permission key for the resource.
 *
 * @return string|null
 */
public static function permission(): ?string
{
    return null;
}
```

For each registered resource in which the method returns a non-null value, a new permission is created. 

```php
/**
 * Get the permission key for the resource.
 *
 * @return string|null
 */
public static function permission(): ?string
{
    return 'private-post-resource';
}
```

It is necessary to give the right to manage it to the user.
To click on the profile in the left column, go to the system page, and then to the page with users, 
you can issue them a mandate or assign a role. After that, they will be displayed in the left menu.

## Defining Fields

Each resource contains a `fields` method. This method returns an array of fields, which generally extend the `Orchid\Screen\Field` class. To add a field to a resource, we can add it to the resource's `fields` method. Typically, fields may be created using their static `make` method. This method accepts several arguments; however, you usually only need to pass the field's name.


```php
use Orchid\Screen\Fields\Input;

/**
 * Get the fields displayed by the resource.
 *
 * @return array
 */
public function fields(): array
{
    return [
        Input::make('title')
            ->title('Title')
            ->placeholder('Enter title here'),
    ];
}
```
In the package to generate CRUD, you can use the fields Orchid platform. Review [all available fields on the documentation site](https://orchid.software/en/docs/field/).


## Defining Сolumns

Each resource contains a `сolumns` method. To add a column to a resource, we can add it to the resource's `column` method. Typically, columns may be created using their static `make` method. 

```php
use Orchid\Screen\TD;

/**
 * Get the columns displayed by the resource.
 *
 * @return TD[]
 */
public function columns(): array
{
    return [
        TD::set('id'),
        TD::set('title'),
    ];
}
```
The CRUD generation package is entirely based on the table layer. You can [read more about this on the documentation page](https://orchid.software/en/docs/table/).

## Defining Rules

Each resource contains a `rules` method. When submitting a create or update form, the data can be validated, which is described in the `rules` method:

``` php
/**
 * Get the validation rules that apply to save/update.
 *
 * @return array
 */
public function rules(Post $model): array
{
    return [
        'slug' => [
            'required',
            Rule::unique(Post::class, 'slug')->ignore($model),
        ],
    ];
}
```

You can learn more on the Laravel [validation page](https://laravel.com/docs/validation#available-validation-rules).


## Defining Filters

Each resource contains a `filters` method. Which expects you to return a list of class names that should be rendered and, if necessary, swapped out for the viewed model.

``` php
/**
 * Get the filters available for the resource.
 *
 * @return array
 */
public function filters(): array
{
    return [];
}
```

To create a new filter, there is a command:

```bash
php artisan orchid:filter QueryFilter
```

This will create a class filter in the `app/Http/Filters` folder. To use filters in your own resource, you need:

```php
public function filters(): array
{
    return [
        QueryFilter::class
    ];
}
```

You can learn more on the Orchid [filtration page](https://orchid.software/en/docs/filters/#eloquent-filter).

## Eager Loading

Suppose you routinely need to access a resource's relationships within your fields. In that case, it may be a good idea to add the relationship to the `with` property of your resource. This property instructs to always eager to load the listed relationships when retrieving the resource.

```php
 /**
 * Get relationships that should be eager loaded when performing an index query.
 *
 * @return array
 */
public function with(): array
{
    return ['user'];
}
```

## Resource Events

Each resource has two methods that do the processing, `onSave` and `onDelete`. Each of them is launched when the event is executed, and you can change or supplement the logic:

``` php
/**
 * Action to create and update the model
 *
 * @param ResourceRequest $request
 * @param Model           $model
 */
public function onSave(ResourceRequest $request, Model $model)
{
    $model->forceFill($request->all())->save();
}

/**
 * Action to delete a model
 *
 * @param Model $model
 *
 * @throws Exception
 */
public function onDelete(Model $model)
{
    $model->delete();
}
```

## Localization

Resource names may be localized by overriding the `label` and `singularLabel` methods on the resource class:

``` php
/**
 * Get the displayable label of the resource.
 *
 * @return string
 */
public static function label()
{
    return __('Posts');
}

/**
 * Get the displayable singular label of the resource.
 *
 * @return string
 */
public static function singularLabel()
{
    return __('Post');
}
```

Action buttons and notifications can also be translated, for example:

```php
/**
 * Get the text for the create resource button.
 *
 * @return string|null
 */
public static function createButtonLabel(): string
{
    return __('Create :resource', ['resource' => static::singularLabel()]);
}

/**
 * Get the text for the create resource toast.
 *
 * @return string
 */
public static function createToastMessage(): string
{
    return __('The :resource was created!', ['resource' => static::singularLabel()]);
}
```

You can learn more on the [Laravel localization page](https://laravel.com/docs/localization).


## What if I need more?

When you need more options, it's easy to switch to using the platform. All fields, filters, and characteristics are compatible.

## How can I get this?

As stated earlier, we decided to try the Sponsorware license. Only monthly subscribers to "Open Collective" will have access to the private git repository.

<a href="https://opencollective.com/orchid#backers" target="_blank"><img src="https://opencollective.com/orchid/backers.svg?width=838"></a>

Once you become a sponsor, we will send an invite to the GitHub group to the email address provided within 24 hours. After 15 or more monthly sponsors, the package will be open to everyone under the MIT license!
