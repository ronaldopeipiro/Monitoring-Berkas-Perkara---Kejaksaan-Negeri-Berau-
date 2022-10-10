<?php
setlocale(LC_ALL, 'id-ID', 'id_ID');
?>

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
	<link rel="shortcut icon" href="<?= base_url(); ?>/assets/img/logo.png" />

	<title><?= $title; ?> | APP MONITORING BERKAS PERKARA - KEJARI BERAU</title>
	<link href="<?= base_url(); ?>/template/css/app.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="<?= base_url(); ?>/template/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/template/select2/css/select2.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/template/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/template/dropzone/min/dropzone.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/template/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/template/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>/template/toastr/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<!-- <link rel="stylesheet" href="<?= base_url(); ?>/template/dropify/dist/css/dropify.min.css"> -->
	<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

	<link rel="stylesheet" href="<?= base_url() ?>/template/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">

	<script src="<?= base_url(); ?>/template/js/app.js"></script>

	<script src="<?= base_url(); ?>/template/jquery/jquery.min.js"></script>
	<script src="<?= base_url(); ?>/template/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url(); ?>/template/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>/template/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url(); ?>/template/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

	<script src="<?= base_url(); ?>/template/select2/js/select2.min.js"></script>
	<script src="<?= base_url(); ?>/template/toastr/toastr.min.js"></script>
	<script src="<?= base_url(); ?>/template/sweetalert2/sweetalert2.min.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

	<!-- <script type="text/javascript" src="<?= base_url(); ?>/template/dropify/dist/js/dropify.min.js"></script> -->

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
			<img src="<?= base_url(); ?>/assets/img/loading.gif" style="width: 350px; height: 350px; object-fit: cover; object-position: center;">
		</div>
	</div>

	<div class="wrapper">

		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="<?= base_url(); ?>">
					<span class="align-middle d-flex">
						<img src="<?= base_url(); ?>/assets/img/logo.png" style="height: 55px; margin-top: 7px;" alt="logo">
						<span style="line-height: 20px; margin-top: 5px; margin-left: 5px; font-size: 11px;">
							APLIKASI MONITORING <br>
							BERKAS PERKARA <br>
							KEJAKSAAN NEGERI BERAU
						</span>
					</span>
				</a>
				<hr>
				<div class="text-center">
					<img src="<?= $user_foto ?>" style="width: 100px; height: 100px; object-fit: cover; object-position: top; border-radius: 50%;">
				</div>
				<span class="text-center mt-3 text-white">
					<?= $user_nama_lengkap; ?> <br>
					<i class="text-muted"><?= $user_username; ?></i>
				</span>
				<hr>

				<ul class="sidebar-nav">
					<li class="sidebar-item <?= $request->uri->getSegment(1) == '' ? 'active' : ''; ?>">
						<a class="sidebar-link" href="<?= base_url(); ?>">
							<i class="align-middle" data-feather="home"></i>
							<span class="align-middle">Dashboard</span>
						</a>
					</li>

					<li class="sidebar-item <?= $request->uri->getSegment(1) == 'berkas-perkara' ? 'active' : ''; ?>">
						<a class="sidebar-link" href="<?= base_url(); ?>/berkas-perkara">
							<i class="align-middle" data-feather="file-text"></i>
							<span class="align-middle">
								Berkas Perkara
							</span>
						</a>
					</li>

					<?php if ($user_level < 3) : ?>
						<li class="sidebar-item <?= $request->uri->getSegment(1) == 'data-master' ? 'active' : ''; ?>">
							<a data-target="#data-master" data-toggle="collapse" class="sidebar-link collapsed">
								<i class="align-middle" data-feather="layers"></i>
								<span class="align-middle">Data Master</span>
							</a>
							<ul id="data-master" class="sidebar-dropdown list-unstyled collapse <?= $request->uri->getSegment(1) == 'data-master' ? 'show' : ''; ?>" data-parent="#sidebar">
								<li class="sidebar-item <?= (($request->uri->getSegment(1) == 'data-master') and ($request->uri->getSegment(2) == 'jaksa')) ? 'active' : ''; ?>">
									<a class="sidebar-link" href="<?= base_url(); ?>/data-master/jaksa">
										Data Jaksa
									</a>
								</li>
								<li class="sidebar-item <?= (($request->uri->getSegment(1) == 'data-master') and ($request->uri->getSegment(2) == 'instansi')) ? 'active' : ''; ?>">
									<a class="sidebar-link" href="<?= base_url(); ?>/data-master/instansi">
										Instansi Penyidik/Pelaksana
									</a>
								</li>
							</ul>
						</li>
					<?php endif; ?>

					<li class="sidebar-item <?= $request->uri->getSegment(1) == 'pengaturan' ? 'active' : ''; ?>">
						<a class="sidebar-link" href="<?= base_url(); ?>/pengaturan">
							<i class="align-middle" data-feather="sliders"></i>
							<span class="align-middle">
								Pengaturan
							</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link btn-logout" href="<?= base_url(); ?>/logout-user">
							<i class="align-middle" data-feather="log-out"></i>
							<span class="align-middle">Logout</span>
						</a>
					</li>

				</ul>

			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg modal-static">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center mt-2"></i>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown" style="margin-left: 100px;">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
								<img src="<?= $user_foto; ?>" class="avatar img-fluid me-1" style="height: 40px; height: 40px; object-fit: cover; object-position: top; border-radius: 50%;" alt="User" />
								<span class="text-dark"><?= $user_nama_lengkap; ?></span>
							</a>

							<div class="dropdown-menu dropdown-menu-right" style="width: 180px;">
								<div class="dropdown-divider"></div>
								<div class="text-center d-block">
									<img src="<?= $user_foto; ?>" class="img-fluid me-1" style="width: 100px; height: 100px; object-fit: cover; object-position: top; border-radius: 50%;" alt="User" />
									<div>
										<span class="text-dark"><?= $user_nama_lengkap; ?></span> <br>
										<small><?= $user_username; ?></small>
									</div>
									<hr>
								</div>

								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?= base_url(); ?>/pengaturan">
									<i class="align-middle me-1" data-feather="settings"></i> Pengaturan
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item btn-logout" href="<?= base_url(); ?>/logout-user">
									<i class="align-middle me-1" data-feather="user"></i> Keluar
								</a>
								<div class="dropdown-divider"></div>
								<div class="dropdown-divider"></div>
							</div>
						</li>

					</ul>
				</div>
			</nav>

			<main class="content">
				<?= $this->renderSection('content'); ?>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-lg-9 text-start">
							<p class="mb-0">
								<a href="<?= base_url(); ?>" class="text-muted">
									<strong>KEJAKSAAN NEGERI BERAU</strong>
								</a> &copy; <?= date("Y"); ?>
							</p>
						</div>
						<div class="col-lg-3 text-end">
							<ul class="list-inline d-flex justify-content-between">
								<li class="list-inline-item">
									<a class="text-muted" href="https://wa.me/+6285750597580" target="_blank">Bantuan</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="<?= base_url(); ?>/panduan-aplikasi">Panduan</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="<?= base_url(); ?>/tentang-aplikasi">Versi 1.0</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>

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

		$(function() {
			$('[data-toggle="tooltip"]').tooltip()

		})
	</script>

</body>

</html>