# Laravel Convenient System notifications

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Laravel Version](https://img.shields.io/badge/laravel-5-orange.svg?style=flat-square)](http://laravel.com)

Notification system for Laravel 5.

After saving some data from user, often, you have to redirect to proper page ans notificate user, that everything done successfully, or, some errors appeared.

Now you can do this more convenient and easy.

## Install

Add

``` JSON
"gaaarfild/laravel-notifications": "dev-master"
```

to your `composer.json` file into `require` section.

Then type in console

``` BASH
$ composer update
```

When update completed, add to your `config/app.conf` file to `providers` section

``` PHP
'providers' => [
    // ...
    Gaaarfild\LaravelNotifications\LaravelNotificationsServiceProvider::class,
]
```

If you want to use `Notifications` facade, add to same file at the `aliases` section

``` PHP
'aliases' => [
    // ...
  'Notifications' => Gaaarfild\LaravelNotifications\NotificationsFacade::class,
]
```

## Usage

### Save messages for the next request

``` php
Notifications::set('Your message text', 'type', 'group');
```

`$type` param used especially for Twitter Bootstrap render. It displays alerts with respective class.
 
i.e. If you set `type` to `danger`, alert with class 'alert alert-danger' will be generated on `toBootstrap()` formate method.

`$group` param groups messages to groups. :) On the next Request you can retrieve them by group.


### Retrieving messages

#### All messages

``` PHP
Notifications::all()->get();
```

#### Messages by group

``` PHP
Notifications::byGroup()->get();
```

#### Messages by type

``` PHP
Notifications::byType()->get();
```

### Format messages

You also can format messages

#### JSON

``` PHP
Notifications::all()->toJson();
```

#### Twitter Bootstrap Alerts

``` PHP
Notifications::all()->toBootstrap();
```

[Twitter Bootstrap](http://getbootstrap.com) required.


## Contributions

Contributions are highly appreciated.

Send your pull requests to `master` branch.


## License

The MIT License (MIT). Please see [License File](https://github.com/gaaarfild/laravel-notifications/blob/master/LICENSE) for more information.

