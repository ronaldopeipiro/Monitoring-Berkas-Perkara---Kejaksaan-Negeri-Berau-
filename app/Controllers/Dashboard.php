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

class Dashboard extends BaseController
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

    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function index()
    {
        $data = [
            'request' => $this->request,
            'db' => $this->db,
            'validation' => $this->validation,
            'title' => 'DASHBOARD',
            'user_id' => $this->id_user,
            'user_nama_lengkap' => $this->user_nama_lengkap,
            'user_username' => $this->user_username,
            'user_no_hp' => $this->user_no_hp,
            'user_email' => $this->user_email,
            'user_level' => $this->user_level,
            'user_foto' => $this->user_foto
        ];
        return view('dashboard/views', $data);
    }
}
