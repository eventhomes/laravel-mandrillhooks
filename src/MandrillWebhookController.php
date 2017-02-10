<?php

namespace EventHomes\Api\Webhooks;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class MandrillWebhookController extends Controller
{

    /**
     * Handle the Mandrill webhook and call
     * method if available
     *
     * @return Response
     */
    public function handleWebHook(Request $request)
    {
        if ($this->validateSignature($request)) {
            $events = $this->getJsonPayloadFromRequest($request);

            foreach ($events as $event) {
                $eventName = isset($event['event']) ? $event['event'] : 'undefined';
                if($eventName == 'undefined' && isset($event['type'])){
                    $eventName = $event['type'];
                }
                $method = 'handle' . studly_case(str_replace('.', '_', $eventName));

                if (method_exists($this, $method)) {
                    $this->{$method}($event);
                }
            }

            return new Response;
        }

        return  new Response('Unauthorized', 401);
    }

    /**
     * Pull the Mandrill payload from the json
     *
     * @param $request
     *
     * @return array
     */
    private function getJsonPayloadFromRequest($request)
    {
        return (array) json_decode($request->get('mandrill_events'), true);
    }

    /**
     * Validates the signature of a mandrill request if key is set
     *
     * @param  Request $request
     * @param  string  $webhook_key
     *
     * @return bool
     */
    private function validateSignature(Request $request)
    {
        $webhook_key = config('mandrill-webhooks.webhook_key');

        if (!empty($webhook_key)) {
            $signature = $this->generateSignature($webhook_key, $request->url(), $request->all());
            return $signature === $request->header('X-Mandrill-Signature');
        }

        return true;
    }

    /**
     * https://mandrill.zendesk.com/hc/en-us/articles/205583257-How-to-Authenticate-Webhook-Requests
     * Generates a base64-encoded signature for a Mandrill webhook request.
     * @param string $webhook_key the webhook's authentication key
     * @param string $url the webhook url
     * @param array $params the request's POST parameters
     */
    public function generateSignature($webhook_key, $url, $params)
    {
        $signed_data = $url;
        ksort($params);
        foreach ($params as $key => $value) {
            $signed_data .= $key;
            $signed_data .= $value;
        }

        return base64_encode(hash_hmac('sha1', $signed_data, $webhook_key, true));
    }
}
