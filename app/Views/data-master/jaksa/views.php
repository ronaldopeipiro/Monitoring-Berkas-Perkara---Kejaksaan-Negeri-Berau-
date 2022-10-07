<?php
if ($user_level > 2) {
	header('Location: ' . base_url());
	exit();
}
?>

<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
	<div class="row row-deck row-cards">

		<div class="col-lg-12 mb-4">
			<div class="card h-100">

				<div class="card-header">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="card-title">
							Data Jaksa
						</h3>
						<div>
							<?php if ($user_level <= 2) : ?>
								<a href="#" class="btn btn-success text-white btnShowModalInput" data-toggle="modal" data-target="#modalInput" data-title="Tambah Data Jaksa" data-action="tambah" data-toggle="tooltip" data-placement="bottom" title="Tambah Data">
									<i class="align-middle" data-feather="user-plus"></i> Tambah
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="card-body border-bottom pb-1 row">

					<div class="col-12">
						<!-- <a id="card-view-table" class="btn btn-success" href="#">CARD VIEW</a> -->

						<table class="table table-sm table-hover table-responsive-sm table-striped" id="data-table-custom" style="font-size: 12px;">
							<thead>
								<tr>
									<th>No.</th>
									<th>Foto</th>
									<th>Nama Lengkap</th>
									<th>Username</th>
									<th>Email</th>
									<th>No. Handphone</th>
									<th>Create at</th>
									<th>Update at</th>
									<th>Last Login</th>
									<?php if ($user_level <= 2) : ?>
										<th>Aksi</th>
									<?php endif; ?>
								</tr>
							</thead>

							<tbody>
								<?php $no = 1; ?>
								<?php foreach ($data_jaksa as $row) : ?>
									<?php
									$update_datetime = "";
									if ($row['update_datetime'] != "0000-00-00 00:00:00") {
										$update_datetime = date('d/m/Y H:i:s', strtotime($row['update_datetime']));
									}

									$last_login = "";
									if ($row['last_login'] != "0000-00-00 00:00:00") {
										$last_login = date('d/m/Y H:i:s', strtotime($row['last_login']));
									}
									?>
									<tr>
										<td class="text-center">
											<?= $no++; ?>.
										</td>
										<td class="text-left">
											<img src="<?= (empty($row['foto'])) ? base_url() . '/assets/img/noimg.png' : base_url() . '/assets/img/user/thumbnail/' . $row['foto']; ?>" style="width: 50px; height: 50px; object-fit: cover; object-position: top; border-radius: 50%;">
										</td>
										<td class="text-left" style="width: 15%;">
											<?= $row['nama_lengkap']; ?>
										</td>
										<td class="text-left" style="width: 15%;">
											<?= $row['username']; ?>
										</td>
										<td class="text-left">
											<?= $row['email']; ?>
										</td>
										<td class="text-left">
											<?= $row['no_hp']; ?>
										</td>
										<td>
											<?= date('d/m/Y H:i:s', strtotime($row['create_datetime'])); ?>
										</td>
										<td>
											<?= $update_datetime; ?>
										</td>
										<td>
											<?= $last_login; ?>
										</td>
										<?php if ($user_level <= 2) : ?>
											<td class="table-action">
												<div class="list-unstyled d-flex align-items-center justify-content-center">
													<li>
														<a href="#" class="btn btn-info text-white btnShowModalDetail" data-toggle="modal" data-target="#modalDetail" data-title="Detail Data Jaksa" data-id="<?= $row['id_user']; ?>" data-fotoprofil="<?= (empty($row['foto'])) ? base_url() . '/assets/img/noimg.png' : base_url() . '/assets/img/user/thumbnail/' . $row['foto']; ?>" data-namalengkap="<?= $row['nama_lengkap']; ?>" data-username="<?= $row['username']; ?>" data-email="<?= $row['email']; ?>" data-nohp="<?= $row['no_hp']; ?>" data-createat="<?= date('d/m/Y H:i:s', strtotime($row['create_datetime'])); ?>" data-updateat="<?= $update_datetime; ?>" data-lastlogin="<?= $last_login; ?>" data-toggle="tooltip" data-placement="bottom" title="Detail">
															<i class="align-middle" data-feather="list"></i>
														</a>
													</li>
													<li>
														<a href="#" class="btn btn-warning text-white btnShowModalInput" data-toggle="modal" data-target="#modalInput" data-action="ubah" data-title="Ubah Data Jaksa" data-id="<?= $row['id_user']; ?>" data-namalengkap="<?= $row['nama_lengkap']; ?>" data-username="<?= $row['username']; ?>" data-email="<?= $row['email']; ?>" data-nohp="<?= $row['no_hp']; ?>" data-toggle="tooltip" data-placement="bottom" title="Ubah Data Akun">
															<i class="align-middle" data-feather="user"></i>
														</a>
													</li>
													<li>
														<a href="#" class="btn btn-dark text-white btnShowModalInput" data-toggle="modal" data-target="#modalInput" data-action="ubah-password" data-title="Ubah Password Akun" data-id="<?= $row['id_user']; ?>" data-namalengkap="<?= $row['nama_lengkap']; ?>" data-username="<?= $row['username']; ?>" data-email="<?= $row['email']; ?>" data-nohp="<?= $row['no_hp']; ?>" data-toggle="tooltip" data-placement="bottom" title="Ubah Password">
															<i class="align-middle" data-feather="lock"></i>
														</a>
													</li>
													<li>
														<a href="#" onclick="hapus_data(<?= $row['id_user'] ?>)" class="btn btn-danger text-white" data-toggle="tooltip" data-placement="bottom" title="Hapus">
															<i class="align-middle" data-feather="trash"></i>
														</a>
													</li>
												</div>
											</td>
										<?php endif; ?>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>

				</div>

			</div>
		</div>

	</div>
</div>

<div class="modal fade" id="modalInput" tabindex="10" role="dialog" aria-labelledby="judulForm" aria-hidden="true">
	<div class="modal-lg modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="judulForm" style="color: #000;"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="formInput" enctype="multipart/form-data">
				<div class="modal-body">

					<input type="hidden" id="action" name="action" value="">
					<input type="hidden" id="id_user" name="id_user" value="">

					<div id="inputDataAkunForm">
						<div class="form-group row mb-3">
							<label for="nama_lengkap" class="col-sm-3 col-form-label">
								Nama Lengkap
							</label>
							<div class="col-sm-9">
								<input type="text" autofocus class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap ...">
							</div>
						</div>

						<div class="form-group row mb-3">
							<label for="username" class="col-sm-3 col-form-label">
								Username
							</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username ...">
							</div>
						</div>

						<div class="form-group row mb-3">
							<label for="email" class="col-sm-3 col-form-label">
								Email
							</label>
							<div class="col-sm-9">
								<input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email ..." value="<?= $user_email ?>" autocomplete="false">
							</div>
						</div>

						<div class="form-group row mb-3">
							<label for="no_hp" class="col-sm-3 col-form-label">
								No. Handphone
							</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="62 .... " value="<?= $user_no_hp ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" minlength="11">
							</div>
						</div>
					</div>

					<div id="inputPasswordForm">
						<div class="form-group row mt-3">
							<label for="password" class="col-sm-3 col-form-label">
								Password
							</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password ..." value="" autocomplete="false">
							</div>
						</div>

						<div class="form-group row mt-3">
							<label for="konfirmasi_password" class="col-sm-3 col-form-label">
								Konfirmasi Password
							</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" placeholder="Masukkan konfirmasi password  ..." value="" autocomplete="false">
							</div>
						</div>
					</div>

					<hr>
					<div class="mt-4 d-flex justify-content-between align-items-center w-100">
						<button type="submit" class="btn btn-lg btn-success btn-block">
							<i class="fa fa-save"></i> SIMPAN
						</button>
					</div>

				</div>

			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modalDetail" tabindex="10" role="dialog" aria-labelledby="judulFormDetail" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="judulFormDetail" style="color: #000;"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="text-center">
					<img id="detail_foto_profil" src="" style="width: 100px; height: 100px; object-fit: cover; object-position: top; border-radius: 50%; background-color: #fff;" alt="Foto Profil Jaksa">
				</div>

				<table class="table-sm table-responsive table-borderless">
					<tr>
						<td>Nama Lengkap</td>
						<td>:</td>
						<td>
							<span id="detail_nama_lengkap"></span>
						</td>
					</tr>
					<tr>
						<td>Username</td>
						<td>:</td>
						<td>
							<span id="detail_username"></span>
						</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<td>
							<span id="detail_email"></span>
						</td>
					</tr>
					<tr>
						<td>No. Handphone</td>
						<td>:</td>
						<td>
							<span id="detail_no_hp"></span>
						</td>
					</tr>
					<tr>
						<td>Create at</td>
						<td>:</td>
						<td>
							<span id="detail_create_datetime"></span>
						</td>
					</tr>
					<tr>
						<td>Update at</td>
						<td>:</td>
						<td>
							<span id="detail_update_datetime"></span>
						</td>
					</tr>
					<tr>
						<td>Last Login</td>
						<td>:</td>
						<td>
							<span id="detail_last_login"></span>
						</td>
					</tr>
				</table>

			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$(function() {
			// Modal Ubah
			// $("#modalInput").css("z-index", "1500");
			$("#modalInput").appendTo('body');

			$(document).on('click', '.btnShowModalInput', function() {
				var title = $(this).data('title');
				var action = $(this).data('action');

				$('#modalInput #judulForm').text(title);
				$('#modalInput #action').val(action);

				if (action == "tambah") {

					$("form").trigger("reset");
					$('#inputDataAkunForm').show();
					$('#inputPasswordForm').show();

				} else if (action == "ubah") {
					$('#inputDataAkunForm').show();
					$('#inputPasswordForm').hide();

					var id_user = $(this).data('id');
					var namalengkap = $(this).data('namalengkap');
					var username = $(this).data('username');
					var email = $(this).data('email');
					var no_hp = $(this).data('no_hp');

					$('#modalInput #id_user').val(id_user);
					$('#modalInput #nama_lengkap').val(namalengkap);
					$('#modalInput #username').val(username);
					$('#modalInput #email').val(email);
					$('#modalInput #no_hp').val(no_hp);

				} else if (action == "ubah-password") {
					$('#inputDataAkunForm').hide();
					$('#inputPasswordForm').show();

					var id_user = $(this).data('id');

					$('#modalInput #id_user').val(id_user);
				}
			});

			$("#modalDetail").appendTo('body');
			$(document).on('click', '.btnShowModalDetail', function() {
				var title = $(this).data('title');

				$('#modalDetail #judulFormDetail').text(title);

				var id_user = $(this).data('id');
				var namalengkap = $(this).data('namalengkap');
				var username = $(this).data('username');
				var email = $(this).data('email');
				var no_hp = $(this).data('nohp');
				var create_datetime = $(this).data('createat');
				var update_datetime = $(this).data('updateat');
				var last_login = $(this).data('lastlogin');
				var foto_profil = $(this).data('fotoprofil');

				// $('#modalDetail #detail_id_user').val(id_user);
				$('#modalDetail #detail_nama_lengkap').text(namalengkap);
				$('#modalDetail #detail_username').text(username);
				$('#modalDetail #detail_email').text(email);
				$('#modalDetail #detail_no_hp').text(no_hp);
				$('#modalDetail #detail_create_datetime').text(create_datetime);
				$('#modalDetail #detail_update_datetime').text(update_datetime);
				$('#modalDetail #detail_last_login').text(last_login);
				$('#modalDetail #detail_foto_profil').attr("src", foto_profil);

			});

			// Submit Form
			$("#formInput").submit(function(e) {
				e.preventDefault();

				let formData = new FormData();
				var action = $('#action').val();
				var id_user = $('#id_user').val();
				formData.append('id_user', id_user);

				if (action == "tambah") {
					var urlPost = base_url + "/data-master/ulpl/add";

					var nama_lengkap = $('#nama_lengkap').val();
					var username = $('#username').val();
					var email = $('#email').val();
					var no_hp = $('#no_hp').val();
					var password = $('#password').val();
					var konfirmasi_password = $('#konfirmasi_password').val();

					formData.append('nama_lengkap', nama_lengkap);
					formData.append('username', username);
					formData.append('email', email);
					formData.append('no_hp', no_hp);
					formData.append('password', password);
					formData.append('konfirmasi_password', konfirmasi_password);
				} else if (action == "ubah") {
					var urlPost = base_url + "/data-master/ulpl/edit";

					var nama_lengkap = $('#nama_lengkap').val();
					var username = $('#username').val();
					var email = $('#email').val();
					var no_hp = $('#no_hp').val();

					formData.append('nama_lengkap', nama_lengkap);
					formData.append('username', username);
					formData.append('email', email);
					formData.append('no_hp', no_hp);
				} else if (action == "ubah-password") {
					var urlPost = base_url + "/data-master/ulpl/edit";

					var password = $('#password').val();
					var konfirmasi_password = $('#konfirmasi_password').val();

					formData.append('password', password);
					formData.append('konfirmasi_password', konfirmasi_password);
				}

				$.ajax({
					type: "POST",
					url: urlPost,
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
							$('#modalInput').hide();
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

	function hapus_data(id_user) {
		event.preventDefault(); // prevent form submit

		var urlPost = base_url + "/data-master/ulpl/delete";

		Swal.fire({
			title: "Hapus Data",
			text: "Apakah anda yakin ingin menghapus data ini ?",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Ya",
			cancelButtonText: "Tidak",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "POST",
					url: urlPost,
					dataType: "JSON",
					data: {
						id_user: id_user
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
			}
		});
	}

	$(document).ready(function() {
		var datetime = new Date();
		var tanggalHariIni = datetime.getDate() + '-' + datetime.getMonth() + '-' + datetime.getFullYear();

		var $dTable = $('#data-table-custom').DataTable({
			<?php if ($user_level <= 2) : ?> "dom": '<"d-block d-lg-flex justify-content-between"lf<"btn btn-sm"B>r>t<"d-block d-lg-flex justify-content-between"ip>',
			<?php endif; ?> "paging": true,
			"responsive": true,
			"searching": true,
			"fixedHeader": true,
			"autoWidth": true,
			"deferRender": true,
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				['10', '25', '50', '100', 'Semua']
			],
			"buttons": [{
					extend: 'excelHtml5',
					filename: 'Data Jaksa - UPDK KAPUAS - update ' + tanggalHariIni,
					text: 'Export Excel (*xlsx)',
					exportOptions: {
						// columns: [0, 1, 2, 3, 4, 5],
						stripHtml: true,
						modifier: {
							page: 'current'
						}
					}
				},
				{
					extend: 'pdfHtml5',
					filename: 'Data Jaksa - UPDK KAPUAS - update ' + tanggalHariIni,
					text: 'Export PDF (*pdf)',
					message: 'Data Jaksa',
					messageBottom: 'Data dibuat otomatis oleh sistem : ' + tanggalHariIni,
					exportOptions: {
						// columns: [0, 1, 2, 3, 4, 5],
						stripHtml: true,
						modifier: {
							page: 'current'
						}
					},
					orientation: 'portrait',
					pageSize: 'LEGAL',
					customize: function(doc) {
						doc.pageMargins = [20, 20, 20, 20];
						doc.defaultStyle.fontSize = 10;
						doc.styles.tableHeader.fontSize = 10;
						doc.styles.title.fontSize = 14;
						doc.content[0].text = doc.content[0].text.trim();
						doc['footer'] = (function(page, pages) {
							return {
								columns: [
									'Data Jaksa',
									{
										alignment: 'right',
										text: ['Page ', {
											text: page.toString()
										}, ' of ', {
											text: pages.toString()
										}]
									}
								],
								margin: [10, 0]
							}
						});
						var objLayout = {};
						// Horizontal line thickness
						objLayout['hLineWidth'] = function(i) {
							return .5;
						};
						// Vertikal line thickness
						objLayout['vLineWidth'] = function(i) {
							return .5;
						};
						// Horizontal line color
						objLayout['hLineColor'] = function(i) {
							return '#aaa';
						};
						// Vertical line color
						objLayout['vLineColor'] = function(i) {
							return '#aaa';
						};
						// Left padding of the cell
						objLayout['paddingLeft'] = function(i) {
							return 4;
						};
						// Right padding of the cell
						objLayout['paddingRight'] = function(i) {
							return 4;
						};
						// Inject the object in the document
						doc.content[1].layout = objLayout;
					}
				},
			],
			initComplete: function(settings, json) {
				$("#card-view-table").on("click", function() {
					if ($("#data-table-custom").hasClass("card")) {
						$(".colHeader").remove();
					} else {
						var labels = [];
						$("#data-table-custom thead th").each(function() {
							labels.push($(this).text());
						});
						$("#data-table-custom tbody tr").each(function() {
							$(this)
								.find("td")
								.each(function(column) {
									$("<span class='colHeader font-weight-bold'>" + labels[column] + ":</span>").prependTo(
										$(this)
									);
								});
						});
					}
					$("#data-table-custom").toggleClass("card");
				});
			}
		});

	});
</script>

<?= $this->endSection('content'); ?>