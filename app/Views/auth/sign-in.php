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

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
	<link href='https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.css' type='text/css' rel='stylesheet'>
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

</head>

<body>
	<main class="d-flex w-100" style="background: url('<?= base_url() ?>/assets/img/bg-login.jpg'); background-position: top center; background-size: auto; height: 100vh;">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center mt-4">
										<h1 class="h2">
											SIGN IN
										</h1>
										<h4 class="font-weight-bold">
											APLIKASI MONITORING BERKAS PERKARA
										</h4>
									</div>
									<div class="text-center">
										<img src="<?= base_url(); ?>/assets/img/logo.png" alt="Charles Hall" class="img-fluid" width="100" height="100" />
									</div>
									<h3 class="text-center mt-3">
										KEJAKSAAN NEGERI BERAU
									</h3>
									<hr>
									<form id="formLogin">
										<div class="mb-3">
											<label class="form-label">Username/Email</label>
											<input class="form-control form-control-lg" autofocus type="username" id="username" name="username" placeholder="Masukkan username/email ..." autocomplete="false" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" id="password" name="password" placeholder="Masukkan password ..." autocomplete="false" />
										</div>
										<div>
											<label class="form-check">
												<input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
												<span class="form-check-label">
													Ingat Saya !
												</span>
											</label>
										</div>
										<div class="text-center mt-5">
											<button type="submit" class="btn btn-success btn-block w-100">
												Masuk
											</button>
										</div>
										<div class="text-center mt-4">
											<a href="<?= base_url(); ?>/lupa-password">Lupa Password ?</a>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script>
		$(document).ready(function() {
			$(function() {
				$("#formLogin").submit(function(e) {
					e.preventDefault();

					var username = $('#username').val();
					var password = $('#password').val();

					$.ajax({
						type: "POST",
						url: "<?= base_url() ?>/auth-login",
						dataType: "JSON",
						data: {
							username: username,
							password: password
						},
						beforeSend: function() {
							$("#loader").show();
						},
						success: function(data) {
							if (data.success == "1") {
								Swal.fire(
									'Berhasil',
									data.pesan,
									'success'
								).then(function() {
									window.location = "<?= base_url() ?>";
								});
							} else if (data.success == "0") {
								Swal.fire(
									'Gagal',
									data.pesan,
									'error'
								)
							}
						},
						complete: function(data) {
							$("#loader").hide();
						}
					});

				});

			});
		});
	</script>

</body>

</html>