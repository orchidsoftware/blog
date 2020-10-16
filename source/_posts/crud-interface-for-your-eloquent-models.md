---
extends: _layouts.post
section: content
title: CRUD interface for your Eloquent models
date: 2020-10-17
description: New package to create CRUD based on Laravel Orchid
cover_image: /assets/img/crud-interface-for-your-eloquent-models/box.jpg
---

Recently, I had an interesting dialogue with my colleague Pavel. In which we discussed his new project.
It was necessary to develop a service for a company engaged in the construction and supply of equipment. But the managers and owners weren't sure how far they wanted to go with this hiring him at an hourly rate.

Since he was a power user of Laravel Orchid, the whole panel was built on this package. In the end, he didn't have to create a complex system for tracking equipment shipments or purchases. It was just a very basic CRUD. All of its screens were almost the same, only fields and Eloquent models changed. In fact, he could have taken a backpack/nova/voyager or whatever to solve this problem.

At that moment, we decided to try to write a package for CRUD based on Orchid. Surprisingly, this turned out to be easy since we already had different layers and many fields, and a filtering mechanism. In fact, we were able to use all of these things both in the platform package and for our new CRUD package while maintaining all the compatibility. That is, any fields/filters can be used both there and there.

The use process is not much different from nova/backpack/sleepingowl and others. But at the same time, I think it can be a great addition to our toolbox. Because when using alternative packages, you can achieve some maximum. After this, you will need to switch to stronger tools or even write everything yourself to fulfill the requirements.

**It doesn't have to be that way now**. You can take one Orchid and use it only as a CRUD, but as soon as you need to do a little more, change the writing style to Screens. **At the same time, keeping your previous developments, as they are compatible**.

### What does it look like?

We chose to describe the entire CRUD scheme in one file called 'Resource', this is how it looks:

```php
namespace App\Orchid\Resources;

use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\TD;

class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

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

            TextArea::make('description')
                ->horizontal()
                ->title('Description')
                ->rows(3)
                ->maxlength(200)
                ->placeholder('Brief description for preview'),

            Quill::make('body')
                ->horizontal()
                ->title('Main text'),
        ];
    }

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
            TD::set('description'),
        ];
    }

    /**
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'       => 'string|required',
            'description' => 'string|required',
            'body'        => 'string|required',
        ];
    }
}
```

When creating a resource, it is automatically registered in the menu and restricted in access permissions.

### How can I get this?

Currently, the package does not yet have a stable version, but we plan to announce it next month. In the beginning, the package will not be open to everyone and distributed free of charge. Instead, we want to try the Sponsorware license. Only monthly subscribers to "Open Collective" will have access to the private git repository.

<a href="https://opencollective.com/orchid#backers" target="_blank"><img src="https://opencollective.com/orchid/backers.svg?width=838"></a>

As soon as you become a sponsor, we will send an invitation to the GitHub group to the specified mailing address within 24 hours. Now! Once we have recruited 15 monthly sponsors. The package will be open to everyone under the MIT license!
