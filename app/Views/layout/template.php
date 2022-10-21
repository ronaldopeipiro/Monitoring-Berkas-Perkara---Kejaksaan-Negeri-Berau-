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

	<title><?= $title; ?> | APP MONITORING BERKAS PERKARA - KEJARI BERAU</title>
	<link href="<?= base_url() ?>/template/css/app.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="<?= base_url() ?>/template/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/select2/css/select2.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/dropzone/min/dropzone.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/toastr/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<!-- <link rel="stylesheet" href="<?= base_url() ?>/template/dropify/dist/css/dropify.min.css"> -->
	<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

	<link rel="stylesheet" href="<?= base_url() ?>/template/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">


	<script src="<?= base_url() ?>/template/js/app.js"></script>
	<script src="<?= base_url() ?>/template/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>/template/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>/template/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>/template/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url() ?>/template/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

	<script src="<?= base_url() ?>/template/select2/js/select2.min.js"></script>
	<script src="<?= base_url() ?>/template/toastr/toastr.min.js"></script>
	<script src="<?= base_url() ?>/template/sweetalert2/sweetalert2.min.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

	<!-- <script type="text/javascript" src="<?= base_url() ?>/template/dropify/dist/js/dropify.min.js"></script> -->

	<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

	<script>
		const base_url = "<?= base_url() ?>";
	</script>

	<style>
		table.table-bordered.card {
			border: 0 !important;
		}

		table.card thead {
			display: none;
		}

		table.card tbody tr {
			float: left;
			width: 23.8%;
			margin: 0.5em;
			border: 1px solid #bfbfbf;
			border-radius: 0.8em;
			background-color: transparent !important;
			box-shadow: 0.25rem 0.25rem 0.5rem rgba(0, 0, 0, 0.25);
		}

		table.card tbody tr td {
			display: block;
			border: 0;
		}
	</style>
</head>

<body>

	<?php if (session()->getFlashdata('pesan_berhasil')) : ?>
		<script>
			Swal.fire(
				'Berhasil !',
				'<?= session()->getFlashdata('pesan_berhasil'); ?>',
				'success'
			)
		</script>
	<?php elseif (session()->getFlashdata('pesan_gagal')) : ?>
		<script>
			Swal.fire(
				'Gagal !',
				'<?= session()->getFlashdata('pesan_gagal'); ?>',
				'error'
			)
		</script>
	<?php endif; ?>

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

		<?= $this->include('layout/sidebar') ?>

		<div class="main">
			<?= $this->include('layout/navbar') ?>

			<main class="content">
				<?= $this->renderSection('content'); ?>
			</main>

			<?= $this->include('layout/footer') ?>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$(".js-select-2").select2();
			$(".js-select-2-R").select2();
			$(".js-select-2-M").select2();

			$("#data-table").DataTable({
				paging: true,
				responsive: true,
				searching: true,
			});

			$(".btn-hapus").on("click", function(e) {
				event.preventDefault(); // prevent form submit

				Swal.fire({
					title: "Hapus Data",
					text: "Pilih ya, jika anda ingin menghapus data !",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Ya, hapus data !",
					cancelButtonText: "Batal",
				}).then((result) => {
					if (result.isConfirmed) {
						var form = $(this).parents("form");
						form.submit();
					}
				});
			});

			$(".btn-logout").on("click", function(e) {
				event.preventDefault(); // prevent form submit

				Swal.fire({
					title: "Logout",
					text: "Apakah anda yakin ingin keluar dari aplikasi ?",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Ya",
					cancelButtonText: "Tidak",
				}).then((result) => {
					if (result.isConfirmed) {
						window.location.href = $(".btn-logout").attr("href");
					}
				});
			});
		});

		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#fotobaru')
						.attr('src', e.target.result);
				};
				reader.readAsDataURL(input.files[0]);
			}
		}

		// $(function() {
		// 	$('[data-toggle="tooltip"]').tooltip()
		// })
	</script>

</body>

</html>