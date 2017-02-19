# IMVK
[![Latest Stable Version](https://poser.pugx.org/create-sites/imvk/v/stable)](https://packagist.org/packages/create-sites/imvk)
[![Total Downloads](https://poser.pugx.org/create-sites/imvk/downloads)](https://packagist.org/packages/create-sites/imvk)
[![Latest Unstable Version](https://poser.pugx.org/create-sites/imvk/v/unstable)](https://packagist.org/packages/create-sites/imvk)
[![License](https://poser.pugx.org/create-sites/imvk/license)](https://packagist.org/packages/create-sites/imvk)

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

Register on the <a href="https://pusher.com">pusher.com</a> and add this line on your ``` .env ``` file with your configurations:

```php
PUSHER_APP_ID=your_pusher_id
PUSHER_KEY=your_pusher_key
PUSHER_SECRET=your_pusher_secret
```

Run the console command: 
```bach
php artisan migrate
```
and add in your ```resources/assets/js/app.js``` new component:
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