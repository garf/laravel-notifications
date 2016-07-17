# Laravel Convenient System Notifications

[![Laravel Version](https://img.shields.io/badge/laravel-5.1-orange.svg?style=flat-square)](http://laravel.com)
[![Packagist](https://img.shields.io/packagist/dt/garf/laravel-notifications.svg)]()
[![Licence](https://img.shields.io/packagist/l/garf/laravel-notifications.svg)](https://github.com/garf/laravel-notifications/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/garf/laravel-notifications.svg)](https://travis-ci.org/garf/laravel-notifications)

![Laravel Notifications](notifications.png)

[Russian Documentation / Русская документация](https://github.com/garf/laravel-notifications/blob/master/README-ru.md)

Notification system for Laravel 5.

Often after saving some data from user you have to redirect to proper page and notificate user that everything done successfully or some errors appeared.

Now you can do this more convenient and easy way.

## Install

To install, execute the following command in the console:

``` BASH
$ composer require "garf/laravel-notifications:2.*"
```

When completed, add to your `config/app.php` file in the `providers` section

``` PHP
'providers' => [
    // ...
    Garf\LaravelNotifications\LaravelNotificationsServiceProvider::class,
]
```

If you want to use `Notifications` facade, add to same file at the `aliases` section

``` PHP
'aliases' => [
    // ...
  'Notifications' => Garf\LaravelNotifications\NotificationsFacade::class,
]
```

To change the templates, please execute the following command in the console:

`php artisan vendor:publish --provider="Garf\LaravelNotifications\LaravelNotificationsServiceProvider" --tag="config"`

Now you will be able to set any view file for notifications render in `config/laravel-notifications.php`.

Optionally you can execute the following command in the console to edit the default template, instead of using your own:

`php artisan vendor:publish --provider="Garf\LaravelNotifications\LaravelNotificationsServiceProvider" --tag="views"`

Note: If you publish the view and edit it, do not change the name of the view in the config file.

## Usage

### Save messages for the next request

``` php
Notifications::add('Your message text', 'type', 'group');
```

`$type` param used especially for Twitter Bootstrap render. It displays alerts with respective class.

i.e. If you set `type` to `danger`, alert with class 'alert alert-danger' will be generated on `toBootstrap()` format method.

`$group` param groups messages to groups. :) On the next Request you can retrieve them by group.

Also more convenient aliases can be used:

``` php
    Notifications::info('Your message text', 'group');
    Notifications::success('Your message text', 'group');
    Notifications::warning('Your message text', 'group');
    Notifications::danger('Your message text', 'group');
    Notifications::error('Your message text', 'group');
```


### Retrieving messages

#### All messages

``` PHP
Notifications::all()->get();
```

#### Messages by group

``` PHP
Notifications::byGroup('my-group')->get();
```

#### Messages by type

``` PHP
Notifications::byType('warning')->get();
```

### Format messages

You also can format messages

#### JSON

You can retrieve and format all messages as JSON

``` PHP
Notifications::all()->toJson();
```

Or can filter them by group or type

``` PHP
Notifications::byType('success')->toJson();

Notifications::byGroup('login')->toJson();
```


#### Render with blade view files

You can also render your notifications with custom view files

``` PHP
{{ Notifications::all() }}
```

And you can filter them by group or type as well:


``` PHP
{{ Notifications::byType('info') }}

{{ Notifications::byGroup('registration') }}
```

by default method uses Twitter Bootstrap alerts format.

[Twitter Bootstrap](http://getbootstrap.com) can be required.

### Other

#### Count Messages

``` PHP
Notifications::all()->count();
```

#### Check if messages exist

``` PHP
Notifications::all()->has();
```

#### Get First Message

``` PHP
Notifications::all()->first();
```

#### Form Request usage
If you want to display errors via Laravel Form Request, you have to override method `formatErrors()` in your Form Request Class.

``` PHP

    public function formatErrors(Validator $validator){
        foreach ($validator->errors()->all() as $error) {
            Notifications::add($error, 'danger');
        }

        return $validator->errors()->getMessages();
    }

```
Don't forget to import `Validator` class in head of the file:

`use Illuminate\Contracts\Validation\Validator;`

## Contributions

Contributions are highly appreciated.

Send your pull requests to `master` branch.


## License

The MIT License (MIT). Please see [License File](https://github.com/garf/laravel-notifications/blob/master/LICENSE) for more information.

