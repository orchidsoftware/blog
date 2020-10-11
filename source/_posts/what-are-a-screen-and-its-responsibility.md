---
extends: _layouts.post
section: content
title: What are a Screen and its responsibility?
date: 2020-10-11
description: This is all that you see on the work area of an open web page.
cover_image: /assets/img/what-are-a-screen-and-its-responsibility/diego-gonzalez--I8lDurtfAo-unsplash.jpg
---

The screen is a rather unusual term for web developers. It means a unique set of components that a user can see on a page.

For example, when building a simple blog, we will have only two unique pages. Home and page to display text. In fact, we have just two screens. There can be as many pages in our blog as you want. But there are only two truly unique screens.

Let's continue the blog analogy. Each of our pages has a header, menu, footer. And all changes to the input of the transfer and views take place in the workspace. In the Laravel Orchid admin panel, the `Screen` class is intended to control this workspace.

Now that we've clarified a bit what the screen is, we can go deeper. A good question may arise here: The workspace of an application usually contains a lot of logic, somewhere you need to take values from the database, somewhere to display them in a table. Is it possible to unite this? Don't get the noodle code?

In fact, the responsibility is divided. Let's try to understand how popular single-page applications work. Some script accesses the service `API` for data and receives a `JSON` response where all the information is contained to display the content. Something like this:

```json
[
  {
    "id": 1,
    "title": "sunt aut facere repellat provident occaecati...",
    "body": "quia et suscipit suscipit recusandae ..."
  },
  {
    "id": 2,
    "title": "qui est esse",
    "body": "est rerum tempore vitae sequi sin..."
  },
  {
    "id": 3,
    "title": "ea molestias quasi exercitationem repellat...",
    "body": "et iusto sed quo iure voluptatem occaecati omnis..."
  },
  ...
```

In fact, this `API` prepares all the necessary information that might be required to display a blog post. By the same endpoint principle, Orchid screens have a `query` method to prepare all the information.


```php
/**
 * Query data
 *
 * @return array
 */
public function query(): array
{
  return [
    'posts' => [
      new Repository([
        "id"    => 1,
        "title" => "sunt aut facere repellat provident occaecati...",
        "body"  => "quia et suscipit suscipit recusandae ...",
      ]),
      new Repository([
        "id"    => 2,
        "title" => "qui est esse",
        "body"  => "est rerum tempore vitae sequi sin...",
      ]),
      new Repository([
        "id"    => 3,
        "title" => "ea molestias quasi exercitationem repellat...",
        "body"  => "et iusto sed quo iure voluptatem occaecati omnis...",
      ]),
    ]
  ];
}
```

After receiving `JSON` in single-page apps start to render this,
for example, using `front-end` frameworks, create some templates.

The same templates we have in Laravel Orchid screens expect you to pass them in the layouts method. For example, let's make a table (`php artisan orchid: table ExampleTable`):

```php
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

class BlogListLayout extends Table
{
  /**
   * Data source.
   *
   * @var string
   */
  protected $target = 'posts';

  /**
   * @return TD[]
   */
  protected function columns() : array
  {
    return [
        TD::set('id'),
        TD::set('title'),
        TD::set('body'),
    ];
  }
}
```

In `target`, we indicated which prepared value (from `query`) needs to be passed to our template and declared the columns in our table.

Now all that remains is to indicate the created template in the screen class:

```php
/**
 * Views
 *
 * @return array
 */
public function layout() : array
{
    return [
        BlogListLayout::class
    ];
}
```

In fact, the screen united but did not take on unnecessary responsibility.
If you follow which, you will not have code noodles. At the same time, just by looking at the screen code, you will already know what data and where it receives from and what templates will be displayed.
