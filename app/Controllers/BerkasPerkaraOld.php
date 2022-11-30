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

class BerkasPerkara extends BaseController
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

		$this->user_nama_lengkap = $data_user['nama_lengkap'];
		$this->user_nip = $data_user['nip'];
		$this->user_username = $data_user['username'];
		$this->user_no_hp = $data_user['no_hp'];
		$this->user_email = $data_user['email'];
		$this->user_level = $data_user['id_level'];

		if ($data_user['foto'] != "") {
			$this->user_foto = base_url() . "/assets/img/user/" .    $data_user['foto'];
		} else {
			$this->user_foto = base_url() . "/assets/img/noimg.png";
		}

		$this->user_status_aktif = $data_user['aktif'];
	}

	public function index()
	{
		// $text_title = "";
		// if ($this->user_level <= 2) {
		// 	$text_title = "Berkas Perkara";
		// 	$data_berkas_perkara = $this->BerkasPerkaraModel->getBerkasPerkara();
		// } else if ($this->user_level == 3) {
		// 	$text_title = "Berkas Perkara - " . $this->user_nama_lengkap . " (NIP.)" . $this->user_nip;
		// 	$data_berkas_perkara = $this->db->query(
		// 		"SELECT * FROM berkas_perkara WHERE FIND_IN_SET('$this->id_user', jaksa_terkait) ORDER BY id_berkas_perkara DESC"
		// 	)->getResult("array");
		// }

		$list_status_berkas = $this->db->query("SELECT DISTINCT status_berkas FROM berkas_perkara ORDER BY status_berkas ASC")->getResult('array');
		$list_tersangka = $this->db->query("SELECT DISTINCT tersangka FROM berkas_perkara ORDER BY tersangka ASC")->getResult('array');

		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'Data Berkas Perkara',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_no_hp' => $this->user_no_hp,
			'user_email' => $this->user_email,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'list_instansi' => $this->InstansiModel->getListInstansiAktif(),
			'list_jaksa' => $this->UserModel->getListUserAktifByLevel(3),
			'list_status_berkas' => $list_status_berkas,
			'list_tersangka' => $list_tersangka,
		];

		return view('berkas-perkara/views', $data);
	}

	public function getDataTable()
	{
		header('Content-Type:application/json');

		$jaksa_terkait = $this->request->getVar('jaksa_terkait');
		$instansi_penyidik = $this->request->getVar('instansi_penyidik');
		$tersangka = $this->request->getVar('tersangka');
		$status_berkas = $this->request->getVar('status_berkas');

		$whereJaksaTerkait = '';
		if ($jaksa_terkait != '' and $jaksa_terkait != null) {
			$whereJaksaTerkait = " AND FIND_IN_SET('$jaksa_terkait', jaksa_terkait) ";
		}

		$whereInstansiPenyidik = '';
		if ($instansi_penyidik != '' and $instansi_penyidik != null) {
			$whereInstansiPenyidik = " AND FIND_IN_SET('$instansi_penyidik', id_instansi_penyidik) ";
		}

		$whereTersangka = '';
		if ($tersangka != '' and $tersangka != null) {
			$query = $this->db->query('SELECT tersangka FROM berkas_perkara GROUP BY tersangka ORDER BY tersangka');
			foreach ($query->getResult('array') as $row) {
				if ($row['tersangka'] == $tersangka) {
					$whereTersangka = " AND tersangka = '$tersangka'";
				}
			}
		}

		$whereStatusBerkas = '';
		if ($status_berkas != '' and $status_berkas != null) {
			$query = $this->db->query('SELECT status_berkas FROM berkas_perkara GROUP BY status_berkas ORDER BY status_berkas');
			foreach ($query->getResult('array') as $row) {
				if ($row['status_berkas'] == $status_berkas) {
					$whereStatusBerkas = " AND status_berkas = '$status_berkas'";
				}
			}
		}

		$listData = [];
		$query = $this->db->query("SELECT * FROM berkas_perkara WHERE id_berkas_perkara != '' $whereJaksaTerkait $whereInstansiPenyidik $whereTersangka $whereStatusBerkas ORDER BY id_berkas_perkara DESC");
		foreach ($query->getResult('array') as $row) {

			$interval_tanggal_penerimaan = 0;
			$interval_tanggal_penerimaan = date_diff(date_create($row['tanggal_penerimaan']), date_create(date('Y-m-d')))->days;

			$interval_tanggal_berkas = 0;
			if ($row['tanggal_berkas'] != "") {
				$interval_tanggal_berkas = date_diff(date_create($row['tanggal_berkas']), date_create(date('Y-m-d')))->days;
			}

			$interval_tanggal_spdp = 0;
			if ($row['tanggal_spdp'] != "") {
				$interval_tanggal_spdp = date_diff(date_create($row['tanggal_spdp']), date_create(date('Y-m-d')))->days;
			}

			$interval_tanggal_p16 = 0;
			if ($row['tanggal_p16'] != "") {
				$interval_tanggal_p16 = date_diff(date_create($row['tanggal_p16']), date_create(date('Y-m-d')))->days;
			}

			$interval_tanggal_p17 = 0;
			if ($row['tanggal_p17'] != "") {
				$interval_tanggal_p17 = date_diff(date_create($row['tanggal_p17']), date_create(date('Y-m-d')))->days;
			}

			$interval_tanggal_sop_form_02 = 0;
			if ($row['tanggal_sop_form_02'] != "") {
				$interval_tanggal_sop_form_02 = date_diff(date_create($row['tanggal_sop_form_02']), date_create(date('Y-m-d')))->days;
			}

			$interval_tanggal_surat_pengembalian_spdp = 0;
			if ($row['tanggal_surat_pengembalian_spdp'] != "") {
				$interval_tanggal_surat_pengembalian_spdp = date_diff(date_create($row['tanggal_surat_pengembalian_spdp']), date_create(date('Y-m-d')))->days;
			}

			if ($row['notifikasi_send'] == "Y") {
				$status_notifikasi = "Notifikasi telah dikirim kepada jaksa terkait";
			} else if ($row['notifikasi_send'] == "N") {
				$status_notifikasi = "Menunggu jadwal";
			}

			$id_instansi_penyidik = $row['id_instansi_penyidik'];
			$data_instansi_penyidik = $this->db->query("SELECT * FROM instansi WHERE id_instansi='$id_instansi_penyidik' ")->getRow();

			$array_jaksa_terkait = $row['jaksa_terkait'];
			$data_jaksa_terkait = $this->db->query("SELECT * FROM user WHERE id_user IN ($array_jaksa_terkait) ORDER BY nama_lengkap ASC ");
			$jaksa_terkait_text = "";
			foreach ($data_jaksa_terkait->getResult('array') as $jt) {
				$jaksa_terkait_text .= "<span class='badge btn-primary jaksaBadge'>" . $jt['nama_lengkap'] . "</span> <br>";
			}

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
			}

			$tanggal_spdp_format = "";
			if (($row['tanggal_spdp'] != "0000-00-00") and ($row['tanggal_spdp'] != "")) {
				$tanggal_spdp_format = date('d/m/Y', strtotime($row['tanggal_spdp']));
			}

			$tanggal_p16_format = "";
			if (($row['tanggal_p16'] != "0000-00-00") and ($row['tanggal_p16'] != "")) {
				$tanggal_p16_format = date('d/m/Y', strtotime($row['tanggal_p16']));
			}

			$tanggal_p17_format = "";
			if (($row['tanggal_p17'] != "0000-00-00") and ($row['tanggal_p17'] != "")) {
				$tanggal_p17_format = date('d/m/Y', strtotime($row['tanggal_p17']));
			}

			$tanggal_sop_form_02_format = "";
			if (($row['tanggal_sop_form_02'] != "0000-00-00") and ($row['tanggal_sop_form_02'] != "")) {
				$tanggal_sop_form_02_format = date('d/m/Y', strtotime($row['tanggal_sop_form_02']));
			}

			$tanggal_surat_pengembalian_spdp_format = "";
			if (($row['tanggal_surat_pengembalian_spdp'] != "0000-00-00") and ($row['tanggal_surat_pengembalian_spdp'] != "")) {
				$tanggal_surat_pengembalian_spdp_format = date('d/m/Y', strtotime($row['tanggal_surat_pengembalian_spdp']));
			}

			if (($this->user_level < 3)) {
				$editable = 'Y';
			} else {
				$editable = 'N';
			}

			array_push($listData, [
				'id_berkas_perkara' => $row['id_berkas_perkara'],
				'tanggal_penerimaan' => $row['tanggal_penerimaan'],
				'tanggal_penerimaan_format' => $tanggal_penerimaan_format,
				'nomor_berkas' => $row['nomor_berkas'],
				'tanggal_berkas' => $row['tanggal_berkas'],
				'tanggal_berkas_format' => $tanggal_berkas_format,
				'file_berkas' => $row['file_berkas'],
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
				'jaksa_terkait_text' => $jaksa_terkait_text,
				'pidana_anak' => $row['pidana_anak'],
				'status' => $row['status'],
				'notifikasi_send' => $row['notifikasi_send'],
				'status_notifikasi' => $status_notifikasi,
				'create_datetime' => $row['create_datetime'],
				'update_datetime' => $row['update_datetime'],
				'nama_user_create' => $nama_user_create,
				'nama_user_update' => $nama_user_update,
				'interval_tanggal_penerimaan' => $interval_tanggal_penerimaan,
				'interval_tanggal_berkas' => $interval_tanggal_berkas,
				'interval_tanggal_spdp' => $interval_tanggal_spdp,
				'interval_tanggal_p16' => $interval_tanggal_p16,
				'interval_tanggal_p17' => $interval_tanggal_p17,
				'interval_tanggal_sop_form_02' => $interval_tanggal_sop_form_02,
				'interval_tanggal_surat_pengembalian_spdp' => $interval_tanggal_surat_pengembalian_spdp,
				'editable' => $editable,
			]);
		}

		echo json_encode([
			'status' => 1,
			'data' => $listData,
			'jaksa_terkait' => $jaksa_terkait,
			'instansi_penyidik' => $instansi_penyidik,
			'tersangka' => $tersangka,
			'status_berkas' => $status_berkas,
		]);
		exit;
	}

	public function getDetail()
	{
		header('Content-Type:application/json');
		$id_berkas_perkara = $this->request->getVar('id_berkas_perkara');

		$listData = [];
		$query = $this->db->query("SELECT * FROM berkas_perkara WHERE id_berkas_perkara = '$id_berkas_perkara'  LIMIT 1");
		foreach ($query->getResult('array') as $row) {

			$interval_tanggal_penerimaan = 0;
			$interval_tanggal_penerimaan = date_diff(date_create($row['tanggal_penerimaan']), date_create(date('Y-m-d')))->days;

			$interval_tanggal_berkas = 0;
			if ($row['tanggal_berkas'] != "") {
				$interval_tanggal_berkas = date_diff(date_create($row['tanggal_berkas']), date_create(date('Y-m-d')))->days;
			}

			$interval_tanggal_spdp = 0;
			if ($row['tanggal_spdp'] != "") {
				$interval_tanggal_spdp = date_diff(date_create($row['tanggal_spdp']), date_create(date('Y-m-d')))->days;
			}

			$interval_tanggal_p16 = 0;
			if ($row['tanggal_p16'] != "") {
				$interval_tanggal_p16 = date_diff(date_create($row['tanggal_p16']), date_create(date('Y-m-d')))->days;
			}

			$interval_tanggal_p17 = 0;
			if ($row['tanggal_p17'] != "") {
				$interval_tanggal_p17 = date_diff(date_create($row['tanggal_p17']), date_create(date('Y-m-d')))->days;
			}

			$interval_tanggal_sop_form_02 = 0;
			if ($row['tanggal_sop_form_02'] != "") {
				$interval_tanggal_sop_form_02 = date_diff(date_create($row['tanggal_sop_form_02']), date_create(date('Y-m-d')))->days;
			}

			$interval_tanggal_surat_pengembalian_spdp = 0;
			if ($row['tanggal_surat_pengembalian_spdp'] != "") {
				$interval_tanggal_surat_pengembalian_spdp = date_diff(date_create($row['tanggal_surat_pengembalian_spdp']), date_create(date('Y-m-d')))->days;
			}

			if ($row['notifikasi_send'] == "Y") {
				$status_notifikasi = "Notifikasi telah dikirim kepada jaksa terkait";
			} else if ($row['notifikasi_send'] == "N") {
				$status_notifikasi = "Menunggu jadwal";
			}

			$id_instansi_penyidik = $row['id_instansi_penyidik'];
			$data_instansi_penyidik = $this->db->query("SELECT * FROM instansi WHERE id_instansi='$id_instansi_penyidik' ")->getRow();

			$array_jaksa_terkait = $row['jaksa_terkait'];
			$data_jaksa_terkait = $this->db->query("SELECT * FROM user WHERE id_user IN ($array_jaksa_terkait) ORDER BY nama_lengkap ASC ");
			$jaksa_terkait_text = "";
			foreach ($data_jaksa_terkait->getResult('array') as $jt) {
				$jaksa_terkait_text .= "<span class='badge btn-primary jaksaBadge'>" . $jt['nama_lengkap'] . "</span> <br>";
			}

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
			}

			$tanggal_spdp_format = "";
			if (($row['tanggal_spdp'] != "0000-00-00") and ($row['tanggal_spdp'] != "")) {
				$tanggal_spdp_format = date('d/m/Y', strtotime($row['tanggal_spdp']));
			}

			$tanggal_p16_format = "";
			if (($row['tanggal_p16'] != "0000-00-00") and ($row['tanggal_p16'] != "")) {
				$tanggal_p16_format = date('d/m/Y', strtotime($row['tanggal_p16']));
			}

			$tanggal_p17_format = "";
			if (($row['tanggal_p17'] != "0000-00-00") and ($row['tanggal_p17'] != "")) {
				$tanggal_p17_format = date('d/m/Y', strtotime($row['tanggal_p17']));
			}

			$tanggal_sop_form_02_format = "";
			if (($row['tanggal_sop_form_02'] != "0000-00-00") and ($row['tanggal_sop_form_02'] != "")) {
				$tanggal_sop_form_02_format = date('d/m/Y', strtotime($row['tanggal_sop_form_02']));
			}

			$tanggal_surat_pengembalian_spdp_format = "";
			if (($row['tanggal_surat_pengembalian_spdp'] != "0000-00-00") and ($row['tanggal_surat_pengembalian_spdp'] != "")) {
				$tanggal_surat_pengembalian_spdp_format = date('d/m/Y', strtotime($row['tanggal_surat_pengembalian_spdp']));
			}

			if (($this->user_level < 3)) {
				$editable = 'Y';
			} else {
				$editable = 'N';
			}

			array_push($listData, [
				'id_berkas_perkara' => $row['id_berkas_perkara'],
				'tanggal_penerimaan' => $row['tanggal_penerimaan'],
				'tanggal_penerimaan_format' => $tanggal_penerimaan_format,
				'nomor_berkas' => $row['nomor_berkas'],
				'tanggal_berkas' => $row['tanggal_berkas'],
				'tanggal_berkas_format' => $tanggal_berkas_format,
				'file_berkas' => $row['file_berkas'],
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
				'jaksa_terkait_text' => $jaksa_terkait_text,
				'pidana_anak' => $row['pidana_anak'],
				'status' => $row['status'],
				'notifikasi_send' => $row['notifikasi_send'],
				'status_notifikasi' => $status_notifikasi,
				'create_datetime' => $row['create_datetime'],
				'update_datetime' => $row['update_datetime'],
				'nama_user_create' => $nama_user_create,
				'nama_user_update' => $nama_user_update,
				'interval_tanggal_penerimaan' => $interval_tanggal_penerimaan,
				'interval_tanggal_berkas' => $interval_tanggal_berkas,
				'interval_tanggal_spdp' => $interval_tanggal_spdp,
				'interval_tanggal_p16' => $interval_tanggal_p16,
				'interval_tanggal_p17' => $interval_tanggal_p17,
				'interval_tanggal_sop_form_02' => $interval_tanggal_sop_form_02,
				'interval_tanggal_surat_pengembalian_spdp' => $interval_tanggal_surat_pengembalian_spdp,
				'editable' => $editable,
			]);
		}

		echo json_encode([
			'status' => 1,
			'data' => $listData,
		]);
		exit;
	}

	public function add()
	{
		$id_user = $this->request->getVar('id_user');
		$tanggal_penerimaan = $this->request->getVar('tanggal_penerimaan');
		$pidana_anak = $this->request->getVar('pidana_anak');

		$nomor_spdp = $this->request->getVar('nomor_spdp');
		$tanggal_spdp = $this->request->getVar('tanggal_spdp');

		$nomor_berkas = $this->request->getVar('nomor_berkas');
		$tanggal_berkas = $this->request->getVar('tanggal_berkas');

		$nomor_p16 = $this->request->getVar('nomor_p16');
		$tanggal_p16 = $this->request->getVar('tanggal_p16');

		$status_berkas = $this->request->getVar('status_berkas');
		$id_instansi_penyidik = $this->request->getVar('id_instansi_penyidik');
		$tersangka = $this->request->getVar('tersangka');
		$jaksa_terkait = $this->request->getVar('jaksa_terkait');

		$nama_file_spdp = "";
		$file_spdp = $this->request->getFile('file_spdp');
		if (!empty($file_spdp)) {;
			$nama_file_spdp = "spdp-" . $file_spdp->getRandomName();
			$file_spdp->move('assets/berkas', $nama_file_spdp);
		}

		$nama_file_berkas = "";
		$file_berkas = $this->request->getFile('file_berkas');
		if (!empty($file_berkas)) {;
			$nama_file_berkas = "berkas-" . $file_berkas->getRandomName();
			$file_berkas->move('assets/berkas', $nama_file_berkas);
		}

		$nama_file_p16 = "";
		$file_p16 = $this->request->getFile('file_p16');
		if (!empty($file_p16)) {
			$nama_file_p16 = "p16-" . $file_p16->getRandomName();
			$file_p16->move('assets/berkas', $nama_file_p16);
		}

		if ($id_user == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan !'
			));
			return false;
		}

		if ($tanggal_penerimaan == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Tanggal penerimaan tidak boleh kosong !'
			));
			return false;
		}

		if ($status_berkas == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Status berkas tidak boleh kosong !'
			));
			return false;
		}

		if ($id_instansi_penyidik == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Instansi penyidik tidak boleh kosong !'
			));
			return false;
		}

		if ($jaksa_terkait == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Jaksa terkait tidak boleh kosong !'
			));
			return false;
		}



		$query = $this->BerkasPerkaraModel->save([
			'tanggal_penerimaan' => $tanggal_penerimaan,
			'nomor_spdp' => $nomor_spdp,
			'tanggal_spdp' => $tanggal_spdp,
			'file_spdp' => $nama_file_spdp,
			'nomor_berkas' => $nomor_berkas,
			'tanggal_berkas' => $tanggal_berkas,
			'file_berkas' => $nama_file_berkas,
			'nomor_p16' => $nomor_p16,
			'tanggal_p16' => $tanggal_p16,
			'file_p16' => $nama_file_p16,
			'status_berkas' => $status_berkas,
			'id_instansi_penyidik' => $id_instansi_penyidik,
			'tersangka' => $tersangka,
			'jaksa_terkait' => $jaksa_terkait,
			'pidana_anak' => $pidana_anak,
			'status' => "Proses",
			'notifikasi_send' => "N",
			'create_datetime' => date("Y-m-d H:i:s"),
			'id_user_create' => $id_user
		]);

		if ($query) {
			echo json_encode(array(
				'success' => '1',
				'pesan' => 'Data berhasil disimpan !'
			));
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Data gagal disimpan !'
			));
		}
	}

	public function add_tambahan_berkas()
	{
		$id_user = $this->request->getVar('id_user');
		$id_berkas_perkara = $this->request->getVar('id_berkas_perkara');
		$mode = $this->request->getVar('mode');

		$nomorTambahanBerkas = $this->request->getVar('nomorTambahanBerkas');
		$tanggalTambahanBerkas = $this->request->getVar('tanggalTambahanBerkas');

		if ($id_user == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'iduser Terjadi kesalahan !'
			));
			return false;
		}

		if ($mode == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => ' mode Terjadi kesalahan !'
			));
			return false;
		}

		if ($id_berkas_perkara == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'idberkas Terjadi kesalahan !'
			));
			return false;
		}

		if ($tanggalTambahanBerkas == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Tanggal berkas tidak boleh kosong !'
			));
			return false;
		}

		if ($nomorTambahanBerkas == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Nomor berkas tidak boleh kosong !'
			));
			return false;
		}

		$namaFileTambahanBerkas = "";
		$title_mode = "";
		$fileTambahanBerkas = $this->request->getFile('fileTambahanBerkas');

		$namaFileTambahanBerkas = $title_mode . $fileTambahanBerkas->getRandomName();
		$fileTambahanBerkas->move('assets/berkas', $namaFileTambahanBerkas);

		if (!empty($fileTambahanBerkas)) {;
			if ($mode == "P-17") {
				$title_mode = "P17-";

				$query = $this->BerkasPerkaraModel->updateBerkasPerkara([
					'nomor_p17' => $nomorTambahanBerkas,
					'tanggal_p17' => $tanggalTambahanBerkas,
					'file_p17' => $namaFileTambahanBerkas,
					'update_datetime' => date("Y-m-d H:i:s"),
					'id_user_update' => $id_user
				], $id_berkas_perkara);
			} elseif ($mode == "SOP-Form 02") {
				$title_mode = "sop-form-02-";

				$query = $this->BerkasPerkaraModel->updateBerkasPerkara([
					'nomor_sop_form_02' => $nomorTambahanBerkas,
					'tanggal_sop_form_02' => $tanggalTambahanBerkas,
					'file_sop_form_02' => $namaFileTambahanBerkas,
					'update_datetime' => date("Y-m-d H:i:s"),
					'id_user_update' => $id_user
				], $id_berkas_perkara);
			} elseif ($mode == "Surat Pengembalian SPDP") {
				$title_mode = "surat-pengembalian-spdp-";

				$query = $this->BerkasPerkaraModel->updateBerkasPerkara([
					'nomor_surat_pengembalian_spdp' => $nomorTambahanBerkas,
					'tanggal_surat_pengembalian_spdp' => $tanggalTambahanBerkas,
					'file_surat_pengembalian_spdp' => $namaFileTambahanBerkas,
					'update_datetime' => date("Y-m-d H:i:s"),
					'id_user_update' => $id_user
				], $id_berkas_perkara);
			}
		}

		if ($query) {
			echo json_encode(array(
				'success' => '1',
				'pesan' => 'Data berhasil disimpan !'
			));
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Data gagal disimpan !'
			));
		}
	}

	public function edit()
	{
		$id_berkas_perkara = $this->request->getVar('id_berkas_perkara');
		$id_user = $this->request->getVar('id_user');
		$tanggal_penerimaan = $this->request->getVar('tanggal_penerimaan');
		$pidana_anak = $this->request->getVar('pidana_anak');
		$nomor_spdp = $this->request->getVar('nomor_spdp');
		$tanggal_spdp = $this->request->getVar('tanggal_spdp');
		$nomor_berkas = $this->request->getVar('nomor_berkas');
		$tanggal_berkas = $this->request->getVar('tanggal_berkas');
		$nomor_p16 = $this->request->getVar('nomor_p16');
		$tanggal_p16 = $this->request->getVar('tanggal_p16');
		$status_berkas = $this->request->getVar('status_berkas');
		$id_instansi_penyidik = $this->request->getVar('id_instansi_penyidik');
		$tersangka = $this->request->getVar('tersangka');
		$jaksa_terkait = $this->request->getVar('jaksa_terkait');

		if ($id_user == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan !'
			));
			return false;
		}

		if ($tanggal_penerimaan == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Tanggal penerimaan tidak boleh kosong !'
			));
			return false;
		}

		if ($status_berkas == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Status berkas tidak boleh kosong !'
			));
			return false;
		}

		if ($id_instansi_penyidik == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Instansi penyidik tidak boleh kosong !'
			));
			return false;
		}

		if ($jaksa_terkait == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Jaksa terkait tidak boleh kosong !'
			));
			return false;
		}

		$cek_berkas = $this->BerkasPerkaraModel->getBerkasPerkara($id_berkas_perkara);

		$file_spdp = $this->request->getFile('file_spdp');
		if (!empty($file_spdp)) {;
			$nama_file_spdp = "spdp-" . $file_spdp->getRandomName();
			$file_spdp->move('assets/berkas', $nama_file_spdp);

			$query_update_file_spdp = $this->BerkasPerkaraModel->updateBerkasPerkara(
				[
					'file_spdp' => $nama_file_spdp,
				],
				$id_berkas_perkara
			);

			if ($cek_berkas['file_spdp'] != "") {
				if (file_exists(base_url() . "/assets/berkas/" . $cek_berkas['file_spdp'])) {
					unlink('assets/berkas/' . $cek_berkas['file_spdp']);
				}
			}
		}

		$file_berkas = $this->request->getFile('file_berkas');
		if (!empty($file_berkas)) {;
			$nama_file_berkas = "berkas-" . $file_berkas->getRandomName();
			$file_berkas->move('assets/berkas', $nama_file_berkas);

			$query_update_file_berkas = $this->BerkasPerkaraModel->updateBerkasPerkara(
				[
					'file_berkas' => $nama_file_berkas,
				],
				$id_berkas_perkara
			);

			if ($cek_berkas['file_berkas'] != "") {
				if (file_exists(base_url() . "/assets/berkas/" . $cek_berkas['file_berkas'])) {
					unlink('assets/berkas/' . $cek_berkas['file_berkas']);
				}
			}
		}

		$file_p16 = $this->request->getFile('file_p16');
		if (!empty($file_p16)) {
			$nama_file_p16 = "p16-" . $file_p16->getRandomName();
			$file_p16->move('assets/berkas', $nama_file_p16);

			$query_update_file_p16 = $this->BerkasPerkaraModel->updateBerkasPerkara(
				[
					'file_p16' => $nama_file_p16,
				],
				$id_berkas_perkara
			);

			if ($cek_berkas['file_p16'] != "") {
				if (file_exists(base_url() . "/assets/berkas/" . $cek_berkas['file_p16'])) {
					unlink('assets/berkas/' . $cek_berkas['file_p16']);
				}
			}
		}

		$query = $this->BerkasPerkaraModel->updateBerkasPerkara([
			'tanggal_penerimaan' => $tanggal_penerimaan,
			'nomor_spdp' => $nomor_spdp,
			'tanggal_spdp' => $tanggal_spdp,
			'nomor_berkas' => $nomor_berkas,
			'tanggal_berkas' => $tanggal_berkas,
			'nomor_p16' => $nomor_p16,
			'tanggal_p16' => $tanggal_p16,
			'status_berkas' => $status_berkas,
			'id_instansi_penyidik' => $id_instansi_penyidik,
			'tersangka' => $tersangka,
			'jaksa_terkait' => $jaksa_terkait,
			'pidana_anak' => $pidana_anak,
			'update_datetime' => date("Y-m-d H:i:s"),
			'id_user_update' => $id_user
		], $id_berkas_perkara);

		if ($query) {
			echo json_encode(array(
				'success' => '1',
				'pesan' => 'Data berhasil diubah !'
			));
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Data gagal diubah !'
			));
		}
	}

	public function delete()
	{
		$id_berkas_perkara = $this->request->getPost('id_berkas_perkara');
		$data_berkas = $this->BerkasPerkaraModel->getBerkasPerkara($id_berkas_perkara);

		if ($id_berkas_perkara == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan teknis !'
			));
			return false;
		}

		if ($data_berkas['file_berkas'] != "") {
			if (file_exists(base_url() . "/assets/berkas/" . $data_berkas['file_berkas'])) {
				unlink('assets/berkas/' . $data_berkas['file_berkas']);
			}
		}

		if ($data_berkas['file_spdp'] != "") {
			if (file_exists(base_url() . "/assets/berkas/" . $data_berkas['file_spdp'])) {
				unlink('assets/berkas/' . $data_berkas['file_spdp']);
			}
		}

		if ($data_berkas['file_p16'] != "") {
			if (file_exists(base_url() . "/assets/berkas/" . $data_berkas['file_p16'])) {
				unlink('assets/berkas/' . $data_berkas['file_p16']);
			}
		}

		if ($data_berkas['file_p17'] != "") {
			if (file_exists(base_url() . "/assets/berkas/" . $data_berkas['file_p17'])) {
				unlink('assets/berkas/' . $data_berkas['file_p17']);
			}
		}

		if ($data_berkas['file_sop_form_02'] != "") {
			if (file_exists(base_url() . "/assets/berkas/" . $data_berkas['file_sop_form_02'])) {
				unlink('assets/berkas/' . $data_berkas['file_sop_form_02']);
			}
		}

		if ($data_berkas['file_surat_pengembalian_spdp'] != "") {
			if (file_exists(base_url() . "/assets/berkas/" . $data_berkas['file_surat_pengembalian_spdp'])) {
				unlink('assets/berkas/' . $data_berkas['file_surat_pengembalian_spdp']);
			}
		}

		$query = $this->BerkasPerkaraModel->deleteBerkasPerkara($id_berkas_perkara);

		if ($query) {
			echo json_encode(array(
				'success' => '1',
				'pesan' => 'Data berhasil dihapus !'
			));
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Data gagal dihapus !'
			));
		}
	}
}
