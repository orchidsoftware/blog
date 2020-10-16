---
extends: _layouts.post
section: content
title: Authenticate with Jetstream
date: 2020-10-16
description: Install Jetstream along with the Laravel Orchid Platform. Change the input and set up two-factor authentication.
cover_image: /assets/img/authenticate-with-jetstream/lock.jpg
---


With the release of Laravel 8, the development team has released a new starter kit [Jetstream](https://github.com/laravel/jetstream). It is a replacement for the `laravel/ui` package. This is a significant change for which, in fact, it was impossible to prepare in advance. New product releases are hidden and not shown until the release.
       
Some of Orchid's features have started to compete with official packages like two-factor authentication. Therefore they were removed in the major release.
It would be cool to parse how now you can entirely create your own authorization page, the two-factor authentication setup. Let's do it together now.

First, we'll install the Laravel app:

```bash
composer create-project laravel/laravel orchid-project "8.*" --prefer-dist
```

Then we will install the Jetstream package using the Composer command:

```bash
composer require laravel/jetstream
``` 

Then we run the Artisan command:
```bash
php artisan jetstream:install livewire
```
This command will directly install the scaffolding on the Livewire stack.
Upon completion of the installation, you will be asked to run:
```bash
npm install && npm run dev
```
This is necessary to install and collect CSS/JS  resources.

We now have login and edit pages. As well as profile pages, two-factor authentication settings, session viewing, etc.

Now is the time to install Orchid:
```bash
composer require orchid/platform
```

Then also execute the Artisan command:
```php
php artisan orchid:install
```

Unfortunately, both packages' scaffolding overwrites the `app/Models/User` user model to add new features to the class. And we need to adjust it ourselves:

```php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Platform\Models\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
```

Both apps are working fine now. But we have two whole login pages. Since the Orchid login page is not expected to undergo any significant changes, let's disable it. To do this, change the setting in the configuration file located in `config/platform.php`


```php

/*
|--------------------------------------------------------------------------
| Auth Page
|--------------------------------------------------------------------------
|
| The property controls the visibility of Orchid's built-in authentication pages.
| You can disable this page and use your own set like 'Jetstream'
|
| You can learn more here: https://laravel.com/docs/authentication
|
*/

'auth'  => false,
```

After that, when navigating to `/admin`, the Orchid login page will not be shown. Instead, the user will be redirected to the Jetstream page.

That's all. In the same way, the algorithm will work if you enter any other package for scaffolding authorization. For example `laravel/ui` or `laravel/fortify`.
