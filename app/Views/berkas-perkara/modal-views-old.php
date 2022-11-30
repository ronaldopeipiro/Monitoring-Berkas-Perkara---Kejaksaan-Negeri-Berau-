<div class="modal fade" id="modalInput" tabindex="1" role="dialog" aria-labelledby="judulForm" aria-hidden="true">
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
									Tanggal Penerimaan Berkas Perkara Tahap 1
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

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="tersangka" class="col-sm-12 col-form-label">
									Nama Tersangka
								</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="tersangka" name="tersangka" placeholder="Masukkan nama tersangka ..." value="">
								</div>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
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

<div class="modal fade" id="modalInputTambahanBerkas" tabindex="20" role="dialog" aria-labelledby="judulFormTambahanBerkas" aria-hidden="true" data-backdrop="static">
	<div class="modal-sm modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="judulFormTambahanBerkas" style="color: #000;"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form id="formInputTambahanBerkas" enctype="multipart/form-data">
				<div class="modal-body">

					<input type="hidden" class="form-control" id="tambahanBerkasAction" name="tambahanBerkasAction" value="">
					<input type="hidden" class="form-control" id="tambahanBerkasMode" name="tambahanBerkasMode" value="">
					<input type="hidden" class="form-control" id="tambahanBerkasdata.id_berkas_perkara" name="tambahanBerkasdata.id_berkas_perkara" value="">
					<input type="hidden" class="form-control" id="tambahanBerkasIdUser" name="tambahanBerkasIdUser" value="<?= $user_id; ?>">

					<div class="form-group row mb-3">
						<label for="nomorTambahanBerkas" class="col-sm-12 col-form-label">
						</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="nomorTambahanBerkas" name="nomorTambahanBerkas" placeholder="..." value="" autofocus>
						</div>
					</div>

					<div class="form-group row mb-3">
						<label for="tanggalTambahanBerkas" class="col-sm-12 col-form-label">
						</label>
						<div class="col-sm-12">
							<input type="date" class="form-control" id="tanggalTambahanBerkas" name="tanggalTambahanBerkas" placeholder="dd/mm/yyyy" value="">
						</div>
					</div>

					<div class="form-group row mb-3">
						<label for="fileTambahanBerkas" class="col-sm-12 col-form-label">
						</label>
						<div class="col-sm-12">
							<input type="file" data-default-file="" name="fileTambahanBerkas" id="fileTambahanBerkas" class="dropify" data-height="72" data-show-remove="true" data-show-loader="true" data-show-errors="true" data-errors-position="outside" style="font-size: 12px;" />
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
				<div id="loadData"></div>
			</div>

		</div>
	</div>
</div>

<script>
	// send_notif('3', 'jaksa', 'Anda memiliki 1 berkas perkara yang baru masuk !');

	$(document).ready(function() {
		$(function() {
			$("#modalDetail").appendTo('body');
			$(document).on('click', '.btnShowModalDetail', function() {

				var title = $(this).data('title');
				var action = $(this).data('action');
				var id_berkas_perkara = $(this).data('id');

				$('#modalDetail #judulFormDetail').html(title);

				$('#loadData').html(`<h5 style="text-align:center;">Mengambil Data . . .</h5>`);

				let requestDetail = $.ajax({
					url: base_url + '/berkas-perkara/get-detail',
					type: "POST",
					dataType: "JSON",
					data: {
						id_berkas_perkara: id_berkas_perkara,
					},
				});

				requestDetail.done(function(msg) {
					const statusData = msg.status;

					if (statusData == 1) {
						const listDataDetail = msg.data;
						const banyakDataDetail = listDataDetail.length;

						let isiDataDetail = ``;
						if (banyakDataDetail == 0) {
							isiDataDetail = `<h5 style="text-align:center;">Tidak ada data . . .</h5>`;
						} else {
							for (let i = 0; i < banyakDataDetail; i++) {
								const no = i + 1;
								const dataDetail = listDataDetail[i];

								var textInterval = "";
								var classIntervalPenerimaan = "";
								if (dataDetail.interval_tanggal_penerimaan <= 5) {
									classIntervalPenerimaan = "badge btn-success";
								} else if ((dataDetail.interval_tanggal_penerimaan > 5) && (dataDetail.interval_tanggal_penerimaan <= 14)) {
									classIntervalPenerimaan = "badge btn-warning";
								} else if ((dataDetail.interval_tanggal_penerimaan > 14) && (dataDetail.interval_tanggal_penerimaan <= 21)) {
									classIntervalPenerimaan = "badge btn-danger";
								} else if ((dataDetail.interval_tanggal_penerimaan > 21)) {
									classIntervalPenerimaan = "badge btn-dark";
								}

								textInterval += `<span class="${classIntervalPenerimaan}">` +
									dataDetail.interval_tanggal_penerimaan + ` hari sejak tanggal penerimaan` +
									`</span>`;

								if (dataDetail.nomor_berkas != "" || dataDetail.tanggal_berkas != "") {
									var classIntervalBerkas = "";
									if (dataDetail.interval_tanggal_spdp >= 30) {
										classIntervalBerkas = "badge btn-danger";
									} else {
										classIntervalBerkas = "badge btn-success";
									}
									textInterval += `<span class="${classIntervalBerkas}">` +
										dataDetail.interval_tanggal_berkas + ` hari sejak tanggal berkas` +
										`</span>`;
								} else if (dataDetail.nomor_spdp != "" || dataDetail.tanggal_spdp != "") {
									var classIntervalSpdp = "";
									if (dataDetail.interval_tanggal_spdp >= 30) {
										classIntervalSpdp = "badge btn-danger";
									} else {
										classIntervalSpdp = "badge btn-success";
									}
									textInterval += `<span class="${classIntervalSpdp}">` +
										dataDetail.interval_tanggal_spdp + ` hari sejak tanggal SPDP` +
										`</span>`;
								} else if (dataDetail.nomor_p17 != "" || dataDetail.tanggal_p17 != "") {
									var classIntervalP17 = "";
									if (dataDetail.interval_tanggal_p17 >= 30) {
										classIntervalP17 = "badge btn-danger";
									} else {
										classIntervalP17 = "badge btn-success";
									}
									textInterval += `<span class="${classIntervalP17}">` +
										dataDetail.interval_tanggal_p17 + ` hari sejak tanggal P-17` +
										`</span>`;
								} else if (dataDetail.nomor_sop_form_02 != "" || dataDetail.tanggal_sop_form_02 != "") {
									var classIntervalSopForm = "";
									if (dataDetail.interval_tanggal_sop_form_02 >= 30) {
										classIntervalSopForm = "badge btn-danger";
									} else {
										classIntervalSopForm = "badge btn-success";
									}
									textInterval += `<span class="${classIntervalSopForm}">` +
										dataDetail.interval_tanggal_sop_form_02 + ` hari sejak tanggal SOP-Form 02` +
										`</span>`;
								} else if (dataDetail.nomor_surat_pengembalian_spdp != "" || dataDetail.tanggal_surat_pengembalian_spdp != "") {
									var classIntervalSuratPengembalianSpdp = "";
									if (dataDetail.interval_tanggal_surat_pengembalian_spdp >= 30) {
										classIntervalSuratPengembalianSpdp = "badge btn-danger";
									} else {
										classIntervalSuratPengembalianSpdp = "badge btn-success";
									}
									textInterval += `<span class="${classIntervalSuratPengembalianSpdp}">` +
										dataDetail.interval_tanggal_surat_pengembalian_spdp + ` hari sejak tanggal Surat Pengembalian SPDP` +
										`</span>`;
								}

								// Tampilkan Button Tambah Berkas Jika telah melewati Batas Waktu
								if (dataDetail.interval_tanggal_spdp >= 30 && ((dataDetail.nomor_p17 == "") || (dataDetail.tanggal_p17 == "")) && ((dataDetail.nomor_berkas == "") || (dataDetail.tanggal_berkas == ""))) {
									textInterval += `
										<br>
										berkas ini telah lebih dari 30 hari sejak tanggal SPDP, silahkan
										<a href="#" class="mt-2 badge btn btn-primary text-white btnShowModalTambahanBerkas" data-toggle="modal" data-target="#modalInputTambahanBerkas" data-title="Tambah / Upload Berkas P-17" data-action="tambah" data-mode="P-17" data-id-berkas="${dataDetail.id_berkas_perkara}" title="Tambah / Upload Berkas P-17">
											+ Tambah / Upload Berkas P-17
										</a>
									`;
								} else if (dataDetail.interval_tanggal_p17 >= 30 && ((dataDetail.nomor_sop_form_02 == "") || (dataDetail.tanggal_sop_form_02 == "")) && ((dataDetail.nomor_berkas == "") || (dataDetail.tanggal_berkas == ""))) {
									textInterval += `
										<br>
										berkas ini telah lebih dari 30 hari sejak tanggal P-17, silahkan
										<a href="#" class="mt-2 badge btn btn-primary text-white btnShowModalTambahanBerkas" data-toggle="modal" data-target="#modalInputTambahanBerkas" data-title="Tambah / Upload Berkas SOP-Form 02" data-action="tambah" data-mode="SOP-Form 02" data-id-berkas="${dataDetail.id_berkas_perkara}" title="Tambah / Upload Berkas SOP-Form 02">
											+ Tambah / Upload Berkas SOP-Form 02
										</a>
									`;
								} else if (dataDetail.interval_tanggal_sop_form_02 >= 30 && ((dataDetail.nomor_surat_pengembalian_spdp == "") || (dataDetail.tanggal_surat_pengembalian_spdp == "")) && ((dataDetail.nomor_berkas == "") || (dataDetail.tanggal_berkas == ""))) {
									textInterval += `
										<br>
										berkas ini telah lebih dari 30 hari sejak tanggal SOP-Form 02, silahkan
										<a href="#" class="mt-2 badge btn btn-primary text-white btnShowModalTambahanBerkas" data-toggle="modal" data-target="#modalInputTambahanBerkas" data-title="Tambah / Upload Berkas Surat Pengembalian SPDP" data-action="tambah" data-mode="Surat Pengembalian SPDP" data-id-berkas="${dataDetail.id_berkas_perkara}" title="Tambah / Upload Berkas Surat Pengembalian SPDP">
											+ Tambah / Upload Berkas Surat Pengembalian SPDP
										</a>
									`;

									console.log(textInterval);

									isiDataDetail += `
									<div class="row">

										<div class="col-lg-12 mb-3">
											<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
												<tr>
													<td>Tanggal Penerimaan</td>
													<td>:</td>
													<td>
														${dataDetail.tanggal_penerimaan_format}
													</td>
												</tr>
												<tr>
													<td>Interval Hari</td>
													<td>:</td>
													<td>
														${textInterval}
													</td>
												</tr>

												<tr>
													<td>Status Berkas</td>
													<td>:</td>
													<td>
														${dataDetail.status_berkas}
													</td>
												</tr>
												<tr>
													<td>Pidana Anak</td>
													<td>:</td>
													<td>
														${dataDetail.pidana_anak}
													</td>
												</tr>
												<tr>
													<td>Instansi Penyidik</td>
													<td>:</td>
													<td>
														${dataDetail.nama_instansi_penyidik}
													</td>
												</tr>
												<tr>
													<td>Tersangka</td>
													<td>:</td>
													<td>
														${dataDetail.tersangka}
													</td>
												</tr>
												<tr>
													<td>Jaksa Terkait</td>
													<td>:</td>
													<td>
														${dataDetail.jaksa_terkait_text}
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
														${dataDetail.status_notifikasi}
													</td>
												</tr>
												<tr>
													<td>Status Perkara</td>
													<td>:</td>
													<td>
														${dataDetail.status_berkas}
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
																${dataDetail.tanggal_spdp_format}
															</td>
														</tr>
														<tr>
															<td>Nomor SPDP</td>
															<td>:</td>
															<td>
																${dataDetail.nomor_spdp}
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
																<spa"detail_dataDetail.tanggal_berkas"></spa>
															</td>
														</tr>
														<tr>
															<td>Nomor Berkas Tahap 1</td>
															<td>:</td>
															<td>
																<spa"detail_dataDetail.nomor_berkas"></spa>
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
																<spa"detail_dataDetail.tanggal_sop_form_02"></spa>
															</td>
														</tr>
														<tr>
															<td>Nomor SOP Form 02</td>
															<td>:</td>
															<td>
																<spa"detail_dataDetail.nomor_sop_form_02"></spa>
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
								`;

								}

							}
							$('#loadData').html(isiDataDetail);
						}

					} else {
						$('#loadData').html(`<h3 style="text-align:center">${msg.msg}</h3>`);
					}
				});

				requestDetail.fail(function(jqXHR, textStatus) {
					$('#loadData').html(`
						<h5 style="text-align: center; color: red;">
							Gagal Mengambil Data, Terjadi Kesalahan Teknis
						</h5>
					`);
				});

			});

			// $("#modalInput").appendTo('body');
			// $(document).on('click', '.btnShowModal', function() {
			// 	var title = $(this).data('title');
			// 	var action = $(this).data('action');

			// 	$('#modalInput #judulForm').text(title);
			// 	$('#modalInput #action').val(action);

			// 	if (action == "tambah") {
			// 		$("form").trigger("reset");
			// 		$('.js-select-2').val('').trigger('change');

			// 		$(".text-file-update").html(`( * Jika ada)
			// 		`);
			// 	} else if (action == "ubah") {
			// 		$("form").trigger("reset");

			// 		$(".text-file-update").html(`( * Pilih jika ingin menambah atau mengubah file!)
			// 		`);

			// 		var id_berkas_perkara = $(this).data('id');

			// 		$('#modalInput #id_berkas_perkara').val(id_berkas_perkara);
			// 		$('#modalInput #tanggal_penerimaan').val(tanggalPenerimaan);
			// 		$('#modalInput #id_instansi_penyidik').val(idInstansiPenyidik).trigger('change');
			// 		$('#modalInput #tanggal_spdp').val(dataDetail.tanggal_spdp);
			// 		$('#modalInput #nomor_spdp').val(dataDetail.nomor_spdp);
			// 		$('#modalInput #tanggal_berkas').val(data.tanggal_berkas);
			// 		$('#modalInput #nomor_berkas').val(data.nomor_berkas);
			// 		$('#modalInput #tanggal_p16').val(tanggalP16);
			// 		$('#modalInput #nomor_p16').val(nomorP16);
			// 		$('#modalInput #status_berkas').val(statusBerkas).trigger('change');
			// 		$('#modalInput #pidana_anak').val(pidanaAnak).trigger('change');
			// 		$('#modalInput #tersangka').val(tersangka);

			// 		var arrayJaksaTerkait;
			// 		if (arrayJaksaTerkait = jaksaTerkait.toString().split(',')) {
			// 			$.each(arrayJaksaTerkait, function(i, e) {
			// 				$("#modalInput #jaksa_terkait option[value='" + e + "']").prop("selected", "true").trigger('change');
			// 			});
			// 		} else {
			// 			$("#modalInput #jaksa_terkait option[value='" + jaksaTerkait + "']").prop("selected", "true").trigger('change');
			// 		}
			// 	}
			// });

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
					var tersangka = $('#tersangka').val();
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
					formData.append('tersangka', tersangka);
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
					var tersangka = $('#tersangka').val();
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
					formData.append('tersangka', tersangka);
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

							if (action == "tambah") {
								send_notif('3', 'jaksa', 'Anda memiliki 1 berkas perkara yang baru masuk !');
							}

							$('#modalInput').hide();
							getDataTable();

						} else if (data.success == "0") {
							toastr.error(data.pesan);
						}
					},
					complete: function(data) {
						$("#loader").hide();
					}
				});

			});

			// $("#modalInputTambahanBerkas").css("z-index", "9999999");
			$("#modalInputTambahanBerkas").appendTo('body');
			$(document).on('click', '.btnShowModalTambahanBerkas', function() {

				var xtitle = $(this).data('title');
				var xaction = $(this).data('action');
				var xmode = $(this).data('mode');
				var xidBerkas = $(this).data('idBerkas');

				$('#modalInputTambahanBerkas #judulFormTambahanBerkas').text(xtitle);
				$('#formInputTambahanBerkas input[name=tambahanBerkasAction]').attr('value', xaction);
				$('#formInputTambahanBerkas input[name=tambahanBerkasMode]').attr('value', xmode);
				$('#formInputTambahanBerkas input[name=tambahanBerkasdata.id_berkas_perkara]').attr('value', xidBerkas);

				if (xmode == "P-17") {
					$("#formInputTambahanBerkas label[for=nomorTambahanBerkas]").html(`Nomor P-17`);
					$("#formInputTambahanBerkas label[for=tanggalTambahanBerkas]").html(`Tanggal P-17`);
					$("#formInputTambahanBerkas label[for=fileTambahanBerkas]").html(`File Berkas P-17 <br> <small class="text-info">(* Jika ada)</small>`);
				} else if (xmode == "SOP Form 02") {
					$("#formInputTambahanBerkas label[for=nomorTambahanBerkas]").html(`Nomor SOP Form 02`);
					$("#formInputTambahanBerkas label[for=tanggalTambahanBerkas]").html(`Tanggal SOP Form 02`);
					$("#formInputTambahanBerkas label[for=fileTambahanBerkas]").html(`File Berkas SOP Form 02 <br> <small class="text-info">(*Jika ada)</small>`);
				} else if (xmode == "Surat Pengembalian SPDP") {
					$("#formInputTambahanBerkas label[for=nomorTambahanBerkas]").html(`Nomor Surat Pengembalian SPDP`);
					$("#formInputTambahanBerkas label[for=tanggalTambahanBerkas]").html(`Tanggal Surat Pengembalian SPDP`);
					$("#formInputTambahanBerkas label[for=fileTambahanBerkas]").html(`File Berkas Surat Pengembalian SPDP <br> <small class="text-info">(*Jika ada)</small>`);
				}

				$("form").trigger("reset");
				$('.js-select-2').val('').trigger('change');

				if (action == "ubah") {
					if (xmode == "P-17") {
						$("#formInputTambahanBerkas label[for=fileTambahanBerkas]").html(`File Berkas P-17 <br> <small class="text-info">(*Pilih file untuk menambah atau mengubah)</small>`);
					} else if (xmode == "SOP Form 02") {
						$("#formInputTambahanBerkas label[for=fileTambahanBerkas]").html(`File Berkas SOP Form 02 <br> <small class="text-info">(*Pilih file untuk menambah atau mengubah)</small>`);
					} else if (xmode == "Surat Pengembalian SPDP") {
						$("#formInputTambahanBerkas label[for=fileTambahanBerkas]").html(`File Berkas Surat Pengembalian SPDP <br> <small class="text-info">(*Pilih file untuk menambah atau mengubah)</small>`);
					}

					var nomorTambahanBerkas = $(this).data('nomorTambahanBerkas');
					var tanggalTambahanBerkas = $(this).data('tanggalTambahanBerkas');

					$('#formInputTambahanBerkas #nomorTambahanBerkas').val(nomorTambahanBerkas);
					$('#formInputTambahanBerkas #tanggalTambahanBerkas').val(tanggalTambahanBerkas);
				}
			});


			$("#formInputTambahanBerkas").submit(function(e) {
				e.preventDefault();

				let formData = new FormData();
				var action = $('#tambahanBerkasAction').val();
				var mode = $('#tambahanBerkasMode').val();
				var id_user = $('#tambahanBerkasIdUser').val();
				var id_berkas_perkara = $('#tambahanBerkasdata.id_berkas_perkara').val();

				var nomorTambahanBerkas = $('#nomorTambahanBerkas').val();
				var tanggalTambahanBerkas = $('#tanggalTambahanBerkas').val();
				var fileTambahanBerkas = $('#fileTambahanBerkas').prop('files')[0];

				formData.append('id_user', id_user);
				formData.append('id_berkas_perkara', id_berkas_perkara);
				formData.append('mode', mode);
				formData.append('nomorTambahanBerkas', nomorTambahanBerkas);
				formData.append('tanggalTambahanBerkas', tanggalTambahanBerkas);
				formData.append('fileTambahanBerkas', fileTambahanBerkas);

				if (action == "tambah") {
					var urlPost = base_url + "/berkas-perkara/add-tambahan-berkas";
				} else if (action == "ubah") {
					var urlPost = base_url + "/berkas-perkara/edit-tambahan-berkas";
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

							$('#modalInputTambahanBerkas').hide();
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

	function reset_tambahan_berkas(id_berkas_perkara, mode) {
		event.preventDefault(); // prevent form submit

		var urlPost = base_url + "/berkas-perkara/delete-tambahan-berkas";

		Swal.fire({
			title: "Hapus Data Berkas ?",
			text: "Apakah anda yakin melakukan reset data berkas " + mode + " ini ?",
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
						id_berkas_perkara: id_berkas_perkara,
						mode: mode
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