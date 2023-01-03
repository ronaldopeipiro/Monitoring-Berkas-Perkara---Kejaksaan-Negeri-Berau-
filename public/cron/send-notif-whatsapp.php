<?php if ($argc > 1 and $argv[1] == "gyYaOg9me10TQH9ZJXRGMXi132mjX34bDWiGQUme0KTmzRc4YPAETOJ7Cq58YOHugxVyuWcqElE4Uz8QMGTLXvL9ot9N8Ac81xCQ") : ?>

	<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	include "koneksiPDO.php";
	//header('Content-Type:application/json');

	$base_url = "https://kejariberau.id/";

	function send_notif_whatsapp($device_id, $no_hp, $pesan)
	{
		$url = 'https://app.whacenter.com/api/send';
		$ch = curl_init($url);

		$data = array(
			'device_id' => $device_id,
			'number' => $no_hp,
			'message' => $pesan,
			// 'file' => $file,
		);

		$payload = $data;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		// echo json_encode(array(
		// 	'pesan' => $result
		// ));
	}

	// send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', '085161671197', 'Hallo test WA Gateway', '');


	$conn = new createCon();
	$dbh = $conn->connect();

	$status_berkas = 'P-21';

	$sql = 'SELECT * FROM berkas_perkara WHERE status_berkas != :status_berkas';
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam(':status_berkas', $status_berkas);
	$stmt->execute();

	$listData = [];
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		$interval_tanggal_penerimaan = 0;
		$interval_tanggal_berkas = 0;
		$interval_tanggal_pengantar_berkas = 0;
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

		$nama_instansi_penyidik = "";
		if ($row['id_instansi_penyidik'] != "") {
			$id_instansi_penyidik = $row['id_instansi_penyidik'];

			$sql_instansi_penyidik = 'SELECT * FROM instansi WHERE id_instansi = :id_instansi';
			$stmt_instansi_penyidik = $dbh->prepare($sql_instansi_penyidik);
			$stmt_instansi_penyidik->bindParam(':id_instansi', $id_instansi_penyidik);
			$stmt_instansi_penyidik->execute();

			if ($instansi_penyidik = $stmt_instansi_penyidik->fetch(PDO::FETCH_ASSOC)) {
				$nama_instansi_penyidik = $instansi_penyidik['nama_instansi'];
			}
		}

		$nama_jaksa = "";
		$hp_jaksa = "";
		if ($row['jaksa_terkait'] != "") {
			$id_jaksa_terkait = $row['jaksa_terkait'];

			$sql_jaksa_terkait = 'SELECT * FROM user WHERE id_user IN (:id_user) ORDER BY nama_lengkap ASC';
			$stmt_jaksa_terkait = $dbh->prepare($sql_jaksa_terkait);
			$stmt_jaksa_terkait->bindParam(':id_user', $id_jaksa_terkait);
			$stmt_jaksa_terkait->execute();

			if ($jaksa_terkait = $stmt_jaksa_terkait->fetch(PDO::FETCH_ASSOC)) {
				$nama_jaksa = $jaksa_terkait['nama_lengkap'];
				$hp_jaksa = $jaksa_terkait['no_hp'];
			}
		}

		$nama_user_create = "";
		if ($row['id_user_create'] != "") {
			$id_user_create = $row['id_user_create'];

			$sql_user_create = 'SELECT * FROM user WHERE id_user = :id_user';
			$stmt_user_create = $dbh->prepare($sql_user_create);
			$stmt_user_create->bindParam(':id_user', $id_user_create);
			$stmt_user_create->execute();

			if ($user_create = $stmt_user_create->fetch(PDO::FETCH_ASSOC)) {
				$nama_user_create = $user_create['nama_lengkap'];
			}
		}

		$nama_user_update = "";
		if ($row['id_user_update'] != "") {
			$id_user_update = $row['id_user_update'];

			$sql_user_update = 'SELECT * FROM user WHERE id_user = :id_user';
			$stmt_user_update = $dbh->prepare($sql_user_update);
			$stmt_user_update->bindParam(':id_user', $id_user_update);
			$stmt_user_update->execute();

			if ($user_update = $stmt_user_update->fetch(PDO::FETCH_ASSOC)) {
				$nama_user_update = $user_update['nama_lengkap'];
			}
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
			'nama_instansi_penyidik' => $nama_instansi_penyidik,
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
			'interval_tanggal_pengantar_berkas' => $interval_tanggal_pengantar_berkas,
			'interval_tanggal_spdp' => $interval_tanggal_spdp,
			'interval_tanggal_p16' => $interval_tanggal_p16,
			'interval_tanggal_p17' => $interval_tanggal_p17,
			'interval_tanggal_sop_form_02' => $interval_tanggal_sop_form_02,
			'interval_tanggal_surat_pengembalian_spdp' => $interval_tanggal_surat_pengembalian_spdp,
		]);

		$isiPesan = "";
		if (($interval_tanggal_penerimaan >= 5) and ($row["status_berkas"] = "KOSONG")) {
			$isiPesan .= 'Berkas perkara yang anda tangani berikut ini telah melewati ';
			$isiPesan .= $interval_tanggal_penerimaan . ' hari sejak tanggal penerimaan berkas ';

			$url_spdp = '';
			if ($row["file_spdp"] != "" and $row["file_spdp"] != null) {
				$url_spdp = $base_url . 'assets/berkas/' . $row["file_spdp"];
			}

			$pesanNotif = '
Hallo saudara/i 
*' . $nama_jaksa . '*,

' . $isiPesan . '

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ' . $tanggal_penerimaan_format . '
👮 _Instansi Penyidik_ : ' . $nama_instansi_penyidik . ' 
👥 _Tersangka_ : ' . $row["tersangka"] . ' 
🔖 _Status Berkas_ : ' . $row["status_berkas"] . ' 

🪪 _No. SPDP_ : ' . $row["nomor_spdp"] . '
📅 _Tgl. SPDP_ : ' . $tanggal_spdp_format . '
📁 _File SPDP_ : ' . $url_spdp . '

Lihat lebih detail disini
' . $base_url . 'berkas-perkara/detail/' . $row["slug"] . '

Mohon segera melakukan tindak lanjut atas berkas tersebut
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_


TTD
*_KEJAKSAAN NEGERI BERAU_*
';

			if ($hp_jaksa != "" and strlen($hp_jaksa) > 10) {
				// send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', '085161671197', $pesanNotif);
				send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', $hp_jaksa, $pesanNotif);
			}
		}


		// Kirim Pesan P16
		$isiPesanP16 = '';
		if (($interval_tanggal_p16 >= 30) and ($row["status_berkas"] == 'KOSONG')) {

			$isiPesanP16 .= 'Berkas yang anda tangani berikut ini telah melewati ';
			$isiPesanP16 .= $interval_tanggal_p16 . ' hari sejak Surat Perintah P-16 terbit ';

			$url_spdp = '';
			if ($row["file_spdp"] != "" and $row["file_spdp"] != null) {
				$url_spdp = $base_url . 'assets/berkas/' . $row["file_spdp"];
			}

			$pesanNotifP16 = '
Hallo saudara/i 
*' . $nama_jaksa . '*,

' . $isiPesanP16 . '

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ' . $tanggal_penerimaan_format . ' 
👮 _Instansi Penyidik_ : ' . $nama_instansi_penyidik . ' 
👥 _Tersangka_ : ' . $row["tersangka"] . ' 
🔖 _Status Berkas_ : ' . $row["status_berkas"] . ' 

📅 _Tgl. P-16_ : ' . $tanggal_p16_format . ' 
🪪 _No. SPDP_ : ' . $row["nomor_spdp"] . '
📅 _Tgl. SPDP_ : ' . $tanggal_spdp_format . '
📁 _File SPDP_ : ' . $url_spdp . '

Lihat lebih detail disini
' . $base_url . 'berkas-perkara/detail/' . $row["slug"] . '

Mohon segera menerbitkan surat P-17
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_


TTD
*_KEJAKSAAN NEGERI BERAU_*
';

			if ($hp_jaksa != "" and strlen($hp_jaksa) > 10) {
				// send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', '085161671197', $pesanNotifP16);
				send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', $hp_jaksa, $pesanNotifP16);
			}
		}


		// Kirim Pesan P17
		$isiPesanP17 = '';
		if (($interval_tanggal_p17 >= 30) and (($row["status_berkas"] == 'KOSONG') or ($row["status_berkas"] == 'P-17'))) {

			$isiPesanP17 .= 'Berkas yang anda tangani berikut ini telah melewati ';
			$isiPesanP17 .= $interval_tanggal_p17 . ' hari sejak P-17 terbit';

			$pesanNotifP17 = '
Hallo saudara/i 
*' . $nama_jaksa . '*,

' . $isiPesanP17 . '

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ' . $tanggal_penerimaan_format . ' 
📅 _Tgl. P-17_ : ' . $tanggal_p17_format . ' 
👮 _Instansi Penyidik_ : ' . $nama_instansi_penyidik . ' 
👥 _Tersangka_ : ' . $row["tersangka"] . ' 
🔖 _Status Berkas_ : ' . $row["status_berkas"] . ' 

Lihat lebih detail disini
' . $base_url . 'berkas-perkara/detail/' . $row["slug"] . '

Mohon segera menerbitkan SOP Form 02
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_

TTD
*_KEJAKSAAN NEGERI BERAU_*
';

			if ($hp_jaksa != "" and strlen($hp_jaksa) > 10) {
				// send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', '085161671197', $pesanNotifP17);
				send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', $hp_jaksa, $pesanNotifP17);
			}
		}

		// Kirim Pesan P19
		$isiPesanP19 = '';
		if (($interval_tanggal_sop_form_02 >= 14) and ($row["status_berkas"] == 'P-19')) {
			$isiPesanP19 .= 'Berkas yang anda tangani berikut ini telah melewati ';
			$isiPesanP19 .= $interval_tanggal_sop_form_02 . ' hari sejak surat P-19 terbit';

			$pesanNotifP19 = '
Hallo saudara/i 
*' . $nama_jaksa . '*,

' . $isiPesanP19 . '

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ' . $tanggal_penerimaan_format . ' 
📅 _Tgl. P-19_ : ' . $tanggal_sop_form_02_format . ' 
👮 _Instansi Penyidik_ : ' . $nama_instansi_penyidik . ' 
👥 _Tersangka_ : ' . $row["tersangka"] . ' 
🔖 _Status Berkas_ : ' . $row["status_berkas"] . ' 

Lihat lebih detail disini
' . $base_url . 'berkas-perkara/detail/' . $row["slug"] . '	

Mohon segera menerbitkan Surat P-20
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_

TTD
*_KEJAKSAAN NEGERI BERAU_*
';

			if ($hp_jaksa != "" and strlen($hp_jaksa) > 10) {
				// send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', '085161671197', $pesanNotifP19);
				send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', $hp_jaksa, $pesanNotifP19);
			}
		}

		// Kirim Pesan P20
		$isiPesanP20 = '';
		if (($interval_tanggal_surat_pengembalian_spdp >= 14) and ($status_berkas == 'P-20')) {
			$isiPesanP20 .= 'Berkas yang anda tangani berikut ini telah melewati ';
			$isiPesanP20 .= $interval_tanggal_surat_pengembalian_spdp . ' hari sejak P-20 terbit';

			$pesanNotifP20 = '
Hallo saudara/i 
*' . $nama_jaksa . '*,

' . $isiPesanP20 . '

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ' . $tanggal_penerimaan_format . ' 
📅 _Tgl. P-20_ : ' . $tanggal_surat_pengembalian_spdp_format . ' 
👮 _Instansi Penyidik_ : ' . $nama_instansi_penyidik . ' 
👥 _Tersangka_ : ' . $row["tersangka"] . ' 
🔖 _Status Berkas_ : ' . $row["status_berkas"] . ' 

Lihat lebih detail disini
' . $base_url . 'berkas-perkara/detail/' . $row["slug"] . '

Mohon segera menerbitkan Surat Pengembalian SPDP
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_

TTD
*_KEJAKSAAN NEGERI BERAU_*
';

			if ($hp_jaksa != "" and strlen($hp_jaksa) > 10) {
				// send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', '085161671197', $pesanNotifP20);
				send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', $hp_jaksa, $pesanNotifP20);
			}
		}
	}

	echo json_encode([
		'status' => 1,
		'pesan' => 'Berhasil mengirim notifikasi ...',
		// 'data' => $listData,
	]);
	?>

<?php else : ?>
	<h2>
		Terjadi kesalahan !
	</h2>
<?php endif; ?>