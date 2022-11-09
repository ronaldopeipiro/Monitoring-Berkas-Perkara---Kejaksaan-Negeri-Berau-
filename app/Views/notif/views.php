<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="APP MONITORING BERKAS PERKARA - KEJARI BERAU">
	<meta name="author" content="RONALD">
	<meta name="keywords" content="monitoring, berkas, perkara, kejari, kejaksaan, jaksa, kejagung, tersangka, p16, website, web, aplikasi">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="<?= base_url() ?>/assets/img/logo.png" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="Brew">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<meta name="theme-color" content="black">

	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url(); ?>/assets/img/logo.png" type="image/png">
	<link rel="apple-touch-icon" sizes="167x167" href="<?= base_url(); ?>/assets/img/logo.png" type="image/png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>/assets/img/logo.png" type="image/png">

	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>/assets/img/logo.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>/assets/img/logo.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>/assets/img/logo.png">

	<title><?= $title; ?> | APP MONITORING BERKAS PERKARA - KEJARI BERAU</title>
	<link rel="manifest" href="<?= base_url(); ?>/manifest.json">
	<link href="<?= base_url() ?>/template/css/app.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="<?= base_url() ?>/template/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/select2/css/select2.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/toastr/toastr.min.css">

	<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/sweetalert2/sweetalert2.min.css">


	<script src="<?= base_url() ?>/template/js/app.js"></script>
	<script src="<?= base_url() ?>/template/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>/template/toastr/toastr.min.js"></script>
	<script src="<?= base_url() ?>/template/sweetalert2/sweetalert2.min.js"></script>
	<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

	<script>
		const base_url = "<?= base_url() ?>";

		function send_notif(id_user, tipe_user, text_pesan) {
			const contentEncoding = "aes128gcm";
			$.ajax({
				type: "POST",
				url: base_url + "/notif/send-push-notif",
				dataType: "JSON",
				data: {
					id_user: id_user,
					tipe_user: tipe_user,
					text_pesan: text_pesan,
					ce: contentEncoding
				},
				success: function(data) {
					console.log(data.pesan);
				}
			});
		}

		// send_notif(2, 'admin', "Hallo admin test notifikasi");
	</script>
</head>

<body>

	<script>
		<?php if (session()->getFlashdata('toastr_success')) : ?>
			toastr.success("<?= session()->getFlashdata('toastr_success'); ?>");
		<?php elseif (session()->getFlashdata('toastr_error')) :  ?>
			toastr.error("<?= session()->getFlashdata('toastr_error'); ?>");
		<?php elseif (session()->getFlashdata('toastr_warning')) :  ?>
			toastr.warning("<?= session()->getFlashdata('toastr_warning'); ?>");
		<?php elseif (session()->getFlashdata('toastr_info')) :  ?>
			toastr.info("<?= session()->getFlashdata('toastr_info'); ?>");
		<?php endif; ?>
	</script>

	<div id="loader" style="display: none;">
		<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
			<img src="<?= base_url() ?>/assets/img/loading.gif" style="width: 350px; height: 350px; object-fit: cover; object-position: center;">
		</div>
	</div>

	<div class="wrapper">

		<div class="main">
			<main class="content">

				<?php
				$no = 1;
				?>
				<?php foreach ($berkas_perkara as $row) : ?>
					<?php
					$array_jaksa_terkait = $row['jaksa_terkait'];
					$data_jaksa_terkait = $db->query("SELECT * FROM user WHERE id_user IN ($array_jaksa_terkait) ORDER BY nama_lengkap ASC ");
					?>

					<?php foreach ($data_jaksa_terkait->getResult('array') as $jt) : ?>
						<?php
						$pesan_notif = "";
						$pesan_notif .= "Hallo, saudara/i " . $jt['nama_lengkap'];

						$interval_tanggal_penerimaan = date_diff(date_create($row['tanggal_penerimaan']), date_create(date('Y-m-d')))->days;
						if ($interval_tanggal_penerimaan >= 5) {
							$pesan_notif .= "Berkas Perkara dengan Nomor : " . $row['nomor_berkas'] . " telah melewati 5 hari dari tanggal penerimaan berkas. Mohon segera melakukan tindak lanjut terhadap berkas ini";

						?>
							<script>
								send_notif("<?= $jt['id_user'] ?>", "jaksa", "<?= $pesan_notif ?>")
							</script>
						<?
						}

						$interval_tanggal_berkas = 0;
						if ($row['tanggal_berkas'] != "") {
							$interval_tanggal_berkas = date_diff(date_create($row['tanggal_berkas']), date_create(date('Y-m-d')))->days;
						}

						$interval_tanggal_spdp = 0;
						if ($row['tanggal_spdp'] != "") {
							$interval_tanggal_spdp = date_diff(date_create($row['tanggal_spdp']), date_create(date('Y-m-d')))->days;
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

						?>

					<?php endforeach; ?>
				<?php endforeach; ?>

			</main>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			// 
		});
	</script>

</body>

</html>