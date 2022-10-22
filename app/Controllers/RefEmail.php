<?php

namespace App\Controllers;

use \App\Models\RefEmailModel;
use \App\Models\LevelUserModel;
use \App\Models\UserModel;

class RefEmail extends BaseController
{
	public function __construct()
	{
		$this->RefEmailModel = new RefEmailModel();
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
			$this->user_foto_thumbnail = base_url() . "/assets/img/user/" .    $data_user['foto'];
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
			'title' => 'Pengaturan Email Aplikasi',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_no_hp' => $this->user_no_hp,
			'user_email' => $this->user_email,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'ref_email' => $this->RefEmailModel->getRefEmail()
		];

		return view('pengaturan/email', $data);
	}

	public function update()
	{
		$email_lama = $this->request->getPost('email_lama');
		$nama_akun = $this->request->getPost('nama_akun');
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');

		if ($email_lama == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan teknis !'
			));
			return false;
		}

		if ($email == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Email tidak boleh kosong !'
			));
			return false;
		}

		if ($nama_akun == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Nama akun tidak boleh kosong !'
			));
			return false;
		}

		if ($password == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Password email tidak boleh kosong !'
			));
			return false;
		}

		$query = $this->RefEmailModel->updateRefEmail([
			'email' => $email,
			'nama_akun' => $nama_akun,
			'password' => $password,
			'update_datetime' => date('Y-m-d H:i:s')
		], $email_lama);

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
}
