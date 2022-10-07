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

class Jaksa extends BaseController
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
			'title' => 'Data Jaksa',
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_no_hp' => $this->user_no_hp,
			'user_email' => $this->user_email,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'data_jaksa' => $this->UserModel->getUserAktifByLevel(3)
		];

		return view('data-master/jaksa/views', $data);
	}

	public function add()
	{
		$nama_lengkap = $this->request->getPost('nama_lengkap');
		$username = $this->request->getPost('username');
		$email = $this->request->getPost('email');
		$no_hp = $this->request->getPost('no_hp');
		$password = $this->request->getPost('password');
		$konfirmasi_password = $this->request->getPost('konfirmasi_password');

		if ($nama_lengkap == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Nama lengkap tidak boleh kosong !'
			));
			return false;
		}

		if ($username == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Username tidak boleh kosong !'
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

		if ($password == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Password tidak boleh kosong !'
			));
			return false;
		}

		if ($konfirmasi_password == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Konfirmasi password tidak boleh kosong !'
			));
			return false;
		}

		if ($password == $konfirmasi_password) {
			$query = $this->UserModel->updateUser(
				[
					'password' => $password_baru_hash
				],
				$this->id_user
			);

			if ($query) {
				echo json_encode(array(
					'success' => '1',
					'pesan' => 'Password berhasil diubah !'
				));
			} else {
				echo json_encode(array(
					'success' => '0',
					'pesan' => 'Password gagal diubah !'
				));
			}
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Password baru yang anda masukkan tidak sesuai dengan konfirmasi !'
			));
			return false;
		}

		$cek_username = $this->db->query("SELECT * FROM user WHERE id_user != '$this->id_user' AND username='$username' ");
		if ($cek_username->getNumRows() > 0) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Username telah digunakan !'
			));
			return false;
		}

		$password_baru_hash = password_hash($password, PASSWORD_DEFAULT);
		$query = $this->UserModel->updateUser([
			'id_level' => '3',
			'username' => $username,
			'password' => $password_baru_hash,
			'nama_lengkap' => $nama_lengkap,
			'email' => $email,
			'no_hp' => $no_hp,
			'aktif' => 'Y',
		], $this->id_user);

		if ($query) {
			echo json_encode(array(
				'success' => '1',
				'pesan' => 'Data akun berhasil disimpan !'
			));
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Data akun gagal disimpan !'
			));
		}
	}

	public function ubah_data_akun()
	{
		$nama_lengkap = $this->request->getPost('nama_lengkap');
		$username = $this->request->getPost('username');
		$email = $this->request->getPost('email');
		$no_hp = $this->request->getPost('no_hp');

		if ($nama_lengkap == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Nama lengkap tidak boleh kosong !'
			));
			return false;
		}

		if ($username == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Username tidak boleh kosong !'
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

		$cek_username = $this->db->query("SELECT * FROM user WHERE id_user != '$this->id_user' AND username='$username' ");
		if ($cek_username->getNumRows() > 0) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Username telah digunakan !'
			));
			return false;
		}

		$query = $this->UserModel->updateUser([
			'nama_lengkap' => $nama_lengkap,
			'username' => $username,
			'email' => $email,
			'no_hp' => $no_hp
		], $this->id_user);

		if ($query) {
			echo json_encode(array(
				'success' => '1',
				'pesan' => 'Data akun berhasil diubah !'
			));
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Data akun gagal diubah !'
			));
		}
	}


	public function ubah_password()
	{
		$password_lama = $this->request->getPost('password_lama');
		$password_baru = $this->request->getPost('password_baru');
		$konfirmasi_password = $this->request->getPost('konfirmasi_password');

		if ($password_lama == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Password lama tidak boleh kosong !'
			));
			return false;
		}

		if ($password_baru == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Password baru tidak boleh kosong !'
			));
			return false;
		}

		if ($konfirmasi_password == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Konfirmasi password tidak boleh kosong !'
			));
			return false;
		}

		$cek_password_lama = ($this->db->query("SELECT * FROM user WHERE id_user='$this->id_user' "))->getRow();
		if (password_verify($password_lama, $cek_password_lama->password)) {
			if ($password_baru == $konfirmasi_password) {
				$password_baru_hash = password_hash($password_baru, PASSWORD_DEFAULT);
				$query = $this->UserModel->updateUser(
					[
						'password' => $password_baru_hash
					],
					$this->id_user
				);

				if ($query) {
					echo json_encode(array(
						'success' => '1',
						'pesan' => 'Password berhasil diubah !'
					));
				} else {
					echo json_encode(array(
						'success' => '0',
						'pesan' => 'Password gagal diubah !'
					));
				}
			} else {
				echo json_encode(array(
					'success' => '0',
					'pesan' => 'Password baru yang anda masukkan tidak sesuai dengan konfirmasi !'
				));
				return false;
			}
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Password lama yang anda masukkan salah !'
			));
			return false;
		}
	}

	public function ubah_foto_profil()
	{
		$file_foto = $this->request->getFile('foto');

		$nama_foto = $file_foto->getRandomName();
		$image = \Config\Services::image()
			->withFile($file_foto)
			->save(FCPATH . '/assets/img/user/' . $nama_foto, 100);
		$file_foto->move(WRITEPATH . 'assets/img/user');

		$thumbnail = \Config\Services::image()
			->withFile(FCPATH . '/assets/img/user/' . $nama_foto)
			->resize(150, 150, true, 'height')
			->save(FCPATH . '/assets/img/user/thumbnail/' . $nama_foto);

		$query = $this->UserModel->updateUser([
			'foto' => $nama_foto
		], $this->id_user);

		$data_lama = $this->UserModel->getUser($this->id_user);
		if ($data_lama['foto'] != '') {
			unlink('assets/img/user/thumbnail/' . $data_lama['foto']);
			unlink('assets/img/user/' . $data_lama['foto']);
		}

		if ($query) {
			echo json_encode(array(
				'success' => '1',
				'pesan' => 'Foto profil berhasil disimpan !'
			));
		} else {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Foto profil gagal disimpan !'
			));
		}
	}
}
