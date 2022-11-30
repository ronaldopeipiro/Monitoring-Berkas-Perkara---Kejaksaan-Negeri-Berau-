<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
	<div class="row row-deck row-cards">

		<div class="col-lg-12 mb-4">
			<div class="card h-100">

				<div class="card-header">
					<h3 class="card-title font-weight-bold">Pengaturan Email Aplikasi</h3>
				</div>

				<div class="card-body border-bottom py-3">

					<form id="formUpdate">

						<input type="hidden" name="email_lama" id="email_lama" value="<?= $ref_email['email']; ?>">

						<div class="form-group row mt-3">
							<label for="nama_akun" class="col-sm-3 col-form-label">
								Nama Akun
							</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="nama_akun" name="nama_akun" placeholder="Masukkan nama lengkap ..." value="<?= $ref_email['nama_akun'] ?>">
							</div>
						</div>

						<div class="form-group row mt-3">
							<label for="email" class="col-sm-3 col-form-label">
								Email
							</label>
							<div class="col-sm-9">
								<input type="email" class="form-control" id="email" name="email" placeholder="Masukkan alamat email ..." value="<?= $ref_email['email'] ?>">
							</div>
						</div>

						<div class="form-group row mt-3">
							<label for="password" class="col-sm-3 col-form-label">
								Password email
							</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="password" name="password" value="<?= $ref_email['password']; ?>">
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

	</div>
</div>


<script>
	$(document).ready(function() {
		$(function() {

			$("#formUpdate").submit(function(e) {
				e.preventDefault();

				var email_lama = $('#email_lama').val();
				var nama_akun = $('#nama_akun').val();
				var email = $('#email').val();
				var password = $('#password').val();

				$.ajax({
					type: "POST",
					url: base_url + "/pengaturan-email/update",
					dataType: "JSON",
					data: {
						email_lama: email_lama,
						nama_akun: nama_akun,
						password: password,
						email: email,
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

		});
	});
</script>

<?= $this->endSection('content'); ?>