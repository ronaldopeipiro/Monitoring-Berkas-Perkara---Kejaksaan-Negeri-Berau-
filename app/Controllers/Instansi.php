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

class Instansi extends BaseController
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
			'title' => 'Data Instansi',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_no_hp' => $this->user_no_hp,
			'user_email' => $this->user_email,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'data_instansi' => $this->InstansiModel->getInstansiAktif(),
		];

		return view('data-master/instansi/views', $data);
	}

	public function add()
	{
		$nama_instansi = $this->request->getPost('nama_instansi');
		$deskripsi = $this->request->getPost('deskripsi');

		if ($nama_instansi == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Nama instansi tidak boleh kosong !'
			));
			return false;
		}

		$query = $this->InstansiModel->save([
			'nama_instansi' => $nama_instansi,
			'deskripsi' => $deskripsi,
			'aktif' => 'Y'
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
		$id_instansi = $this->request->getPost('id_instansi');
		$nama_instansi = $this->request->getPost('nama_instansi');
		$deskripsi = $this->request->getPost('deskripsi');

		if ($id_instansi == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan teknis !'
			));
			return false;
		}

		if ($nama_instansi == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Nama instansi tidak boleh kosong !'
			));
			return false;
		}

		$query = $this->InstansiModel->updateInstansi([
			'nama_instansi' => $nama_instansi,
			'deskripsi' => $deskripsi,
		], $id_instansi);

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
		$id_instansi = $this->request->getPost('id_instansi');

		if ($id_instansi == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan teknis !'
			));
			return false;
		}

		$query = $this->InstansiModel->updateInstansi([
			'aktif' => 'N',
		], $id_instansi);

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
