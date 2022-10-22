<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
	<div class="row row-deck row-cards">

		<div class="col-lg-8 mb-4">
			<div class="card h-100">

				<div class="card-header">
					<h3 class="card-title">Profil</h3>
				</div>

				<div class="card-body border-bottom py-3">

					<form id="formUpdateDataAkun">

						<div class="form-group row mt-3">
							<label for="nama_lengkap" class="col-sm-3 col-form-label">
								Nama Lengkap
							</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap ..." value="<?= $user_nama_lengkap ?>">
							</div>
						</div>

						<div class="form-group row mt-3">
							<label for="username" class="col-sm-3 col-form-label">
								Username
							</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="username" name="username" value="<?= $user_username; ?>">
							</div>
						</div>

						<div class="form-group row mt-3">
							<label for="email" class="col-sm-3 col-form-label">
								Email
							</label>
							<div class="col-sm-9">
								<input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email ..." value="<?= $user_email ?>">
							</div>
						</div>

						<div class="form-group row mt-3">
							<label for="no_hp" class="col-sm-3 col-form-label">
								No. Handphone
							</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan No. Handphone ..." value="<?= $user_no_hp ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" minlength="11">
							</div>
						</div>

						<div class="form-group row mt-4">
							<div class="col-sm-9 offset-3">
								<button type="submit" class="shadow btn btn-outline-success pl-4 pr-4" style="width: 180px;">
									<i class="fa fa-save" style="margin-right: 10px;"></i> SIMPAN
								</button>
							</div>
						</div>

					</form>

				</div>

			</div>
		</div>

		<div class="col-lg-4 mb-4">
			<div class="card h-100">
				<div class="card-header">
					<h3 class="card-title">
						<i class="fa fa-edit"></i>
						Ubah Foto Profil
					</h3>
				</div>
				<div class="card-body border-bottom py-3">

					<form id="formUbahFotoProfil">

						<div class="form-group row mt-3">
							<div class="col-lg-12 text-center">
								<img id="fotobaru" src="<?= $user_foto; ?>" style="width: 180px; height: 180px; border-radius: 50%; object-fit: cover; object-position: top; border: solid 1px #ccc; padding: 1px;">
							</div>
							<div class="col-sm-12 mt-3">
								<input type="file" class="form-control" id="foto" name="foto" required onchange="readURL(this)" accept="image/png, image/jpg, image/jpeg">
							</div>
						</div>

						<div class="form-group row mt-4 mb-2">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-block btn-outline-success shadow" style="width: 100%;">
									<span class="fa fa-save" style="margin-right: 10px;"></span> SIMPAN
								</button>
							</div>
						</div>

					</form>

				</div>

			</div>
		</div>

		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
						<i class="fa fa-edit"></i>
						Ubah Password
					</h3>
				</div>
				<div class="card-body border-bottom py-3">

					<form id="formUpdatePassword">
						<?= csrf_field(); ?>

						<div class="form-group row mt-3">
							<label for="password_lama" class="col-sm-3 col-form-label">
								Password lama
							</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password_lama" name="password_lama" placeholder="Masukkan password lama ..." value="">
							</div>
						</div>

						<div class="form-group row mt-3">
							<label for="password_baru" class="col-sm-3 col-form-label">
								Password Baru
							</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="Masukkan password baru ..." value="">
							</div>
						</div>

						<div class="form-group row mt-3">
							<label for="konfirmasi_password" class="col-sm-3 col-form-label">
								Konfirmasi Password Baru
							</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" placeholder="Masukkan konfirmasi password  ..." value="">
							</div>
						</div>

						<div class="form-group row mt-4 mb-2">
							<div class="col-sm-3"></div>
							<div class="col-sm-9 text-right">
								<button type="submit" class="btn btn-outline-success shadow" style="width: 180px;">
									<span class="fa fa-save" style="margin-right: 10px;"></span> SIMPAN
								</button>
							</div>
						</div>

					</form>

				</div>

			</div>
		</div>

		<div class="col-lg-12 mb-2">
			<div class="card shadow">
				<div class="card-body border-bottom py-4">
					<a href="<?= base_url(); ?>/logout" class="btn btn-outline-dark btn-logout shadow" style="width: 220px;">
						<i class="fa fa-sign-out-alt" style="margin-right: 10px;"></i> Keluar dari Aplikasi
					</a>
				</div>
			</div>
		</div>

	</div>
</div>


<script>
	$(document).ready(function() {
		$(function() {

			$("#formUpdateDataAkun").submit(function(e) {
				e.preventDefault();

				var nama_lengkap = $('#nama_lengkap').val();
				var username = $('#username').val();
				var email = $('#email').val();
				var no_hp = $('#no_hp').val();

				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>/pengaturan/ubah-data-akun",
					dataType: "JSON",
					data: {
						nama_lengkap: nama_lengkap,
						username: username,
						email: email,
						no_hp: no_hp
					},
					beforeSend: function() {
						$("#loader").show();
					},
					success: function(data) {
						if (data.success == "1") {
							toastr.success(data.pesan);
							location.reload();
						} else if (data.success == "0") {
							toastr.error(data.pesan);
						}
					},
					complete: function(data) {
						$("#loader").hide();
					}
				});

			});

			$("#formUpdatePassword").submit(function(e) {
				e.preventDefault();

				var password_lama = $('#password_lama').val();
				var password_baru = $('#password_baru').val();
				var konfirmasi_password = $('#konfirmasi_password').val();

				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>/pengaturan/ubah-password",
					dataType: "JSON",
					data: {
						password_lama: password_lama,
						password_baru: password_baru,
						konfirmasi_password: konfirmasi_password,
					},
					beforeSend: function() {
						$("#loader").show();
					},
					success: function(data) {
						if (data.success == "1") {
							toastr.success(data.pesan);
							location.reload();
						} else if (data.success == "0") {
							toastr.error(data.pesan);
						}
					},
					complete: function(data) {
						$("#loader").hide();
					}
				});

			});

			$("#formUbahFotoProfil").submit(function(e) {
				e.preventDefault();
				const foto = $('#foto').prop('files')[0];

				let formData = new FormData();
				formData.append('foto', foto);

				$.ajax({
					type: "POST",
					url: "<?= base_url() ?>/pengaturan/ubah-foto-profil",
					dataType: "JSON",
					data: formData,
					cache: false,
					processData: false,
					contentType: false,
					beforeSend: function() {
						$("#loader").show();
					},
					success: function(data) {
						if (data.success == "1") {
							toastr.success(data.pesan);
							location.reload();
						} else if (data.success == "0") {
							toastr.error(data.pesan);
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

<?= $this->endSection('content'); ?>