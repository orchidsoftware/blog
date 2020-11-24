---
extends: _layouts.post
section: content
title: Actions with a confirm dialog
date: 2020-11-24
description: Learn how to use confirmation dialog in Laravel Orchid.
cover_image: /assets/img/confirm-actions/confirm.png
---


Most web applications require the user to perform some action, such as saving or modifying data. It will be a shame if the action is performed by mistake. To avoid this, a confirmation dialog is a popular solution. In which the user is asked to confirm their actions before performing them.
  
 This article provides a brief introduction to confirmation dialog boxes for what they should and shouldn't contain, typical use cases.

> Since version 9.10.0 confirmation window has been added to Laravel Orchid

Confirmation dialogs usually have the same three parts as most other dialogues:

- Headline - It could be a simple "Are you sure?" and most often a button to close the dialog.
- Content - the section describes the consequences of the action.
- The footer consists of two buttons: one to confirm and the other to cancel the operation.


## Dialog example

Each dialog, called using the `confirm` method of the `Button` class, will create a dialog box, as well as handle its behavior when the button is clicked.

```php
use Orchid\Screen\Actions\Button;

Button::make('Remove')
    ->confirm('Description of the consequences of removal...')
    ->method('remove');
```

For different confirmation dialog boxes, only the description of the consequences of execution changes.

> *Caution.* The passed string will not be escaped

It is safe to use such a call many times, for example in tables, since instead of creating many dialog boxes, the description value will be inserted into a prepared dialog.
