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

Event type                  | Description 
------------                |---------------
Sent	                    | message has been sent successfully
Bounced	                    | message has hard bounced
Opened	                    | recipient opened a message; will only occur when open tracking is enabled
Marked As Spam	            | recipient marked a message as spam
Rejected	                | message was rejected
Delayed	                    | message has been sent, but the receiving server has indicated mail is being delivered too quickly and Mandrill should slow down sending temporarily
Soft-Bounced	            | message has soft bounced
Clicked	                    | recipient clicked a link in a message; will only occur when click tracking is enabled
Recipient Unsubscribes      | recipient unsubscribes
Rejection Blacklist Changes	| triggered when a Rejection Blacklist entry is added, changed, or removed
Rejection Whitelist Changes	| triggered when a Rejection Whitelist entry is added or removed
