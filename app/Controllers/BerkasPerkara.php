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
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'Berkas Perkara',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_no_hp' => $this->user_no_hp,
			'user_email' => $this->user_email,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'data_berkas_perkara' => $this->BerkasPerkaraModel->getBerkasPerkara(),
			'list_instansi' => $this->InstansiModel->getListInstansiAktif(),
			'list_jaksa' => $this->UserModel->getListUserAktifByLevel(3),
		];

		return view('berkas-perkara/views', $data);
	}

	public function add()
	{
		$id_user = $this->request->getVar('id_user');
		$pidana_anak = $this->request->getVar('pidana_anak');
		$nomor_berkas = $this->request->getVar('nomor_berkas');
		$tanggal_berkas = $this->request->getVar('tanggal_berkas');
		$nomor_p16 = $this->request->getVar('nomor_p16');
		$tanggal_p16 = $this->request->getVar('tanggal_p16');
		$status_berkas = $this->request->getVar('status_berkas');
		$id_instansi_penyidik = $this->request->getVar('id_instansi_penyidik');
		$id_instansi_pelaksana_penyidikan = $this->request->getVar('id_instansi_pelaksana_penyidikan');
		$jaksa_terkait = $this->request->getVar('jaksa_terkait');

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

		if ($nomor_berkas == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Nomor berkas tidak boleh kosong !'
			));
			return false;
		}

		if ($tanggal_berkas == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Tanggal berkas tidak boleh kosong !'
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

		if ($id_instansi_pelaksana_penyidikan == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Instansi pelaksana penyidikan tidak boleh kosong !'
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

		// if ($pidana_anak != "Ya") {
		// 	$pidana_anak = "Tidak";
		// }

		$query = $this->BerkasPerkaraModel->save([
			'nomor_berkas' => $nomor_berkas,
			'tanggal_berkas' => $tanggal_berkas,
			'file_berkas' => $nama_file_berkas,
			'nomor_p16' => $nomor_p16,
			'tanggal_p16' => $tanggal_p16,
			'file_p16' => $nama_file_p16,
			'status_berkas' => $status_berkas,
			'id_instansi_penyidik' => $id_instansi_penyidik,
			'id_instansi_pelaksana_penyidikan' => $id_instansi_pelaksana_penyidikan,
			'jaksa_terkait' => $jaksa_terkait,
			'pidana_anak' => $pidana_anak,
			'status' => "Proses",
			'notifikasi_send' => "N",
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

	public function edit()
	{
		$id_BerkasPerkara = $this->request->getPost('id_BerkasPerkara');
		$nomor_berkas = $this->request->getPost('nomor_berkas');
		$id_pltd = $this->request->getPost('id_pltd');
		$id_mesin = $this->request->getPost('id_mesin');
		$unit = $this->request->getPost('unit');
		$id_jenis_periodik = $this->request->getPost('id_jenis_periodik');
		$rencana = $this->request->getPost('rencana');
		$realisasi = $this->request->getPost('realisasi');
		$catatan = $this->request->getPost('catatan');

		if ($id_BerkasPerkara == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan teknis !'
			));
			return false;
		}

		if ($nomor_berkas == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Tanggal & Waktu tidak boleh kosong !'
			));
			return false;
		}

		if ($id_pltd == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Data ULPL/PLTD tidak boleh kosong !'
			));
			return false;
		}

		if ($id_mesin == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Data Mesin tidak boleh kosong !'
			));
			return false;
		}

		if ($unit == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Unit tidak boleh kosong !'
			));
			return false;
		}

		if ($id_jenis_periodik == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Jenis periodik tidak boleh kosong !'
			));
			return false;
		}

		if ($rencana == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Rencana tidak boleh kosong !'
			));
			return false;
		}

		if ($realisasi == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Realisasi tidak boleh kosong !'
			));
			return false;
		}

		$query = $this->BerkasPerkaraModel->updateBerkasPerkara([
			'nomor_berkas' => $nomor_berkas,
			'id_pltd' => $id_pltd,
			'id_mesin' => $id_mesin,
			'unit' => $unit,
			'id_jenis_periodik' => $id_jenis_periodik,
			'rencana' => $rencana,
			'realisasi' => $realisasi,
			'catatan' => $catatan
		], $id_BerkasPerkara);

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

	public function delete()
	{
		$id_BerkasPerkara = $this->request->getPost('id_BerkasPerkara');

		if ($id_BerkasPerkara == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan teknis !'
			));
			return false;
		}

		$query = $this->BerkasPerkaraModel->deleteBerkasPerkara($id_BerkasPerkara);

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
