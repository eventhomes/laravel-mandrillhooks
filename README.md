# Laravel 5 / Lumen 5 Mandrill Webhook Controller
A simple Mandrill webhook controller to help with email events. Useful for notifying users that you cannot reach them via email inside your application. Compatible with Laravel 5+ and Lumen 5+.

## Installation
```composer require eventhomes/laravel-mandrillhooks```

## Basic Usage
```php
...
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