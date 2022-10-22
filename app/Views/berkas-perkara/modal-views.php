<div class="modal fade" id="modalInput" tabindex="10" role="dialog" aria-labelledby="judulForm" aria-hidden="true">
	<div class="modal-xl modal-dialog modal-dialog-centered" role="document">
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
					<input type="hidden" id="id_berkas_perkara" name="id_berkas_perkara" value="">
					<input type="hidden" id="id_user" name="id_user" value="<?= $user_id; ?>">

					<div class="row">

						<div class="col-lg-6">

							<div class="form-group row mb-2">
								<label for="tanggal_penerimaan p-1" class="col-sm-12 col-form-label">
									Tanggal Penerimaan
									<small class="text-danger">(*Wajib diisi !)</small>
								</label>
								<div class="col-sm-12">
									<input type="date" class="form-control" id="tanggal_penerimaan" name="tanggal_penerimaan" placeholder="0" value="<?= date('Y-m-d'); ?>">
								</div>
							</div>

							<div class="form-group row mb-2">
								<label for="id_instansi_penyidik p-1" class="col-sm-12 col-form-label">
									Instansi Penyidik
									<small class="text-danger">(*Wajib diisi !)</small>
								</label>
								<div class="col-sm-12">
									<select name="id_instansi_penyidik" id="id_instansi_penyidik" class="form-control js-select-2">
										<option value=""></option>
										<?php foreach ($list_instansi as $instansi) : ?>
											<option value="<?= $instansi['id_instansi']; ?>">
												<?= $instansi['nama_instansi']; ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group row mb-2">
										<label for="pidana_anak" class="col-sm-12 col-form-label">
											Pidana Anak
											<small class="text-danger">(*Wajib diisi !)</small>
										</label>
										<div class="col-sm-12">
											<select name="pidana_anak" id="pidana_anak" class="form-control">
												<option value="Tidak">Tidak</option>
												<option value="Ya">Ya</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group row mb-2">
										<label for="status_berkas" class="col-sm-12 col-form-label">
											Status Berkas
											<small class="text-danger">(*Wajib diisi !)</small>
										</label>
										<div class="col-sm-12">
											<select name="status_berkas" id="status_berkas" class="form-control">
												<option value="KOSONG">KOSONG</option>
												<option value="P-17">P-17</option>
												<option value="P-18">P-18</option>
												<option value="P-19">P-19</option>
												<option value="P-20">P-20</option>
												<option value="P-21">P-21</option>
											</select>
										</div>
									</div>
								</div>
							</div>

						</div>

						<div class="col-lg-6">
							<div class="form-group row">
								<div class="col-lg-8 mb-3 mb-lg-0">
									<div class="row">
										<label for="nomor_spdp" class="col-sm-12 col-form-label">
											Nomor SPDP
										</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" id="nomor_spdp" name="nomor_spdp" placeholder="Masukkan Nomor SPDP ..." value="">
										</div>
									</div>
								</div>

								<div class="col-lg-4 mb-3 mb-lg-0">
									<div class="row">
										<label for="tanggal_spdp" class="col-sm-12 col-form-label">
											Tanggal SPDP
										</label>
										<div class="col-sm-12">
											<input type="date" class="form-control" id="tanggal_spdp" name="tanggal_spdp" placeholder="0" value="">
										</div>
									</div>
								</div>

								<div class="col-lg-12 mb-3 mb-lg-0 mt-3">
									<div class="form-group row mb-2">
										<label for="file_spdp" class="col-sm-12 col-form-label">
											File SPDP
											<small class="text-info text-file-update">
												(*Jika Ada)
											</small>
										</label>
										<div class="col-sm-12">
											<input type="file" data-default-file="" name="file_spdp" id="file_spdp" class="dropify" data-height="72" data-show-remove="true" data-show-loader="true" data-show-errors="true" data-errors-position="outside" style="font-size: 12px;" />
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<div class="col-lg-8 mb-3 mb-lg-0">
									<div class="row">
										<label for="nomor_berkas" class="col-sm-12 col-form-label">
											Nomor Berkas Tahap 1
										</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" id="nomor_berkas" name="nomor_berkas" placeholder="Masukkan Nomor Berkas ..." value="">
										</div>
									</div>
								</div>

								<div class="col-lg-4 mb-3 mb-lg-0">
									<div class="row">
										<label for="tanggal_berkas" class="col-sm-12 col-form-label">
											Tanggal Berkas Tahap 1
										</label>
										<div class="col-sm-12">
											<input type="date" class="form-control" id="tanggal_berkas" name="tanggal_berkas" placeholder="0" value="">
										</div>
									</div>
								</div>

								<div class="col-lg-12 mb-3 mb-lg-0 mt-3">
									<div class="form-group row mb-2">
										<label for="file_berkas" class="col-sm-12 col-form-label">
											File Berkas Tahap 1
											<small class="text-info text-file-update">
												(*Jika Ada)
											</small>
										</label>
										<div class="col-sm-12">
											<input type="file" data-default-file="" name="file_berkas" id="file_berkas" class="dropify" data-height="72" data-show-remove="true" data-show-loader="true" data-show-errors="true" data-errors-position="outside" style="font-size: 12px;" />
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group row">
								<div class="col-lg-8 mb-3 mb-lg-0">
									<div class="row">
										<label for="nomor_p16" class="col-sm-12 col-form-label">
											Nomor P-16
										</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" id="nomor_p16" name="nomor_p16" placeholder="Masukkan Nomor P-16 ..." value="">
										</div>
									</div>
								</div>

								<div class="col-lg-4 mb-3 mb-lg-0">
									<div class="row">
										<label for="tanggal_p16" class="col-sm-12 col-form-label">
											Tanggal P-16
										</label>
										<div class="col-sm-12">
											<input type="date" class="form-control" id="tanggal_p16" name="tanggal_p16" placeholder="0" value="">
										</div>
									</div>
								</div>

								<div class="col-lg-12 mb-3 mb-lg-0 mt-3">
									<div class="form-group row mb-2">
										<label for="file_p16" class="col-sm-12 col-form-label">
											File P-16
											<small class="text-info text-file-update">
												(*Jika Ada)
											</small>
										</label>
										<div class="col-sm-12">
											<input type="file" data-default-file="" name="file_p16" id="file_p16" class="dropify" data-height="72" data-show-remove="true" data-show-loader="true" data-show-errors="true" data-errors-position="outside" style="font-size: 12px;" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="jaksa_terkait" class="col-sm-12 col-form-label">
							Jaksa Terkait
							<small class="text-danger">(*Wajib diisi !)</small>
						</label>
						<div class="col-sm-12">
							<select name="jaksa_terkait" id="jaksa_terkait" class="form-control js-select-2" multiple>
								<?php foreach ($list_jaksa as $jaksa) : ?>
									<option value="<?= $jaksa['id_user']; ?>">
										<?= $jaksa['nama_lengkap']; ?> (NIP.<?= $jaksa['nip']; ?>)
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

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
	<div class="modal-lg modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="judulFormDetail" style="color: #000;"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">

				<div class="row">

					<div class="col-lg-12 mb-3">
						<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
							<tr>
								<td>Tanggal Penerimaan</td>
								<td>:</td>
								<td>
									<span id="detail_tanggalPenerimaan"></span>
								</td>
							</tr>
							<tr>
								<td>Interval Hari</td>
								<td>:</td>
								<td>
									<span id="detail_intervalHari"></span>
								</td>
							</tr>

							<tr>
								<td>Status Berkas</td>
								<td>:</td>
								<td>
									<span id="detail_statusBerkas"></span>
								</td>
							</tr>
							<tr>
								<td>Pidana Anak</td>
								<td>:</td>
								<td>
									<span id="detail_pidanaAnak"></span>
								</td>
							</tr>
							<tr>
								<td>Instansi Penyidik</td>
								<td>:</td>
								<td>
									<span id="detail_instansiPenyidik"></span>
								</td>
							</tr>
							<tr>
								<td>Jaksa Terkait</td>
								<td>:</td>
								<td>
									<span id="detail_jaksaTerkait"></span>
								</td>
							</tr>
							<tr>
								<td>Diinput oleh</td>
								<td>:</td>
								<td>
									<span id="detail_userCreate"></span>
									<span id="detail_createDatetime"></span>
								</td>
							</tr>
							<tr>
								<td>Diupdate oleh</td>
								<td>:</td>
								<td>
									<span id="detail_userUpdate"></span>
									<span id="detail_updateDatetime"></span>
								</td>
							</tr>
							<tr>
								<td>Notifikasi</td>
								<td>:</td>
								<td>
									<span id="detail_statusNotifikasi"></span>
								</td>
							</tr>
							<tr>
								<td>Status Perkara</td>
								<td>:</td>
								<td>
									<span id="detail_statusPerkara"></span>
								</td>
							</tr>
						</table>

					</div>

					<div class="col-lg-6">
						<div class="card">
							<div class="card-body p-1">

								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tanggal SPDP</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalSPDP"></span>
										</td>
									</tr>
									<tr>
										<td>Nomor SPDP</td>
										<td>:</td>
										<td>
											<span id="detail_nomorSPDP"></span>
										</td>
									</tr>
									<tr>
										<td>File SPDP</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileSpdp" target="_blank">
												Unduh / Lihat file SPDP
											</a>
										</td>
									</tr>
								</table>

							</div>

						</div>
					</div>

					<div class="col-lg-6">
						<div class="card">
							<div class="card-body p-1">

								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tanggal Berkas Tahap 1</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalBerkas"></span>
										</td>
									</tr>
									<tr>
										<td>Nomor Berkas Tahap 1</td>
										<td>:</td>
										<td>
											<span id="detail_nomorBerkas"></span>
										</td>
									</tr>
									<tr>
										<td>File Berkas Tahap 1</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileBerkas" target="_blank">
												Unduh / Lihat file berkas
											</a>
										</td>
									</tr>
								</table>
							</div>

						</div>
					</div>

					<div class="col-lg-6">
						<div class="card">
							<div class="card-body p-1">

								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tanggal P-16</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalP16"></span>
										</td>
									</tr>
									<tr>
										<td>Nomor P-16</td>
										<td>:</td>
										<td>
											<span id="detail_nomorP16"></span>
										</td>
									</tr>
									<tr>
										<td>File P-16</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileP16" target="_blank">
												Unduh / Lihat file P-16
											</a>
										</td>
									</tr>
								</table>

							</div>

						</div>
					</div>

					<div class="col-lg-6">
						<div class="card">
							<div class="card-body p-1">

								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tanggal P-17</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalP17"></span>
										</td>
									</tr>
									<tr>
										<td>Nomor P-17</td>
										<td>:</td>
										<td>
											<span id="detail_nomorP17"></span>
										</td>
									</tr>
									<tr>
										<td>File P-17</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileP17" target="_blank">
												Unduh / Lihat file P-17
											</a>
										</td>
									</tr>
								</table>

							</div>

						</div>
					</div>

					<div class="col-lg-6">
						<div class="card">
							<div class="card-body p-1">

								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tanggal SOP Form 02</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalSopForm"></span>
										</td>
									</tr>
									<tr>
										<td>Nomor SOP Form 02</td>
										<td>:</td>
										<td>
											<span id="detail_nomorSopForm"></span>
										</td>
									</tr>
									<tr>
										<td>File SOP Form 02</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileSopForm" target="_blank">
												Unduh / Lihat file SOP Form 02
											</a>
										</td>
									</tr>
								</table>
							</div>

						</div>
					</div>

					<div class="col-lg-6">
						<div class="card">
							<div class="card-body p-1">

								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tanggal Surat Pengembalian SPDP</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalSuratPengembalianSpdp"></span>
										</td>
									</tr>
									<tr>
										<td>Nomor Surat Pengembalian SPDP</td>
										<td>:</td>
										<td>
											<span id="detail_nomorSuratPengembalianSpdp"></span>
										</td>
									</tr>
									<tr>
										<td>File Surat Pengembalian SPDP</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileSuratPengembalianSpdp" target="_blank">
												Unduh / Lihat file Surat Pengembalian SPDP
											</a>
										</td>
									</tr>
								</table>

							</div>
						</div>
					</div>

				</div>

			</div>

		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		$(function() {
			// $("#modalInput").css("z-index", "1500");

			$("#modalDetail").appendTo('body');

			$(document).on('click', '.btnShowModalDetail', function() {

				var title = $(this).data('title');
				var action = $(this).data('action');
				var idBerkasPerkara = $(this).data('idBerkasPerkara');
				var tanggalPenerimaan = $(this).data('tanggalPenerimaan');
				var tanggalBerkas = $(this).data('tanggalBerkas');
				var nomorBerkas = $(this).data('nomorBerkas');
				var fileBerkas = $(this).data('fileBerkas');
				var tanggalSpdp = $(this).data('tanggalSpdp');
				var nomorSpdp = $(this).data('nomorSpdp');
				var fileSpdp = $(this).data('fileSpdp');
				var tanggalP16 = $(this).data('tanggalP16');
				var nomorP16 = $(this).data('nomorP16');
				var fileP16 = $(this).data('fileP16');
				var tanggalP17 = $(this).data('tanggalP17');
				var nomorP17 = $(this).data('nomorP17');
				var fileP17 = $(this).data('fileP17');
				var tanggalSopForm = $(this).data('tanggalSopForm');
				var nomorSopForm = $(this).data('nomorSopForm');
				var fileSopForm = $(this).data('fileSopForm');
				var tanggalSuratPengembalianSpdp = $(this).data('tanggalSuratPengembalianSpdp');
				var nomorSuratPengembalianSpdp = $(this).data('nomorSuratPengembalianSpdp');
				var fileSuratPengembalianSpdp = $(this).data('fileSuratPengembalianSpdp');
				var instansiPenyidik = $(this).data('instansiPenyidik');
				var dataJaksaTerkait = $(this).data('jaksaTerkait');
				var jaksaTerkait = dataJaksaTerkait.replaceAll(`'`, `"`);
				var pidanaAnak = $(this).data('pidanaAnak');
				var statusBerkas = $(this).data('statusBerkas');
				var status = $(this).data('status');
				var notifikasiSend = $(this).data('notifikasiSend');
				var createDatetime = $(this).data('createDatetime');
				var updateDatetime = $(this).data('updateDatetime');
				var userCreate = $(this).data('userCreate');
				var userUpdate = $(this).data('userUpdate');
				var statusNotifikasi = $(this).data('statusNotifikasi');
				var statusPerkara = $(this).data('statusPerkara');
				var intervalHari = $(this).data('intervalHari');

				$('#modalDetail #judulFormDetail').html(title);
				$('#modalDetail #detail_idBerkasPerkara').html(idBerkasPerkara);

				$('#modalDetail #detail_tanggalPenerimaan').html(tanggalPenerimaan);

				$('#modalDetail #detail_tanggalSpdp').html(tanggalSpdp);
				$('#modalDetail #detail_nomorSpdp').html(nomorSpdp);
				if (fileSpdp != "") {
					$('#modalDetail #detail_fileSpdp').attr("href", fileSpdp);
				} else {
					$('#modalDetail #detail_fileSpdp').hide();
				}

				$('#modalDetail #detail_tanggalBerkas').html(tanggalBerkas);
				$('#modalDetail #detail_nomorBerkas').html(nomorBerkas);
				if (fileBerkas != "") {
					$('#modalDetail #detail_fileBerkas').attr("href", fileBerkas);
				} else {
					$('#modalDetail #detail_fileBerkas').hide();
				}

				$('#modalDetail #detail_tanggalP16').html(tanggalP16);
				$('#modalDetail #detail_nomorP16').html(nomorP16);
				if (fileP16 != "") {
					$('#modalDetail #detail_fileP16').attr("href", fileP16);
				} else {
					$('#modalDetail #detail_fileP16').hide();
				}

				$('#modalDetail #detail_tanggalP17').html(tanggalP17);
				$('#modalDetail #detail_nomorP17').html(nomorP17);
				if (fileP17 != "") {
					$('#modalDetail #detail_fileP17').attr("href", fileP17);
				} else {
					$('#modalDetail #detail_fileP17').hide();
				}

				$('#modalDetail #detail_tanggalSopForm').html(tanggalSopForm);
				$('#modalDetail #detail_nomorSopForm').html(nomorSopForm);
				if (fileSopForm != "") {
					$('#modalDetail #detail_fileSopForm').attr("href", fileSopForm);
				} else {
					$('#modalDetail #detail_fileSopForm').hide();
				}

				$('#modalDetail #detail_tanggalSuratPengembalianSpdp').html(tanggalSuratPengembalianSpdp);
				$('#modalDetail #detail_nomorSuratPengembalianSpdp').html(nomorSuratPengembalianSpdp);
				if (fileSuratPengembalianSpdp != "") {
					$('#modalDetail #detail_fileSuratPengembalianSpdp').attr("href", fileSuratPengembalianSpdp);
				} else {
					$('#modalDetail #detail_fileSuratPengembalianSpdp').hide();
				}

				$('#modalDetail #detail_instansiPenyidik').html(instansiPenyidik);
				$('#modalDetail #detail_jaksaTerkait').html(jaksaTerkait);
				$('#modalDetail #detail_pidanaAnak').html(pidanaAnak);
				$('#modalDetail #detail_statusBerkas').html(statusBerkas);
				$('#modalDetail #detail_status').html(status);
				$('#modalDetail #detail_notifikasiSend').html(notifikasiSend);

				$('#modalDetail #detail_createDatetime').html(createDatetime);
				$('#modalDetail #detail_updateDatetime').html(updateDatetime);
				$('#modalDetail #detail_userCreate').html(userCreate);
				$('#modalDetail #detail_userUpdate').html(userUpdate);
				$('#modalDetail #detail_statusNotifikasi').html(statusNotifikasi);
				$('#modalDetail #detail_statusPerkara').html(statusPerkara);

				var classIntervalHari = "";
				if (intervalHari <= 5) {
					classIntervalHari = "badge btn-success";
				} else if ((intervalHari > 5) && (intervalHari <= 14)) {
					classIntervalHari = "badge btn-warning";
				} else if ((intervalHari > 14) && (intervalHari <= 21)) {
					classIntervalHari = "badge btn-danger";
				} else if ((intervalHari > 21)) {
					classIntervalHari = "badge btn-dark";
				}

				$('#modalDetail #detail_intervalHari').html(`<span class="` + classIntervalHari + `">` +
					intervalHari + ` hari berkas diterima sejak tanggal penerimaan` +
					`</span>`
				);
			});

			$("#modalInput").appendTo('body');
			$(document).on('click', '.btnShowModal', function() {
				var title = $(this).data('title');
				var action = $(this).data('action');

				$('#modalInput #judulForm').text(title);
				$('#modalInput #action').val(action);

				if (action == "tambah") {
					$("form").trigger("reset");
					$('.js-select-2').val('').trigger('change');

					$(".text-file-update").html(`(*Jika ada)`);
				} else if (action == "ubah") {
					$("form").trigger("reset");

					$(".text-file-update").html(`(*Pilih jika ingin menambah atau mengubah file !)`);

					var idBerkasPerkara = $(this).data('idBerkasPerkara');
					var tanggalPenerimaan = $(this).data('tanggalPenerimaan');
					var idInstansiPenyidik = $(this).data('idInstansiPenyidik');
					var tanggalSpdp = $(this).data('tanggalSpdp');
					var nomorSpdp = $(this).data('nomorSpdp');
					var fileSpdp = $(this).data('fileSpdp');
					var tanggalBerkas = $(this).data('tanggalBerkas');
					var nomorBerkas = $(this).data('nomorBerkas');
					var fileBerkas = $(this).data('fileBerkas');
					var tanggalP16 = $(this).data('tanggalP16');
					var nomorP16 = $(this).data('nomorP16');
					var fileP16 = $(this).data('fileP16');
					var jaksaTerkait = $(this).data('jaksaTerkait');
					var statusBerkas = $(this).data('statusBerkas');
					var pidanaAnak = $(this).data('pidanaAnak');

					$('#modalInput #id_berkas_perkara').val(idBerkasPerkara);
					$('#modalInput #tanggal_penerimaan').val(tanggalPenerimaan);
					$('#modalInput #id_instansi_penyidik').val(idInstansiPenyidik).trigger('change');
					$('#modalInput #tanggal_spdp').val(tanggalSpdp);
					$('#modalInput #nomor_spdp').val(nomorSpdp);
					$('#modalInput #tanggal_berkas').val(tanggalBerkas);
					$('#modalInput #nomor_berkas').val(nomorBerkas);
					$('#modalInput #tanggal_p16').val(tanggalP16);
					$('#modalInput #nomor_p16').val(nomorP16);
					$('#modalInput #status_berkas').val(statusBerkas).trigger('change');
					$('#modalInput #pidana_anak').val(pidanaAnak).trigger('change');

					var arrayJaksaTerkait;
					if (arrayJaksaTerkait = jaksaTerkait.toString().split(',')) {
						$.each(arrayJaksaTerkait, function(i, e) {
							$("#modalInput #jaksa_terkait option[value='" + e + "']").prop("selected", "true").trigger('change');
						});
					} else {
						$("#modalInput #jaksa_terkait option[value='" + jaksaTerkait + "']").prop("selected", "true").trigger('change');
					}
				}
			});

			$("#formInput").submit(function(e) {
				e.preventDefault();

				let formData = new FormData();
				var action = $('#action').val();
				var id_user = $('#id_user').val();
				formData.append('id_user', id_user);

				if (action == "tambah") {
					var urlPost = base_url + "/berkas-perkara/add";

					var tanggal_penerimaan = $('#tanggal_penerimaan').val();
					var nomor_spdp = $('#nomor_spdp').val();
					var tanggal_spdp = $('#tanggal_spdp').val();
					var file_spdp = $('#file_spdp').prop('files')[0];
					var nomor_berkas = $('#nomor_berkas').val();
					var tanggal_berkas = $('#tanggal_berkas').val();
					var file_berkas = $('#file_berkas').prop('files')[0];
					var nomor_p16 = $('#nomor_p16').val();
					var tanggal_p16 = $('#tanggal_p16').val();
					var file_p16 = $('#file_p16').prop('files')[0];
					var status_berkas = $('#status_berkas').val();
					var id_instansi_penyidik = $('#id_instansi_penyidik').val();
					var jaksa_terkait = $('#jaksa_terkait').val();
					var pidana_anak = $('#pidana_anak').val();

					formData.append('pidana_anak', pidana_anak);
					formData.append('tanggal_penerimaan', tanggal_penerimaan);
					formData.append('nomor_spdp', nomor_spdp);
					formData.append('tanggal_spdp', tanggal_spdp);
					formData.append('file_spdp', file_spdp);
					formData.append('nomor_berkas', nomor_berkas);
					formData.append('tanggal_berkas', tanggal_berkas);
					formData.append('file_berkas', file_berkas);
					formData.append('nomor_p16', nomor_p16);
					formData.append('tanggal_p16', tanggal_p16);
					formData.append('file_p16', file_p16);
					formData.append('status_berkas', status_berkas);
					formData.append('id_instansi_penyidik', id_instansi_penyidik);
					formData.append('jaksa_terkait', jaksa_terkait);
					formData.append('pidana_anak', pidana_anak);

				} else if (action == "ubah") {
					var urlPost = base_url + "/berkas-perkara/edit";

					var id_berkas_perkara = $('#id_berkas_perkara').val();
					var tanggal_penerimaan = $('#tanggal_penerimaan').val();
					var nomor_spdp = $('#nomor_spdp').val();
					var tanggal_spdp = $('#tanggal_spdp').val();
					var file_spdp = $('#file_spdp').prop('files')[0];
					var nomor_berkas = $('#nomor_berkas').val();
					var tanggal_berkas = $('#tanggal_berkas').val();
					var file_berkas = $('#file_berkas').prop('files')[0];
					var nomor_p16 = $('#nomor_p16').val();
					var tanggal_p16 = $('#tanggal_p16').val();
					var file_p16 = $('#file_p16').prop('files')[0];
					var status_berkas = $('#status_berkas').val();
					var id_instansi_penyidik = $('#id_instansi_penyidik').val();
					var jaksa_terkait = $('#jaksa_terkait').val();
					var pidana_anak = $('#pidana_anak').val();

					formData.append('id_berkas_perkara', id_berkas_perkara);
					formData.append('pidana_anak', pidana_anak);
					formData.append('tanggal_penerimaan', tanggal_penerimaan);
					formData.append('nomor_spdp', nomor_spdp);
					formData.append('tanggal_spdp', tanggal_spdp);
					formData.append('file_spdp', file_spdp);
					formData.append('nomor_berkas', nomor_berkas);
					formData.append('tanggal_berkas', tanggal_berkas);
					formData.append('file_berkas', file_berkas);
					formData.append('nomor_p16', nomor_p16);
					formData.append('tanggal_p16', tanggal_p16);
					formData.append('file_p16', file_p16);
					formData.append('status_berkas', status_berkas);
					formData.append('id_instansi_penyidik', id_instansi_penyidik);
					formData.append('jaksa_terkait', jaksa_terkait);
					formData.append('pidana_anak', pidana_anak);
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

	$('.dropify').dropify({
		messages: {
			'default': '',
			'replace': '',
			'remove': 'Hapus',
			'error': 'Terjadi kesalahan !'
		},
		tpl: {
			wrap: '<div class="dropify-wrapper"></div>',
			loader: '<div class="dropify-loader"></div>',
			message: '<div class="dropify-message"><span class="file-icon" /> <p>{{ default }}</p></div>',
			preview: '<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message">{{ replace }}</p></div></div></div>',
			filename: '<p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p>',
			clearButton: '<button type="button" class="dropify-clear">{{ remove }}</button>',
			errorLine: '<p class="dropify-error">{{ error }}</p>',
			errorsContainer: '<div class="dropify-errors-container"><ul></ul></div>'
		},
		error: {
			'fileSize': 'Ukuran file terlalu besar !',
			'minWidth': 'The image width is too small ({{ value }}}px min).',
			'maxWidth': 'The image width is too big ({{ value }}}px max).',
			'minHeight': 'The image height is too small ({{ value }}}px min).',
			'maxHeight': 'The image height is too big ({{ value }}px max).',
			'imageFormat': 'The image format is not allowed ({{ value }} only).'
		}
	});
</script>