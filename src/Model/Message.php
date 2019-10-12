<?php

declare(strict_types=1);

namespace Kerox\Fcm\Model;

use Kerox\Fcm\Helper\ValidatorTrait;
use Kerox\Fcm\Model\Message\Android;
use Kerox\Fcm\Model\Message\Apns;
use Kerox\Fcm\Model\Message\Notification;
use Kerox\Fcm\Model\Message\Webpush;

/**
 * Class Message.
 */
class Message implements \JsonSerializable
{
    use ValidatorTrait;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var \Kerox\Fcm\Model\Message\Notification
     */
    protected $notification;

    /**
     * @var \Kerox\Fcm\Model\Message\Android
     */
    protected $android;

    /**
     * @var \Kerox\Fcm\Model\Message\Webpush
     */
    protected $webpush;

    /**
     * @var \Kerox\Fcm\Model\Message\Apns
     */
    protected $apns;

    /**
     * @var string|null
     */
    protected $token;

    /**
     * @var string|null
     */
    protected $topic;

    /**
     * @var string|null
     */
    protected $condition;

    /**
     * Message constructor.
     *
     * @param \Kerox\Fcm\Model\Message\Notification|string $message
     *
     * @throws \Exception
     */
    public function __construct($message)
    {
        if (\is_string($message)) {
            $message = new Notification($message);
        }

        if (!$message instanceof Notification) {
            throw new \InvalidArgumentException(
                sprintf('$message must be a string or an instance of %s.', Notification::class)
            );
        }

        $this->notification = $message;
    }

    /**
     * @param array $data
     *
     * @return \Kerox\Fcm\Model\Message
     */
    public function setData(array $data): self
    {
        $this->isValidData($data);

        $this->data = $data;

        return $this;
    }

    /**
     * @param \Kerox\Fcm\Model\Message\Android $android
     *
     * @return \Kerox\Fcm\Model\Message
     */
    public function setAndroid(Android $android): self
    {
        $this->android = $android;

        return $this;
    }

    /**
     * @param \Kerox\Fcm\Model\Message\Webpush $webpush
     *
     * @return \Kerox\Fcm\Model\Message
     */
    public function setWebpush(Webpush $webpush): self
    {
        $this->webpush = $webpush;

        return $this;
    }

    /**
     * @param \Kerox\Fcm\Model\Message\Apns $apns
     *
     * @return \Kerox\Fcm\Model\Message
     */
    public function setApns(Apns $apns): self
    {
        $this->apns = $apns;

        return $this;
    }

    /**
     * @param string $token
     *
     * @return \Kerox\Fcm\Model\Message
     */
    public function setToken(string $token): self
    {
        $this->topic = $this->condition = null;
        $this->token = $token;

        return $this;
    }

    /**
     * @param string $topic
     *
     * @return \Kerox\Fcm\Model\Message
     */
    public function setTopic(string $topic): self
    {
        $this->isValidTopicName($topic);

        $this->token = $this->condition = null;
        $this->topic = $topic;

        return $this;
    }

    /**
     * @param string $condition
     *
     * @return \Kerox\Fcm\Model\Message
     */
    public function setCondition(string $condition): self
    {
        $this->token = $this->topic = null;
        $this->condition = $condition;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'data' => $this->data,
            'notification' => $this->notification,
            'android' => $this->android,
            'webpush' => $this->webpush,
            'apns' => $this->apns,
            'token' => $this->token,
            'topic' => $this->topic,
            'condition' => $this->condition,
        ];

        return array_filter($array);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
