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
	    if ($this->validateSignature($request, env('MANDRILL_WEBHOOK_KEY'), env('MANDRILL_WEBHOOK_URL'))) {
        $events = $this->getJsonPayloadFromRequest($request);

        foreach ($events as $event) {

            $eventName = isset($event['event']) ? $event['event'] : 'undefined';
            $method = 'handle' . studly_case(str_replace('.', '_', $eventName));

            if ( method_exists($this, $method) ) {
                $this->{$method}($event);
            }
        }

        return new Response;
      } else {
	      return  new Response('', 401);
      }
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
    
  	private function validateSignature(Request $request, $key, $hook) 
  	{
	  	if (!empty($key) && !empty($hook))  {
		  	return $this->generateSignature($key, $hook, $request->all()) === $request->header('X-Mandrill-Signature');
	  	}
	  	
	  	return true;
  	}
  	
		/**
		* Generates a base64-encoded signature for a Mandrill webhook request.
		* @param string $webhook_key the webhook's authentication key
		* @param string $url the webhook url
		* @param array $params the request's POST parameters
		*/
		private function generateSignature($webhook_key, $url, $params) 
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
