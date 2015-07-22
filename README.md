# Laravel 5 / Lumen 5 Mandrill Webhook Controller
A simple Mandrill webhook controller to help with events. Compatible with Laravel 5+ and Lumen 5+.

## Installation
```composer require eventhomes/laravel-mandrillhooks```

## Basic Usage
```php
...
use EventHomes\Api\Webhooks\MandrillWebhookController;

class MyController extends MandrillWebhookController {

    private function handleHardBounce($payload)
    {
        $email = $payload['msg']['email'];
    }

    private function handleReject($payload)
    {
        $email = $payload['msg']['email'];
    }
}
```