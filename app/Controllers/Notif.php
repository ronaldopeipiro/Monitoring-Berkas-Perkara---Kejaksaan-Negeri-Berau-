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

        $this->session = session();
        $this->id_user = $this->session->get('id_user');
        $data_user = $this->UserModel->getUser($this->id_user);
        $this->user_level = $data_user['id_level'];
        $this->user_username = $data_user['username'];
        $this->user_nama_lengkap = $data_user['nama_lengkap'];
        $this->user_no_hp = $data_user['no_hp'];
        $this->user_email = $data_user['email'];

        if ($data_user['foto'] != "") {
            $this->user_foto = base_url() . "/assets/img/user/" .    $data_user['foto'];
            $this->user_foto_thumbnail = base_url() . "/assets/img/user/" .    $data_user['foto'];
        } else {
            $this->user_foto = base_url() . "/assets/img/noimg.png";
        }
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
                'auth' => $auth
            ]);
        } else {
            $data = $cek_data->getRow();
            $this->PushNotifSubscribeModel->updatePushNotif([
                'p256dh' => $p256dh,
                'auth' => $auth
            ], $data->id_push_notif);
        }
    }

    public function send_push_notif()
    {
        $id_user = $this->request->getPost('id_user');
        $tipe_user = $this->request->getPost('tipe_user');
        $text_pesan = $this->request->getPost('text_pesan');
        $contentencoding = $this->request->getPost('ce');

        $auth = [
            'VAPID' => [
                'subject' => 'https://kejari-berau.djknkalbar.net/',
                'publicKey' => file_get_contents(base_url() . '/notif-keys/public_key.txt'),
                'privateKey' => file_get_contents(base_url() . '/notif-keys/private_key.txt')
            ],
        ];

        $user = $this->UserModel->getUser($id_user);

        $email_user = $user["email"];
        $confirm_send_notif = "Notif to User [$email_user] -> ";

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
                $result_success = true;
                $confirm_send_notif .= "Sent to $endpoint -> ";
            } else {
                $result_success = false;
                $confirm_send_notif .= "Failed to $endpoint -> ";

                $this->db->query("DELETE FROM push_notif_subscribe WHERE endpoint='$endpoint' ");
            }
        }

        if ($confirm_send_notif != "") {
            echo json_encode(array(
                'pesan' => "$confirm_send_notif"
            ));
        }
    }
}
