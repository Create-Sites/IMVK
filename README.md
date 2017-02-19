# IMVK
[![Latest Version on Packagist](https://img.shields.io/packagist/v/create-sites/imvk.svg?style=flat-square)](https://packagist.org/packages/create-sites/imvk)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/create-sites/imvk/master.svg?style=flat-square)](https://travis-ci.org/Create-Sites/IMVK)
[![Total Downloads](https://img.shields.io/packagist/dt/create-sites/imvk.svg?style=flat-square)](https://packagist.org/packages/create-sites/imvk)

## Install

Enter in your console this command: 
```bash
composer require create-sites/imvk --dev
```

Next up, the service provider must be registered:

```php
'providers' => [
    ...
    CreateSites\IMVK\IMVKServiceProvider::class,

];
```

And publish the config file:
```bash
php artisan vendor:publish --provider="CreateSites\IMVK\IMVKServiceProvider"
```
Run the console command: 
```bach
php artisan migrate
```
and add in your ```resources/assets/js/app.js``` new component
```vue
Vue.component('chat-messages', require('./components/ChatMessages.vue'));
```

after include component run command:<br>
if laravel 5.3:
```bach
gulp
```

or if laravel 5.4 or later run:
```bach
npm run dev
```

## Usage
View all messages:
```php
<a class="button-notifications item" href="{{ route('messages.all') }}">All messages</a>
```
and add button send message 
 ```php
<a href="{{ route('messages.show', $user->id) }}" class="btn green">Write message</a>
```