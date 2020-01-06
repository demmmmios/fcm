<?php

declare(strict_types=1);

namespace Kerox\Fcm\Api;

use Kerox\Fcm\Model\Message;
use Kerox\Fcm\Request\SendRequest;
use Kerox\Fcm\Response\SendResponse;

/**
 * Class Send.
 */
class Send extends AbstractApi
{
    public function message(Message $message, bool $validateOnly = false): SendResponse
    {
        $uri = sprintf('%s/messages:send', $this->projectId);

        $request = new SendRequest($this->oauthToken, $message, $validateOnly);
        $response = $this->client->post($uri, $request->build());

        return new SendResponse($response);
    }
}
