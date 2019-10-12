<?php

declare(strict_types=1);

namespace Kerox\Fcm\Request;

use Kerox\Fcm\Model\Message;

/**
 * Class SendRequest.
 */
class SendRequest extends AbstractRequest
{
    /**
     * @var \Kerox\Fcm\Model\Message
     */
    protected $message;

    /**
     * @var bool
     */
    protected $validateOnly;

    /**
     * SendRequest constructor.
     *
     * @param string                   $oauthToken
     * @param \Kerox\Fcm\Model\Message $message
     * @param bool                     $validateOnly
     */
    public function __construct(string $oauthToken, Message $message, bool $validateOnly)
    {
        parent::__construct($oauthToken);

        $this->message = $message;
        $this->validateOnly = $validateOnly;
    }

    /**
     * Build the body of the request.
     *
     * @return array
     */
    protected function buildBody(): array
    {
        $body = [
            'validate_only' => $this->validateOnly,
            'message' => $this->message,
        ];

        return array_filter($body);
    }
}
