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

    public function index($auth_code)
    {
        if ($auth_code == "gyYaOg9me10TQH9ZJXRGMXi132mjX34bDWiGQUme0KTmzRc4YPAETOJ7Cq58YOHugxVyuWcqElE4Uz8QMGTLXvL9ot9N8Ac81xCQ") {
            $data = [
                'request' => $this->request,
                'db' => $this->db,
                'validation' => $this->validation,
                'title' => 'Notif Sender',
            ];
            return view('notif/views', $data);
        } else {
            echo json_encode(array(
                'error' => 'Terjadi kesalahan !'
            ));
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

    public function whatsapp()
    {
        $device_id = $this->request->getPost('device_id');
        $no_hp = $this->request->getPost('no_hp');
        $pesan = $this->request->getPost('pesan');
        $file = $this->request->getPost('file');

        $url = 'https://app.whacenter.com/api/send';
        $ch = curl_init($url);

        $data = array(
            'device_id' => $device_id,
            'number' => $no_hp,
            'message' => $pesan,
            'file' => $file,
        );

        $payload = $data;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        echo json_encode(array(
            'pesan' => $result
        ));
    }


    public function detail_berkas($slug)
    {
        $data = [
            'request' => $this->request,
            'db' => $this->db,
            'validation' => $this->validation,
            'title' => 'Detail Berkas Perkara',
            'slug' => $slug
        ];

        return view('berkas-perkara/detail', $data);
    }

    public function getAllBerkas()
    {
        header('Content-Type:application/json');
        $slug = $this->request->getVar('slug');

        $listData = [];
        $query = $this->db->query("SELECT * FROM berkas_perkara ORDER BY id_berkas_perkara DESC LIMIT 1");
        foreach ($query->getResult('array') as $row) {

            $interval_tanggal_penerimaan = 0;
            $interval_tanggal_berkas = 0;
            $interval_tanggal_spdp = 0;
            $interval_tanggal_p16 = 0;
            $interval_tanggal_p17 = 0;
            $interval_tanggal_sop_form_02 = 0;
            $interval_tanggal_surat_pengembalian_spdp = 0;
            $interval_tanggal_penerimaan = date_diff(date_create($row['tanggal_penerimaan']), date_create(date('Y-m-d')))->days;

            if ($row['notifikasi_send'] == "Y") {
                $status_notifikasi = "Notifikasi telah dikirim kepada jaksa terkait";
            } else if ($row['notifikasi_send'] == "N") {
                $status_notifikasi = "Menunggu jadwal";
            }

            $id_instansi_penyidik = $row['id_instansi_penyidik'];
            $data_instansi_penyidik = $this->db->query("SELECT * FROM instansi WHERE id_instansi='$id_instansi_penyidik' ")->getRow();

            $array_jaksa_terkait = $row['jaksa_terkait'];
            $data_jaksa_terkait = $this->db->query("SELECT * FROM user WHERE id_user IN ($array_jaksa_terkait) ORDER BY nama_lengkap ASC ")->getRow();

            $nama_jaksa = $data_jaksa_terkait->nama_lengkap;
            $hp_jaksa = $data_jaksa_terkait->no_hp;

            $nama_user_create = "";
            if ($row['id_user_create'] != "") {
                $id_user_create = $row['id_user_create'];
                $user_create = $this->db->query("SELECT * FROM user WHERE id_user='$id_user_create' ")->getRow();
                $nama_user_create = $user_create->nama_lengkap;
            }

            $nama_user_update = "";
            if ($row['id_user_update'] != "") {
                $id_user_update = $row['id_user_update'];

                $user_update = $this->db->query("SELECT * FROM user WHERE id_user='$id_user_update' ")->getRow();
                $nama_user_update = $user_update->nama_lengkap;
            }

            $tanggal_penerimaan_format = "";
            if (($row['tanggal_penerimaan'] != "0000-00-00") and ($row['tanggal_penerimaan'] != "")) {
                $tanggal_penerimaan_format = date('d/m/Y', strtotime($row['tanggal_penerimaan']));
            }

            $tanggal_berkas_format = "";
            if (($row['tanggal_berkas'] != "0000-00-00") and ($row['tanggal_berkas'] != "")) {
                $tanggal_berkas_format = date('d/m/Y', strtotime($row['tanggal_berkas']));
                $interval_tanggal_berkas = date_diff(date_create($row['tanggal_berkas']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_pengantar_berkas_format = "";
            if (($row['tanggal_pengantar_berkas'] != "0000-00-00") and ($row['tanggal_pengantar_berkas'] != "")) {
                $tanggal_pengantar_berkas_format = date('d/m/Y', strtotime($row['tanggal_pengantar_berkas']));
                $interval_tanggal_pengantar_berkas = date_diff(date_create($row['tanggal_pengantar_berkas']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_spdp_format = "";
            if (($row['tanggal_spdp'] != "0000-00-00") and ($row['tanggal_spdp'] != "")) {
                $tanggal_spdp_format = date('d/m/Y', strtotime($row['tanggal_spdp']));
                $interval_tanggal_spdp = date_diff(date_create($row['tanggal_spdp']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_p16_format = "";
            if (($row['tanggal_p16'] != "0000-00-00") and ($row['tanggal_p16'] != "")) {
                $tanggal_p16_format = date('d/m/Y', strtotime($row['tanggal_p16']));
                $interval_tanggal_p16 = date_diff(date_create($row['tanggal_p16']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_p17_format = "";
            if (($row['tanggal_p17'] != "0000-00-00") and ($row['tanggal_p17'] != "")) {
                $tanggal_p17_format = date('d/m/Y', strtotime($row['tanggal_p17']));
                $interval_tanggal_p17 = date_diff(date_create($row['tanggal_p17']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_sop_form_02_format = "";
            if (($row['tanggal_sop_form_02'] != "0000-00-00") and ($row['tanggal_sop_form_02'] != "")) {
                $tanggal_sop_form_02_format = date('d/m/Y', strtotime($row['tanggal_sop_form_02']));
                $interval_tanggal_sop_form_02 = date_diff(date_create($row['tanggal_sop_form_02']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_surat_pengembalian_spdp_format = "";
            if (($row['tanggal_surat_pengembalian_spdp'] != "0000-00-00") and ($row['tanggal_surat_pengembalian_spdp'] != "")) {
                $tanggal_surat_pengembalian_spdp_format = date('d/m/Y', strtotime($row['tanggal_surat_pengembalian_spdp']));
                $interval_tanggal_surat_pengembalian_spdp = date_diff(date_create($row['tanggal_surat_pengembalian_spdp']), date_create(date('Y-m-d')))->days;
            }

            array_push($listData, [
                'slug' => $row['slug'],
                'id_berkas_perkara' => $row['id_berkas_perkara'],
                'tanggal_penerimaan' => $row['tanggal_penerimaan'],
                'tanggal_penerimaan_format' => $tanggal_penerimaan_format,
                'nomor_berkas' => $row['nomor_berkas'],
                'tanggal_berkas' => $row['tanggal_berkas'],
                'tanggal_berkas_format' => $tanggal_berkas_format,
                'file_berkas' => $row['file_berkas'],
                'nomor_pengantar_berkas' => $row['nomor_pengantar_berkas'],
                'tanggal_pengantar_berkas' => $row['tanggal_pengantar_berkas'],
                'tanggal_pengantar_berkas_format' => $tanggal_pengantar_berkas_format,
                'file_pengantar_berkas' => $row['file_pengantar_berkas'],
                'nomor_spdp' => $row['nomor_spdp'],
                'tanggal_spdp' => $row['tanggal_spdp'],
                'tanggal_spdp_format' => $tanggal_spdp_format,
                'file_spdp' => $row['file_spdp'],
                'nomor_p16' => $row['nomor_p16'],
                'tanggal_p16' => $row['tanggal_p16'],
                'tanggal_p16_format' => $tanggal_p16_format,
                'file_p16' => $row['file_p16'],
                'nomor_p17' => $row['nomor_p17'],
                'tanggal_p17' => $row['tanggal_p17'],
                'tanggal_p17_format' => $tanggal_p17_format,
                'file_p17' => $row['file_p17'],
                'nomor_sop_form_02' => $row['nomor_sop_form_02'],
                'tanggal_sop_form_02' => $row['tanggal_sop_form_02'],
                'tanggal_sop_form_02_format' => $tanggal_sop_form_02_format,
                'file_sop_form_02' => $row['file_sop_form_02'],
                'nomor_surat_pengembalian_spdp' => $row['nomor_surat_pengembalian_spdp'],
                'tanggal_surat_pengembalian_spdp' => $row['tanggal_surat_pengembalian_spdp'],
                'tanggal_surat_pengembalian_spdp_format' => $tanggal_surat_pengembalian_spdp_format,
                'file_surat_pengembalian_spdp' => $row['file_surat_pengembalian_spdp'],
                'status_berkas' => $row['status_berkas'],
                'id_instansi_penyidik' => $row['id_instansi_penyidik'],
                'nama_instansi_penyidik' => $data_instansi_penyidik->nama_instansi,
                'tersangka' => $row['tersangka'],
                'jaksa_terkait' => $row['jaksa_terkait'],
                'nama_jaksa' => $nama_jaksa,
                'hp_jaksa' => $hp_jaksa,
                'pidana_anak' => $row['pidana_anak'],
                'status' => $row['status'],
                'notifikasi_send' => $row['notifikasi_send'],
                'status_notifikasi' => $status_notifikasi,
                'create_datetime' => ($row['create_datetime'] != "") ? date('d/m/Y H:i:s', strtotime($row['create_datetime'])) : "",
                'update_datetime' => ($row['update_datetime'] != "") ? date('d/m/Y H:i:s', strtotime($row['update_datetime'])) : "",
                'nama_user_create' => $nama_user_create,
                'nama_user_update' => $nama_user_update,
                'interval_tanggal_penerimaan' => $interval_tanggal_penerimaan,
                'interval_tanggal_berkas' => $interval_tanggal_berkas,
                'interval_tanggal_spdp' => $interval_tanggal_spdp,
                'interval_tanggal_p16' => $interval_tanggal_p16,
                'interval_tanggal_p17' => $interval_tanggal_p17,
                'interval_tanggal_sop_form_02' => $interval_tanggal_sop_form_02,
                'interval_tanggal_surat_pengembalian_spdp' => $interval_tanggal_surat_pengembalian_spdp,
            ]);
        }

        echo json_encode([
            'status' => 1,
            'data' => $listData,
        ]);
        exit;
    }

    public function getAllBerkasProses()
    {
        header('Content-Type:application/json');

        $listData = [];
        $query = $this->db->query("SELECT * FROM berkas_perkara WHERE status_berkas != 'P-21' ");
        foreach ($query->getResult('array') as $row) {

            $interval_tanggal_penerimaan = 0;
            $interval_tanggal_berkas = 0;
            $interval_tanggal_spdp = 0;
            $interval_tanggal_p16 = 0;
            $interval_tanggal_p17 = 0;
            $interval_tanggal_sop_form_02 = 0;
            $interval_tanggal_surat_pengembalian_spdp = 0;
            $interval_tanggal_penerimaan = date_diff(date_create($row['tanggal_penerimaan']), date_create(date('Y-m-d')))->days;

            if ($row['notifikasi_send'] == "Y") {
                $status_notifikasi = "Notifikasi telah dikirim kepada jaksa terkait";
            } else if ($row['notifikasi_send'] == "N") {
                $status_notifikasi = "Menunggu jadwal";
            }

            $id_instansi_penyidik = $row['id_instansi_penyidik'];
            $data_instansi_penyidik = $this->db->query("SELECT * FROM instansi WHERE id_instansi='$id_instansi_penyidik' ")->getRow();

            $array_jaksa_terkait = $row['jaksa_terkait'];
            $data_jaksa_terkait = $this->db->query("SELECT * FROM user WHERE id_user IN ($array_jaksa_terkait) ORDER BY nama_lengkap ASC ")->getRow();

            $nama_jaksa = $data_jaksa_terkait->nama_lengkap;
            $hp_jaksa = $data_jaksa_terkait->no_hp;

            $nama_user_create = "";
            if ($row['id_user_create'] != "") {
                $id_user_create = $row['id_user_create'];
                $user_create = $this->db->query("SELECT * FROM user WHERE id_user='$id_user_create' ")->getRow();
                $nama_user_create = $user_create->nama_lengkap;
            }

            $nama_user_update = "";
            if ($row['id_user_update'] != "") {
                $id_user_update = $row['id_user_update'];

                $user_update = $this->db->query("SELECT * FROM user WHERE id_user='$id_user_update' ")->getRow();
                $nama_user_update = $user_update->nama_lengkap;
            }

            $tanggal_penerimaan_format = "";
            if (($row['tanggal_penerimaan'] != "0000-00-00") and ($row['tanggal_penerimaan'] != "")) {
                $tanggal_penerimaan_format = date('d/m/Y', strtotime($row['tanggal_penerimaan']));
            }

            $tanggal_berkas_format = "";
            if (($row['tanggal_berkas'] != "0000-00-00") and ($row['tanggal_berkas'] != "")) {
                $tanggal_berkas_format = date('d/m/Y', strtotime($row['tanggal_berkas']));
                $interval_tanggal_berkas = date_diff(date_create($row['tanggal_berkas']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_pengantar_berkas_format = "";
            if (($row['tanggal_pengantar_berkas'] != "0000-00-00") and ($row['tanggal_pengantar_berkas'] != "")) {
                $tanggal_pengantar_berkas_format = date('d/m/Y', strtotime($row['tanggal_pengantar_berkas']));
                $interval_tanggal_pengantar_berkas = date_diff(date_create($row['tanggal_pengantar_berkas']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_spdp_format = "";
            if (($row['tanggal_spdp'] != "0000-00-00") and ($row['tanggal_spdp'] != "")) {
                $tanggal_spdp_format = date('d/m/Y', strtotime($row['tanggal_spdp']));
                $interval_tanggal_spdp = date_diff(date_create($row['tanggal_spdp']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_p16_format = "";
            if (($row['tanggal_p16'] != "0000-00-00") and ($row['tanggal_p16'] != "")) {
                $tanggal_p16_format = date('d/m/Y', strtotime($row['tanggal_p16']));
                $interval_tanggal_p16 = date_diff(date_create($row['tanggal_p16']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_p17_format = "";
            if (($row['tanggal_p17'] != "0000-00-00") and ($row['tanggal_p17'] != "")) {
                $tanggal_p17_format = date('d/m/Y', strtotime($row['tanggal_p17']));
                $interval_tanggal_p17 = date_diff(date_create($row['tanggal_p17']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_sop_form_02_format = "";
            if (($row['tanggal_sop_form_02'] != "0000-00-00") and ($row['tanggal_sop_form_02'] != "")) {
                $tanggal_sop_form_02_format = date('d/m/Y', strtotime($row['tanggal_sop_form_02']));
                $interval_tanggal_sop_form_02 = date_diff(date_create($row['tanggal_sop_form_02']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_surat_pengembalian_spdp_format = "";
            if (($row['tanggal_surat_pengembalian_spdp'] != "0000-00-00") and ($row['tanggal_surat_pengembalian_spdp'] != "")) {
                $tanggal_surat_pengembalian_spdp_format = date('d/m/Y', strtotime($row['tanggal_surat_pengembalian_spdp']));
                $interval_tanggal_surat_pengembalian_spdp = date_diff(date_create($row['tanggal_surat_pengembalian_spdp']), date_create(date('Y-m-d')))->days;
            }

            array_push($listData, [
                'slug' => $row['slug'],
                'id_berkas_perkara' => $row['id_berkas_perkara'],
                'tanggal_penerimaan' => $row['tanggal_penerimaan'],
                'tanggal_penerimaan_format' => $tanggal_penerimaan_format,
                'nomor_berkas' => $row['nomor_berkas'],
                'tanggal_berkas' => $row['tanggal_berkas'],
                'tanggal_berkas_format' => $tanggal_berkas_format,
                'file_berkas' => $row['file_berkas'],
                'nomor_pengantar_berkas' => $row['nomor_pengantar_berkas'],
                'tanggal_pengantar_berkas' => $row['tanggal_pengantar_berkas'],
                'tanggal_pengantar_berkas_format' => $tanggal_pengantar_berkas_format,
                'file_pengantar_berkas' => $row['file_pengantar_berkas'],
                'nomor_spdp' => $row['nomor_spdp'],
                'tanggal_spdp' => $row['tanggal_spdp'],
                'tanggal_spdp_format' => $tanggal_spdp_format,
                'file_spdp' => $row['file_spdp'],
                'nomor_p16' => $row['nomor_p16'],
                'tanggal_p16' => $row['tanggal_p16'],
                'tanggal_p16_format' => $tanggal_p16_format,
                'file_p16' => $row['file_p16'],
                'nomor_p17' => $row['nomor_p17'],
                'tanggal_p17' => $row['tanggal_p17'],
                'tanggal_p17_format' => $tanggal_p17_format,
                'file_p17' => $row['file_p17'],
                'nomor_sop_form_02' => $row['nomor_sop_form_02'],
                'tanggal_sop_form_02' => $row['tanggal_sop_form_02'],
                'tanggal_sop_form_02_format' => $tanggal_sop_form_02_format,
                'file_sop_form_02' => $row['file_sop_form_02'],
                'nomor_surat_pengembalian_spdp' => $row['nomor_surat_pengembalian_spdp'],
                'tanggal_surat_pengembalian_spdp' => $row['tanggal_surat_pengembalian_spdp'],
                'tanggal_surat_pengembalian_spdp_format' => $tanggal_surat_pengembalian_spdp_format,
                'file_surat_pengembalian_spdp' => $row['file_surat_pengembalian_spdp'],
                'status_berkas' => $row['status_berkas'],
                'id_instansi_penyidik' => $row['id_instansi_penyidik'],
                'nama_instansi_penyidik' => $data_instansi_penyidik->nama_instansi,
                'tersangka' => $row['tersangka'],
                'jaksa_terkait' => $row['jaksa_terkait'],
                'nama_jaksa' => $nama_jaksa,
                'hp_jaksa' => $hp_jaksa,
                'pidana_anak' => $row['pidana_anak'],
                'status' => $row['status'],
                'notifikasi_send' => $row['notifikasi_send'],
                'status_notifikasi' => $status_notifikasi,
                'create_datetime' => ($row['create_datetime'] != "") ? date('d/m/Y H:i:s', strtotime($row['create_datetime'])) : "",
                'update_datetime' => ($row['update_datetime'] != "") ? date('d/m/Y H:i:s', strtotime($row['update_datetime'])) : "",
                'nama_user_create' => $nama_user_create,
                'nama_user_update' => $nama_user_update,
                'interval_tanggal_penerimaan' => $interval_tanggal_penerimaan,
                'interval_tanggal_berkas' => $interval_tanggal_berkas,
                'interval_tanggal_spdp' => $interval_tanggal_spdp,
                'interval_tanggal_p16' => $interval_tanggal_p16,
                'interval_tanggal_p17' => $interval_tanggal_p17,
                'interval_tanggal_sop_form_02' => $interval_tanggal_sop_form_02,
                'interval_tanggal_surat_pengembalian_spdp' => $interval_tanggal_surat_pengembalian_spdp,
            ]);
        }

        echo json_encode([
            'status' => 1,
            'data' => $listData,
        ]);
        exit;
    }

    public function getDetailBerkas()
    {
        header('Content-Type:application/json');
        $slug = $this->request->getVar('slug');

        $listData = [];
        $query = $this->db->query("SELECT * FROM berkas_perkara WHERE slug = '$slug' LIMIT 1");
        foreach ($query->getResult('array') as $row) {

            $interval_tanggal_penerimaan = 0;
            $interval_tanggal_berkas = 0;
            $interval_tanggal_spdp = 0;
            $interval_tanggal_p16 = 0;
            $interval_tanggal_p17 = 0;
            $interval_tanggal_sop_form_02 = 0;
            $interval_tanggal_surat_pengembalian_spdp = 0;
            $interval_tanggal_penerimaan = date_diff(date_create($row['tanggal_penerimaan']), date_create(date('Y-m-d')))->days;

            if ($row['notifikasi_send'] == "Y") {
                $status_notifikasi = "Notifikasi telah dikirim kepada jaksa terkait";
            } else if ($row['notifikasi_send'] == "N") {
                $status_notifikasi = "Menunggu jadwal";
            }

            $id_instansi_penyidik = $row['id_instansi_penyidik'];
            $data_instansi_penyidik = $this->db->query("SELECT * FROM instansi WHERE id_instansi='$id_instansi_penyidik' ")->getRow();

            $array_jaksa_terkait = $row['jaksa_terkait'];
            $data_jaksa_terkait = $this->db->query("SELECT * FROM user WHERE id_user IN ($array_jaksa_terkait) ORDER BY nama_lengkap ASC ")->getRow();

            $nama_jaksa = $data_jaksa_terkait->nama_lengkap;
            $hp_jaksa = $data_jaksa_terkait->no_hp;

            $nama_user_create = "";
            if ($row['id_user_create'] != "") {
                $id_user_create = $row['id_user_create'];
                $user_create = $this->db->query("SELECT * FROM user WHERE id_user='$id_user_create' ")->getRow();
                $nama_user_create = $user_create->nama_lengkap;
            }

            $nama_user_update = "";
            if ($row['id_user_update'] != "") {
                $id_user_update = $row['id_user_update'];

                $user_update = $this->db->query("SELECT * FROM user WHERE id_user='$id_user_update' ")->getRow();
                $nama_user_update = $user_update->nama_lengkap;
            }

            $tanggal_penerimaan_format = "";
            if (($row['tanggal_penerimaan'] != "0000-00-00") and ($row['tanggal_penerimaan'] != "")) {
                $tanggal_penerimaan_format = date('d/m/Y', strtotime($row['tanggal_penerimaan']));
            }

            $tanggal_berkas_format = "";
            if (($row['tanggal_berkas'] != "0000-00-00") and ($row['tanggal_berkas'] != "")) {
                $tanggal_berkas_format = date('d/m/Y', strtotime($row['tanggal_berkas']));
                $interval_tanggal_berkas = date_diff(date_create($row['tanggal_berkas']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_pengantar_berkas_format = "";
            if (($row['tanggal_pengantar_berkas'] != "0000-00-00") and ($row['tanggal_pengantar_berkas'] != "")) {
                $tanggal_pengantar_berkas_format = date('d/m/Y', strtotime($row['tanggal_pengantar_berkas']));
                $interval_tanggal_pengantar_berkas = date_diff(date_create($row['tanggal_pengantar_berkas']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_spdp_format = "";
            if (($row['tanggal_spdp'] != "0000-00-00") and ($row['tanggal_spdp'] != "")) {
                $tanggal_spdp_format = date('d/m/Y', strtotime($row['tanggal_spdp']));
                $interval_tanggal_spdp = date_diff(date_create($row['tanggal_spdp']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_p16_format = "";
            if (($row['tanggal_p16'] != "0000-00-00") and ($row['tanggal_p16'] != "")) {
                $tanggal_p16_format = date('d/m/Y', strtotime($row['tanggal_p16']));
                $interval_tanggal_p16 = date_diff(date_create($row['tanggal_p16']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_p17_format = "";
            if (($row['tanggal_p17'] != "0000-00-00") and ($row['tanggal_p17'] != "")) {
                $tanggal_p17_format = date('d/m/Y', strtotime($row['tanggal_p17']));
                $interval_tanggal_p17 = date_diff(date_create($row['tanggal_p17']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_sop_form_02_format = "";
            if (($row['tanggal_sop_form_02'] != "0000-00-00") and ($row['tanggal_sop_form_02'] != "")) {
                $tanggal_sop_form_02_format = date('d/m/Y', strtotime($row['tanggal_sop_form_02']));
                $interval_tanggal_sop_form_02 = date_diff(date_create($row['tanggal_sop_form_02']), date_create(date('Y-m-d')))->days;
            }

            $tanggal_surat_pengembalian_spdp_format = "";
            if (($row['tanggal_surat_pengembalian_spdp'] != "0000-00-00") and ($row['tanggal_surat_pengembalian_spdp'] != "")) {
                $tanggal_surat_pengembalian_spdp_format = date('d/m/Y', strtotime($row['tanggal_surat_pengembalian_spdp']));
                $interval_tanggal_surat_pengembalian_spdp = date_diff(date_create($row['tanggal_surat_pengembalian_spdp']), date_create(date('Y-m-d')))->days;
            }

            array_push($listData, [
                'slug' => $row['slug'],
                'id_berkas_perkara' => $row['id_berkas_perkara'],
                'tanggal_penerimaan' => $row['tanggal_penerimaan'],
                'tanggal_penerimaan_format' => $tanggal_penerimaan_format,
                'nomor_berkas' => $row['nomor_berkas'],
                'tanggal_berkas' => $row['tanggal_berkas'],
                'tanggal_berkas_format' => $tanggal_berkas_format,
                'file_berkas' => $row['file_berkas'],
                'nomor_pengantar_berkas' => $row['nomor_pengantar_berkas'],
                'tanggal_pengantar_berkas' => $row['tanggal_pengantar_berkas'],
                'tanggal_pengantar_berkas_format' => $tanggal_pengantar_berkas_format,
                'file_pengantar_berkas' => $row['file_pengantar_berkas'],
                'nomor_spdp' => $row['nomor_spdp'],
                'tanggal_spdp' => $row['tanggal_spdp'],
                'tanggal_spdp_format' => $tanggal_spdp_format,
                'file_spdp' => $row['file_spdp'],
                'nomor_p16' => $row['nomor_p16'],
                'tanggal_p16' => $row['tanggal_p16'],
                'tanggal_p16_format' => $tanggal_p16_format,
                'file_p16' => $row['file_p16'],
                'nomor_p17' => $row['nomor_p17'],
                'tanggal_p17' => $row['tanggal_p17'],
                'tanggal_p17_format' => $tanggal_p17_format,
                'file_p17' => $row['file_p17'],
                'nomor_sop_form_02' => $row['nomor_sop_form_02'],
                'tanggal_sop_form_02' => $row['tanggal_sop_form_02'],
                'tanggal_sop_form_02_format' => $tanggal_sop_form_02_format,
                'file_sop_form_02' => $row['file_sop_form_02'],
                'nomor_surat_pengembalian_spdp' => $row['nomor_surat_pengembalian_spdp'],
                'tanggal_surat_pengembalian_spdp' => $row['tanggal_surat_pengembalian_spdp'],
                'tanggal_surat_pengembalian_spdp_format' => $tanggal_surat_pengembalian_spdp_format,
                'file_surat_pengembalian_spdp' => $row['file_surat_pengembalian_spdp'],
                'status_berkas' => $row['status_berkas'],
                'id_instansi_penyidik' => $row['id_instansi_penyidik'],
                'nama_instansi_penyidik' => $data_instansi_penyidik->nama_instansi,
                'tersangka' => $row['tersangka'],
                'jaksa_terkait' => $row['jaksa_terkait'],
                'nama_jaksa' => $nama_jaksa,
                'hp_jaksa' => $hp_jaksa,
                'pidana_anak' => $row['pidana_anak'],
                'status' => $row['status'],
                'notifikasi_send' => $row['notifikasi_send'],
                'status_notifikasi' => $status_notifikasi,
                'create_datetime' => ($row['create_datetime'] != "") ? date('d/m/Y H:i:s', strtotime($row['create_datetime'])) : "",
                'update_datetime' => ($row['update_datetime'] != "") ? date('d/m/Y H:i:s', strtotime($row['update_datetime'])) : "",
                'nama_user_create' => $nama_user_create,
                'nama_user_update' => $nama_user_update,
                'interval_tanggal_penerimaan' => $interval_tanggal_penerimaan,
                'interval_tanggal_berkas' => $interval_tanggal_berkas,
                'interval_tanggal_spdp' => $interval_tanggal_spdp,
                'interval_tanggal_p16' => $interval_tanggal_p16,
                'interval_tanggal_p17' => $interval_tanggal_p17,
                'interval_tanggal_sop_form_02' => $interval_tanggal_sop_form_02,
                'interval_tanggal_surat_pengembalian_spdp' => $interval_tanggal_surat_pengembalian_spdp,
            ]);
        }

        echo json_encode([
            'status' => 1,
            'data' => $listData,
        ]);
        exit;
    }

    public function updateStatusNotif()
    {
    }
}
