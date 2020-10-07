---
extends: _layouts.post
section: content
title: Draw model charts
date: 2020-08-05
description: Let's try it in action and form a visual dynamics of user registrations
cover_image: /assets/img/draw-model-charts/x4w1qcdys4p2qtu9ect8.png
---

Building charts can be awkward, but since `7.15.0`, a trait has been added to [Laravel Orchid](http://orchid.software/) to generate group and time data.
To use it, you should add the trait `Orchid\Metrics\Chartable` to the model.

Let's try it in action and form a visual dynamics of user registrations. To do this, let's create a new layer using the command:

```php
 php artisan orchid:chart DynamicsOfRegistrations
```

In `app/Orchid/Layouts` directory, a new class will be created, we will add the name and the target key to it:

```php
namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Chart;

class DynamicsOfRegistrations extends Chart
{
    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'New members';

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the. Wet.
     *
     * @var string
     */
    protected $target = 'registrations';
}
```

The standard package comes with a screen displaying all users. Why not use it. Let's add a new query value to the `UserListScreen`:

```php
public function query(): array
{
    return [
        'registrations' => [
            User::countByDays()->toChart('Users'),
        ],
        // ... other values
    ]
}
```

All that's left is to put a layer on the screen:

```php
public function layout(): array
{
    return [
        DynamicsOfRegistrations::class,
        // ... other layouts
    ];
}
```

Now going to the user list page, we will see how many users have registered in the last month:

![Dynamics Of Registrations](/assets/img/draw-model-charts/x4w1qcdys4p2qtu9ect8.png)

That's great. But let's also show the statistics of how many users have enabled two-factor authentication (by the way, here is an [article on how to enable it](https://dev.to/tabuna/how-to-enable-two-factor-authentication-in-laravel-orchid-2eim)). For this, we will also create a new layer, but with different values:

```php
namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Chart;

class UsageTwoFactorAuth extends Chart
{
    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'Usage two-factor authentication';

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'pie';

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the chart.
     *
     * @var string
     */
    protected $target = 'usageTwoFactorAuth';
}
```

The output of the request will be slightly different:

```php
public function query(): array
{
    $usageTwoFactorAuth = User::countForGroup('uses_two_factor_auth')
        ->toChart(function (bool $state) {
            return $state ? 'Enabled' : 'Disabled';
        });
    
    
    return [
        'usageTwoFactorAuth' => $usageTwoFactorAuth,
        // ...
    ]
}
```

Let's not forget to bring out the layer created:

```php
public function layout(): array
{
    return [
        DynamicsOfRegistrations::class,
        UsageTwoFactorAuth::class
        // ... other layouts
    ];
}
```

Now, going to the user list page, we will also see the ratio of users who have enabled two-factor authentication:

![UsageTwoFactorAuth](/assets/img/draw-model-charts/t3alibhlbh3ggswv616r.png)

That's it! Our minimum example is ready. You can learn more about building charts on the [documentation page](https://orchid.software/en/docs/layouts/charts).
