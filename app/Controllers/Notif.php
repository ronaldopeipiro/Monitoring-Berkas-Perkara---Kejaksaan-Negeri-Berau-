<?php

namespace App\Controllers;

use \App\Models\BerkasPerkaraModel;
use \App\Models\PengantarBerkasModel;
use \App\Models\InstansiModel;
use \App\Models\JadwalSendNotifModel;
use \App\Models\PushNotifSubscribeModel;
use \App\Models\LogSendNotifModel;
use \App\Models\LevelUserModel;
use \App\Models\UserModel;

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class Notif extends BaseController
{
    public function __construct()
    {
        $this->BerkasPerkaraModel = new BerkasPerkaraModel();
        $this->PengantarBerkasModel = new PengantarBerkasModel();
        $this->InstansiModel = new InstansiModel();
        $this->JadwalSendNotifModel = new JadwalSendNotifModel();
        $this->PushNotifSubscribeModel = new PushNotifSubscribeModel();
        $this->LogSendNotifModel = new LogSendNotifModel();
        $this->LevelUserModel = new LevelUserModel();
        $this->UserModel = new UserModel();

        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    public function index($id_berkas_perkara)
    {
        $data_berkas_perkara = $this->BerkasPerkaraModel->getBerkasPerkara();
        // if ($id_berkas_perkara == 'all') {
        // } else {
        //     $data_berkas_perkara = $this->BerkasPerkaraModel->getBerkasPerkara($id_berkas_perkara);
        // }

        $data = [
            'request' => $this->request,
            'db' => $this->db,
            'validation' => $this->validation,
            'title' => 'Notif Sender',
            'berkas_perkara' => $data_berkas_perkara
        ];
        return view('notif/views', $data);
    }

    public function push_subscribe()
    {
        $id_user = $this->request->getPost('id_user');
        $tipe_user = $this->request->getPost('tipe_user');
        $endpoint = $this->request->getPost('endpoint');
        $p256dh = $this->request->getPost('p256dh');
        $auth = $this->request->getPost('auth');

        $cek_data = $this->db->query("SELECT * FROM push_notif_subscribe WHERE id_user='$id_user' AND tipe_user='$tipe_user' AND endpoint = '$endpoint'");
        if ($cek_data->getNumRows() == 0) {
            $this->PushNotifSubscribeModel->save([
                'id_user' => $id_user,
                'tipe_user' => $tipe_user,
                'endpoint' => $endpoint,
                'p256dh' => $p256dh,
                'auth' => $auth,
                'create_datetime' => date("Y-m-d H:i:s"),
            ]);
        } else {
            $data = $cek_data->getRow();
            $this->PushNotifSubscribeModel->updatePushNotifSubscribe([
                'p256dh' => $p256dh,
                'auth' => $auth
            ], $data->id_push_notif);
        }
    }

    public function send_push_notif()
    {
        $id_user = $this->request->getVar('id_user');
        $tipe_user = $this->request->getVar('tipe_user');
        $text_pesan = $this->request->getVar('text_pesan');
        $contentencoding = $this->request->getVar('ce');
        if ($contentencoding == "") {
            $contentencoding = "aes128gcm";
        }

        $auth = [
            'VAPID' => [
                'subject' => 'https://kejariberau.id/',
                'publicKey' => 'BMBlr6YznhYMX3NgcWIDRxZXs0sh7tCv7_YCsWcww0ZCv9WGg-tRCXfMEHTiBPCksSqeve1twlbmVAZFv7GSuj0',
                'privateKey' => 'vplfkITvu0cwHqzK9Kj-DYStbCH_9AhGx9LqMyaeI6w'
                // 'publicKey' => file_get_contents(base_url() . '/notif-keys/public_key.txt'),
                // 'privateKey' => file_get_contents(base_url() . '/notif-keys/private_key.txt')
            ],
        ];

        $user = $this->UserModel->getUser($id_user);
        $confirm_send_notif = "Notif to User [$id_user] -> ";

        $cek_user = $this->db->query("SELECT * FROM push_notif_subscribe WHERE id_user='$id_user' AND tipe_user='$tipe_user' ORDER BY id_push_notif DESC");
        foreach ($cek_user->getResult('array') as $result) {
            $tujuan = array(
                "endpoint" => $result['endpoint'],
                "expirationTime" => "",
                "keys" => array(
                    "p256dh" => $result['p256dh'],
                    "auth" => $result['auth']
                ),
                "contentEncoding" => "$contentencoding"
            );

            $subscription = Subscription::create($tujuan, true);
            $webPush = new WebPush($auth);

            $report = $webPush->sendOneNotification(
                $subscription,
                $text_pesan
            );

            $endpoint = $report->getRequest()->getUri()->__toString();

            if ($report->isSuccess()) {
                $result_success = 1;
                $confirm_send_notif .= "Sent to $endpoint -> ";
            } else {
                $result_success = 0;
                $confirm_send_notif .= "Failed to $endpoint -> ";

                $this->db->query("DELETE FROM push_notif_subscribe WHERE endpoint='$endpoint' ");
            }
        }

        if ($confirm_send_notif != "") {
            echo json_encode(array(
                'result' => $result_success,
                'pesan' => "$confirm_send_notif"
            ));
        }
    }
}
