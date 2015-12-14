# Laravel 5 / Lumen 5 Mandrill Webhook Controller
A simple Mandrill webhook controller to help with email events. Useful for notifying users that you cannot reach them via email inside your application. Compatible with Laravel 5+ and Lumen 5+.

## Installation
```composer require eventhomes/laravel-mandrillhooks```

## Basic Usage

1) In your routes.php file add the following.
```php
post('mandrill-webhook', ['as' => 'mandrill.webhook', 'uses' => 'MandrillController@handleWebHook']);
```

2) Create a controller that extends MandrillWebhookController as follows. You can then handle any Mandrillapp webhook event.
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
