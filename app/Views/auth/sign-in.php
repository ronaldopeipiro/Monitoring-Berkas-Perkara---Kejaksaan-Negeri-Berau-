<?= $this->extend('layout-auth/template'); ?>

<?= $this->section('content-auth'); ?>

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
										<label class="form-label">NIP/Username/Email</label>
										<input class="form-control form-control-lg" autofocus type="username" id="username" name="username" placeholder="Masukkan NIP/Username/Email ..." autocomplete="false" />
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
<?= $this->endSection('content-auth'); ?>