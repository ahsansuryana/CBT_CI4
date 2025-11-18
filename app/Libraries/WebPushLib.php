<?php

namespace App\Libraries;

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class WebPushLib
{
    private $webPush;

    public function __construct()
    {
        $this->webPush = new WebPush([
            'VAPID' => [
                'subject' => getenv('vapid_subject'),
                'publicKey' => getenv('vapid_public_key'),
                'privateKey' => getenv('vapid_private_key'),
            ],
        ]);
    }

    public function send($subscriptionData, $title, $body)
    {
        $subscription = Subscription::create([
            'endpoint' => $subscriptionData['endpoint'],
            'keys' => [
                'p256dh' => $subscriptionData['keys']['p256dh'],
                'auth' => $subscriptionData['keys']['auth'],
            ],
        ]);

        $payload = json_encode([
            'title' => $title,
            'body' => $body,
        ]);

        $this->webPush->sendOneNotification($subscription, $payload);
    }
}
