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
        $events = $this->getJsonPayloadFromRequest($request);

        foreach ($events as $event) {

            if(!empty($event['event'])) {
                $method = 'handle' . studly_case(str_replace('.', '_', $event['event']));
    
                if ( method_exists($this, $method) ) {
                    $this->{$method}($event);
                }
            }
            
        }

        return new Response;
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
}
