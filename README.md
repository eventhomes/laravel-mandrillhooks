# Laravel 5 / Lumen 5 Mandrill Webhook Controller
[![Latest Version](https://img.shields.io/github/release/eventhomes/laravel-mandrillhooks.svg?style=flat-square)](https://github.com/eventhomes/laravel-mandrillhooks/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/eventhomes/laravel-mandrillhooks.svg?style=flat-square)](https://packagist.org/packages/eventhomes/laravel-mandrillhooks)

A simple Mandrill webhook controller to help with email events. Useful for notifying users that you cannot reach them via email inside your application. Compatible with Laravel 5+ and Lumen 5+.

## Installation
```composer require eventhomes/laravel-mandrillhooks```

## Basic Usage

1) Create a controller that extends MandrillWebhookController as follows. You can then handle any Mandrillapp webhook event.
```php
use EventHomes\Api\Webhooks\MandrillWebhookController;

class MyController extends MandrillWebhookController {

    /**
     * Handle a hard bounced email
     *
     * @param $payload
     */
    public function handleHardBounce($payload)
    {
        $email = $payload['msg']['email'];
    }

    /**
     * Handle a rejected email
     *
     * @param $payload
     */
    public function handleReject($payload)
    {
        $email = $payload['msg']['email'];
    }
}
```

2) Create the route to handle the webhook. In your routes.php file add the following.
```php
post('mandrill-webhook', ['as' => 'mandrill.webhook', 'uses' => 'MandrillController@handleWebHook']);
```

## Webhook Authentication
Publish the configuration via
```php
php artisan vendor:publish --provider="EventHomes\Api\Webhooks\MandrillWebhookServiceProvider"
```
Simply add your Mandril webhook key in the config file and requests will be authenticated.

## Webhook Events
[Webhook event types](https://mandrill.zendesk.com/hc/en-us/articles/205583217-Introduction-to-Webhooks#event-types):

Event type              | Method             | Description
------------            |------------        |---------------
Sent	                | handleSend()       | message has been sent successfully
Bounced	                | handleHardBounce() | message has hard bounced
Opened	                | hadleOpen()        | recipient opened a message; will only occur when open tracking is enabled
Marked As Spam	        | handleSpam()       | recipient marked a message as spam
Rejected	            | handleReject()     | message was rejected
Delayed	                | handleDeferral()   | message has been sent, but the receiving server has indicated mail is being delivered too quickly and Mandrill should slow down sending temporarily
Soft-Bounced	        | handleSoftBounce() | message has soft bounced
Clicked	                | handleClick()      | recipient clicked a link in a message; will only occur when click tracking is enabled
Recipient Unsubscribes  | handleUnsub()      | recipient unsubscribes
Rejection Blacklist Changes	| handleBlacklist()  | triggered when a Rejection Blacklist entry is added, changed, or removed
Rejection Whitelist Changes	| handleWhitelist()  | triggered when a Rejection Whitelist entry is added or removed

## Contributers
Special thanks to @rafaelbeckel and @minioak!
