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
		$tanggal_waktu = $this->request->getPost('tanggal_waktu');
		$id_user = $this->request->getPost('id_user');
		$id_pltd = $this->request->getPost('id_pltd');
		$id_mesin = $this->request->getPost('id_mesin');
		$unit = $this->request->getPost('unit');
		$id_jenis_periodik = $this->request->getPost('id_jenis_periodik');
		$rencana = $this->request->getPost('rencana');
		$realisasi = $this->request->getPost('realisasi');
		$catatan = $this->request->getPost('catatan');

		if ($tanggal_waktu == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Tanggal & Waktu tidak boleh kosong !'
			));
			return false;
		}

		if ($id_user == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Nama pelapor tidak boleh kosong !'
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

		$query = $this->BerkasPerkaraModel->save([
			'tanggal_waktu' => $tanggal_waktu,
			'id_user' => $id_user,
			'id_pltd' => $id_pltd,
			'id_mesin' => $id_mesin,
			'unit' => $unit,
			'id_jenis_periodik' => $id_jenis_periodik,
			'rencana' => $rencana,
			'realisasi' => $realisasi,
			'catatan' => $catatan
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
		$tanggal_waktu = $this->request->getPost('tanggal_waktu');
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

		if ($tanggal_waktu == "") {
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
			'tanggal_waktu' => $tanggal_waktu,
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
