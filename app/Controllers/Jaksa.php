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

	public function berkas_perkara($id_jaksa_select)
	{
		$jaksa_select = $this->UserModel->getUser($id_jaksa_select);
		$data = [
			'request' => $this->request,
			'db' => $this->db,
			'validation' => $this->validation,
			'title' => 'Berkas Perkara - ' . $jaksa_select['nama_lengkap'],
			'user_id' => $this->id_user,
			'user_nama_lengkap' => $this->user_nama_lengkap,
			'user_username' => $this->user_username,
			'user_no_hp' => $this->user_no_hp,
			'user_email' => $this->user_email,
			'user_level' => $this->user_level,
			'user_foto' => $this->user_foto,
			'list_instansi' => $this->InstansiModel->getListInstansiAktif(),
			'list_jaksa' => $this->UserModel->getListUserAktifByLevel(3),
			'id_jaksa_select' => $id_jaksa_select,
			'jaksa_select' => $jaksa_select
		];

		return view('data-master/jaksa/berkas-perkara', $data);
	}

	public function add()
	{
		$nama_lengkap = $this->request->getPost('nama_lengkap');
		$nip = $this->request->getPost('nip');
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

		if ($nip == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'NIP tidak boleh kosong !'
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

		if ($password != $konfirmasi_password) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Password tidak sesuai dengan konfirmasi !'
			));
			return false;
		}

		$cek_username = $this->db->query("SELECT * FROM user WHERE username='$username' ");
		if ($cek_username->getNumRows() > 0) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Username telah digunakan !'
			));
			return false;
		}

		$cek_email = $this->db->query("SELECT * FROM user WHERE email='$email' ");
		if ($cek_email->getNumRows() > 0) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Email telah digunakan !'
			));
			return false;
		}

		$cek_nip = $this->db->query("SELECT * FROM user WHERE nip='$nip' ");
		if ($cek_nip->getNumRows() > 0) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'NIP telah digunakan !'
			));
			return false;
		}

		$cek_no_hp = $this->db->query("SELECT * FROM user WHERE no_hp='$no_hp' ");
		if ($cek_no_hp->getNumRows() > 0) {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'No. Handphone telah digunakan !'
			));
			return false;
		}

		$password_baru_hash = password_hash($password, PASSWORD_DEFAULT);
		$query = $this->UserModel->save([
			'id_level' => '3',
			'username' => $username,
			'password' => $password_baru_hash,
			'nama_lengkap' => $nama_lengkap,
			'nip' => $nip,
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

	public function edit()
	{

		$id_user = $this->request->getPost('id_user');
		$nama_lengkap = $this->request->getPost('nama_lengkap');
		$nip = $this->request->getPost('nip');
		$username = $this->request->getPost('username');
		$email = $this->request->getPost('email');
		$no_hp = $this->request->getPost('no_hp');

		$data_lama = $this->UserModel->getUser($id_user);

		if ($id_user == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan teknis !'
			));
			return false;
		}

		if ($nama_lengkap == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Nama lengkap tidak boleh kosong !'
			));
			return false;
		}

		if ($nip == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'NIP tidak boleh kosong !'
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

		if ($data_lama['username'] != "") {
			$cek_username = $this->db->query("SELECT * FROM user WHERE id_user != '$id_user' AND username='$username' ");
			if ($cek_username->getNumRows() > 0) {
				echo json_encode(array(
					'success' => '0',
					'pesan' => 'Username telah digunakan !'
				));
				return false;
			}
		}

		if ($data_lama['email'] != $email) {
			$cek_email = $this->db->query("SELECT * FROM user WHERE id_user != '$id_user' AND email='$email' ");
			if ($cek_email->getNumRows() > 0) {
				echo json_encode(array(
					'success' => '0',
					'pesan' => 'Email telah digunakan !'
				));
				return false;
			}
		}

		if ($data_lama['nip'] != $nip) {
			$cek_nip = $this->db->query("SELECT * FROM user WHERE id_user != '$id_user' AND nip='$nip' ");
			if ($cek_nip->getNumRows() > 0) {
				echo json_encode(array(
					'success' => '0',
					'pesan' => 'NIP telah digunakan !'
				));
				return false;
			}
		}

		if ($data_lama['no_hp'] != $no_hp) {
			$cek_no_hp = $this->db->query("SELECT * FROM user WHERE id_user != '$id_user' AND no_hp='$no_hp' ");
			if ($cek_no_hp->getNumRows() > 0) {
				echo json_encode(array(
					'success' => '0',
					'pesan' => 'No. Handphone telah digunakan !'
				));
				return false;
			}
		}

		$query = $this->UserModel->updateUser([
			'nama_lengkap' => $nama_lengkap,
			'nip' => $nip,
			'username' => $username,
			'email' => $email,
			'no_hp' => $no_hp
		], $id_user);

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


	public function update_password()
	{
		$id_user = $this->request->getPost('id_user');
		$password = $this->request->getPost('password');
		$konfirmasi_password = $this->request->getPost('konfirmasi_password');

		if ($id_user == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan teknis !'
			));
			return false;
		}

		if ($password == "") {
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

		if ($password == $konfirmasi_password) {
			$password_hash = password_hash($password, PASSWORD_DEFAULT);

			$query = $this->UserModel->updateUser(
				[
					'password' => $password_hash
				],
				$id_user
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
	}

	public function update_foto_profil()
	{
		$id_user = $this->request->getPost('id_user');
		$file_foto = $this->request->getFile('foto');

		if ($id_user == "") {
			echo json_encode(array(
				'success' => '0',
				'pesan' => 'Terjadi kesalahan teknis !'
			));
			return false;
		}

		$data_lama = $this->UserModel->getUser($id_user);

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
		], $id_user);

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
