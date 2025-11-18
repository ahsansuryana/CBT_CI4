<?php

namespace App\Controllers;

use App\Libraries\WebPushLib;
use App\Models\NotificationModel;
use App\Models\UjianModel;
use DateTime;

require "./cronjob.php";
class NotifController extends BaseController
{
    public function send()
    {
        $subscription = [
            "endpoint" => $this->request->getPost('endpoint'),
            "keys" => [
                "p256dh" => $this->request->getPost('p256dh'),
                "auth" => $this->request->getPost('auth'),
            ],
        ];

        $title = "Pengumuman Ujian";
        $body = "Ujian dimulai jam 09:00, segera bersiap.";

        $webPush = new WebPushLib();
        $webPush->send($subscription, $title, $body);

        return $this->response->setJSON(["status" => "sent"]);
    }
    public function register()
    {
        $req = $this->request->getJSON(true);
        $req["p256dh"] = $req["keys"]["p256dh"];
        $req["auth"] = $req["keys"]["auth"];
        unset($req["keys"]);
        $notificationModel = new NotificationModel();
        $user_id = session()->get('user_id');
        $req["user_id"] = $user_id;
        $notificationModel->insert($req);
        update_cronjob();
        return $this->response->setJSON(["status" => "success"]);
    }
}
