<?php

use App\Models\UjianModel;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

require __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();

// bootstrap CI4
require rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php';

require "GlobalStore.php";
date_default_timezone_set('Asia/Jakarta');

function update_cronjob()
{
    $now = new DateTime();
    $start = $now->format("Y-m-d H:i:00");
    $end = $now->modify("+1 hour")->format("Y-m-d H:i:00");
    // echo $start;
    // echo $end;
    $ujianModel = new UjianModel();
    $ujianBuilder = $ujianModel->select("id_ujian, tanggal_mulai, tanggal_selesai")
        ->where("tanggal_mulai >=", $start)->where("tanggal_mulai <", $end)
        ->get();
    $ujian = $ujianBuilder->getResultArray();
    GlobalStore::set("data", $ujian);
    // echo serialize($ujian);
}

function check_schedule()
{
    // echo "checking schedule\n";
    $data = GlobalStore::get("data");
    // echo json_encode($data) . "\n";
    $now = new DateTime();
    $start = clone $now;
    $end = (clone $now)->modify("+1 minute");
    foreach ($data as $ujian) {
        $startUjian = new DateTime($ujian["tanggal_mulai"]);
        $endUjian = new DateTime($ujian["tanggal_selesai"]);
        if ($startUjian >= $start && $startUjian < $end) {
            send_notification_ujian($ujian["id_ujian"]);
        }
    }
}

function send_notification_ujian($ujianId)
{
    echo "send notification " . $ujianId;

    $ujianModel = new UjianModel();
    $ujianBuilder = $ujianModel->select("*")
        ->join("siswa_ujian", "siswa_ujian.ujian_id = m_ujian.id_ujian", "left")
        ->join("m_peserta", "m_peserta.id_peserta = siswa_ujian.peserta_id")
        ->join("m_users", "m_users.id = m_peserta.user_id")
        ->join("m_notification", "m_notification.user_id = m_users.id", "left")
        ->where("m_ujian.id_ujian", $ujianId)
        ->get();
    $notif = $ujianBuilder->getResultArray();
    // print_r($notif);
    $payload = json_encode([
        "title" => "Ujian akan dimulai",
        "body"  => "Silakan bersiap!",
        "url"   => "https://yourdomain.com/ujian/123"
    ]);
    $auth = [
        'VAPID' => [
            'subject' => 'mailto:' . env("SUBJECT"),
            'publicKey' => env("PUBLIC_VAPID_KEY"),
            'privateKey' => env("PRIVATE_VAPID_KEY"),
        ],
    ];
    $webPush = new WebPush($auth);
    foreach ($notif as $user) {
        $subscription = Subscription::create([
            'endpoint' => $user["endpoint"],
            'keys' => [
                'p256dh' => $user["p256dh"],
                'auth'   => $user["auth"],
            ],
        ]);
        $webPush->sendOneNotification(
            $subscription,
            $payload   // harus string JSON
        );
    }
}
update_cronjob();
// send_notification_ujian(8);
while (true) {
    for ($i = 0; $i < 58; $i++) {
        check_schedule();
        sleep(60);
        update_cronjob();
    }
}
