# Удобные системные сообщения для Laravel

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Laravel Version](https://img.shields.io/badge/laravel-5.1-orange.svg?style=flat-square)](http://laravel.com)
[![Packagist](https://img.shields.io/packagist/dt/gaaarfild/laravel-notifications.svg)]()
[![Licence](https://img.shields.io/packagist/l/gaaarfild/laravel-notifications.svg)](https://github.com/gaaarfild/laravel-notifications/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/gaaarfild/laravel-notifications.svg)](https://travis-ci.org/gaaarfild/laravel-notifications)

![Laravel Notifications](notifications.png)

[English Documentation / Английская документация](https://github.com/gaaarfild/laravel-notifications/blob/master/README.md)

Система уведомлений для Laravel 5.

Часто, после сохранения каких либо данных пользователя, вам необходимо перенаправить его на определенную страницу и сообщить ему, что все сохранено успешно, либо возникли какие-то ошибки.

Теперь вы можете сделать это легче и быстрее.

## Установка

Добавьте строчку

``` JSON
"gaaarfild/laravel-notifications": "~1.0"
```

в ваш файл `composer.json` в секцию `require`.

После этого наберите в консоли

``` BASH
$ composer update
```

Когда завершится обновление, добавьте в файл `config/app.conf` в секцию `providers`

``` PHP
'providers' => [
    // ...
    Gaaarfild\LaravelNotifications\LaravelNotificationsServiceProvider::class,
]
```

Если вы хотите использовать фасад `Notifications`, добавьте следующее в этом же файле в секции `aliases`

``` PHP
'aliases' => [
    // ...
  'Notifications' => Gaaarfild\LaravelNotifications\NotificationsFacade::class,
]
```

Чтобы иметь возможность задавать собственный шаблон вывода сообщений, наберите в консоли:

`php artisan vendor:publish`

Теперь вы сможете указать в файле конфигураци `laravel-notifications.php` 
любой удобный вам шаблон для отображения сообщений.


## Использование

### Создать сообщение для отображения на следующей странице

``` php
Notifications::add('Your message text', 'type', 'group');
```

Параметр `$type` используется специально для Twitter Bootstrap. Он отображает алерт-боксы с соответствующим классом.

Например, если вы задали `type` как `danger`, то при использовании метода `toHTML()` по умолчанию
будет отображен алерт-бокс с классом `alert alert-danger`.

Параметр `$group`, группирует сообщения по группам. :) 
Это нужно, чтобы вы могли при отображении сообщений, фильтровать их по группам, 
например, отображая определенные группы в определенном месте страницы.


Так же можно использовать более удобные методы создания сообщений:

``` php
    Notifications::info('Your message text', 'group');
    Notifications::success('Your message text', 'group');
    Notifications::warning('Your message text', 'group');
    Notifications::danger('Your message text', 'group');
    Notifications::error('Your message text', 'group');
```


### Получение сообщений

#### Все сообщения

``` PHP
Notifications::all()->get();
```

#### Сообщения только определенной группы

``` PHP
Notifications::byGroup('my-group')->get();
```

#### Сообщения только определенного типа

``` PHP
Notifications::byType('warning')->get();
```

### Форматирование сообщений

Вы так же можете отформатировать сообщения

#### JSON

Получить и отформатировать все сообщения в JSON.

``` PHP
Notifications::all()->toJson();
```

Или отфильтровать их по группе или типу.

``` PHP
Notifications::byType('success')->toJson();

Notifications::byGroup('login')->toJson();
```


#### Отобразить с помощью шаблонизатора Blade

Вы так же можете отформатировать сообщения с помощью шаблонизатора Blade.

``` PHP
Notifications::all()->toHTML();
```

И конечно же можете их отфильтровать по группе и типу

``` PHP
Notifications::byType('info')->toHTML();

Notifications::byGroup('registration')->toHTML();
```

По умолчанию используется Twitter Bootstrap 3.

Требуется [Twitter Bootstrap](http://getbootstrap.com).

### Прочее

#### Количество сообщений

``` PHP
Notifications::all()->count();
```

#### Проверить на наличие сообщений

``` PHP
Notifications::all()->has();
```

#### Получить первое сообщение

``` PHP
Notifications::all()->first();
```

#### Использование в Form Request

Если вы хотите отображать ошибки через Laravel Form Request, 
то необходимо переопределить метод `formatErrors()` в вашей реализации Form Request.

``` PHP

    public function formatErrors(Validator $validator){
        foreach ($validator->errors()->all() as $error) {
            Notifications::add($error, 'danger');
        }

        return $validator->errors()->getMessages();
    }

```

Не забудьте импортировать класс `Validator` в заголовке вашего файла:

`use Illuminate\Contracts\Validation\Validator;`

## Помощь в разработке

Мы будем рады любой помощи в разработке.

Присылайте ваши пулл реквесты в ветку `master`.

## Лицензия

Лицензия MIT. Ознакомиться можно [здесь](https://github.com/gaaarfild/laravel-notifications/blob/master/LICENSE).

