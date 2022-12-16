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

	public function encrypt_openssl($string)
	{
		$ciphering = "AES-256-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;
		$encryption_iv = '1234567891011121';
		$encryption_key = "#*PelaporanKecelakaan2021SkripsiRonal#@";

		$encryption = openssl_encrypt(
			$string,
			$ciphering,
			$encryption_key,
			$options,
			$encryption_iv
		);

		return $encryption;
	}

	public function decrypt_openssl($string_encrypt)
	{
		$ciphering = "AES-256-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;

		$decryption_iv = '1234567891011121';
		$decryption_key = "#*PelaporanKecelakaan2021SkripsiRonal#@";

		$decryption = openssl_decrypt(
			$string_encrypt,
			$ciphering,
			$decryption_key,
			$options,
			$decryption_iv
		);

		return $decryption;
	}

	function crypto_rand_secure($min, $max)
	{
		$range = $max - $min;
		if ($range < 1) return $min; // not so random...
		$log = ceil(log($range, 2));
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd > $range);
		return $min + $rnd;
	}

	function getToken($length)
	{
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet .= "0123456789";
		$max = strlen($codeAlphabet); // edited

		for ($i = 0; $i < $length; $i++) {
			$token .= $codeAlphabet[$this->crypto_rand_secure(0, $max - 1)];
		}

		return $token;
	}

	public function index()
	{
		// $berkas_perkara = $this->BerkasPerkaraModel->getBerkasPerkara();
		// foreach ($berkas_perkara as $row) {

		// 	$slug = $this->getToken(100);

		// 	$update_berkas_perkara = $this->BerkasPerkaraModel->updateBerkasPerkara([
		// 		'slug' => $slug
		// 	], $row['id_berkas_perkara']);
		// }

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
			'list_instansi' => $this->InstansiModel->getListInstansiAktif(),
			'list_jaksa' => $this->UserModel->getListUserAktifByLevel(3),
		];

		return view('berkas-perkara/views', $data);
	}

	public function getBerkas($getData)
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
			'list_instansi' => $this->InstansiModel->getListInstansiAktif(),
			'list_jaksa' => $this->UserModel->getListUserAktifByLevel(3),
			'getData' => $getData
		];

		return view('berkas-perkara/views', $data);
	}

	public function add()
	{
		$slug = $this->getToken(100);

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
			'slug' => $slug,
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
