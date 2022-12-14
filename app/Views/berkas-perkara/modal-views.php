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
									Tgl. Penerimaan Berkas
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
												<option value="SP-3">SP-3</option>
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
											No. SPDP
										</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" id="nomor_spdp" name="nomor_spdp" placeholder="Masukkan Nomor SPDP ..." value="">
										</div>
									</div>
								</div>

								<div class="col-lg-4 mb-3 mb-lg-0">
									<div class="row">
										<label for="tanggal_spdp" class="col-sm-12 col-form-label">
											Tgl. SPDP
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
											No. Berkas Tahap 1
										</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" id="nomor_berkas" name="nomor_berkas" placeholder="Masukkan Nomor Berkas ..." value="">
										</div>
									</div>
								</div>

								<div class="col-lg-4 mb-3 mb-lg-0">
									<div class="row">
										<label for="tanggal_berkas" class="col-sm-12 col-form-label">
											Tgl. Berkas Tahap 1
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
										<label for="nomor_pengantar_berkas" class="col-sm-12 col-form-label">
											No. Pengantar Berkas
										</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" id="nomor_pengantar_berkas" name="nomor_pengantar_berkas" placeholder="Masukkan Nomor Pengantar Berkas ..." value="">
										</div>
									</div>
								</div>

								<div class="col-lg-4 mb-3 mb-lg-0">
									<div class="row">
										<label for="tanggal_pengantar_berkas" class="col-sm-12 col-form-label">
											Tgl. Pengantar Berkas
										</label>
										<div class="col-sm-12">
											<input type="date" class="form-control" id="tanggal_pengantar_berkas" name="tanggal_pengantar_berkas" placeholder="0" value="">
										</div>
									</div>
								</div>

								<div class="col-lg-12 mb-3 mb-lg-0 mt-3">
									<div class="form-group row mb-2">
										<label for="file_pengantar_berkas" class="col-sm-12 col-form-label">
											File Pengantar Berkas
											<small class="text-info text-file-update">
												(*Jika Ada)
											</small>
										</label>
										<div class="col-sm-12">
											<input type="file" data-default-file="" name="file_pengantar_berkas" id="file_pengantar_berkas" class="dropify" data-height="72" data-show-remove="true" data-show-loader="true" data-show-errors="true" data-errors-position="outside" style="font-size: 12px;" />
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
										<label for="nomor_p16" class="col-sm-12 col-form-label">
											No. P-16
										</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" id="nomor_p16" name="nomor_p16" placeholder="Masukkan Nomor P-16 ..." value="">
										</div>
									</div>
								</div>

								<div class="col-lg-4 mb-3 mb-lg-0">
									<div class="row">
										<label for="tanggal_p16" class="col-sm-12 col-form-label">
											Tgl. P-16
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

						<div class="col-lg-6">
							<div class="form-group">
								<label for="tersangka" class="col-sm-12 col-form-label">
									Nama Tersangka
								</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="tersangka" name="tersangka" placeholder="Masukkan nama tersangka ..." value="">
								</div>
							</div>

							<div class="form-group mt-4">
								<label for="jaksa_terkait" class="col-sm-12 col-form-label">
									Jaksa Terkait
									<small class="text-danger">(*Wajib diisi !)</small>
								</label>
								<div class="col-sm-12">
									<select name="jaksa_terkait" id="jaksa_terkait" class="form-control js-select-2">
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
					<input type="hidden" class="form-control" id="tambahanBerkasIdBerkasPerkara" name="tambahanBerkasIdBerkasPerkara" value="">
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

				<div class="row">

					<div class="col-lg-12 mb-3">
						<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
							<tr>
								<td>Tgl. Penerimaan</td>
								<td>:</td>
								<td>
									<span id="detail_tanggalPenerimaan"></span>
								</td>
							</tr>
							<tr>
								<td>Interval Hari</td>
								<td>:</td>
								<td>
									<span id="detail_interval"></span>
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
								<td>Tersangka</td>
								<td>:</td>
								<td>
									<span id="detail_tersangka"></span>
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

					<div class="col-lg-4">
						<div class="card">
							<div class="card-body p-1">
								<h5 class="font-weight-bold ms-1">
									SPDP
								</h5>
								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tgl.</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalSpdp"></span>
										</td>
									</tr>
									<tr>
										<td>No.</td>
										<td>:</td>
										<td>
											<span id="detail_nomorSpdp"></span>
										</td>
									</tr>
									<tr>
										<td>File</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileSpdp" target="_blank">
												Unduh / Lihat
											</a>
										</td>
									</tr>
								</table>

							</div>

						</div>
					</div>

					<div class="col-lg-4">
						<div class="card">
							<div class="card-body p-1">
								<h5 class="font-weight-bold ms-1">
									P-16
								</h5>
								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tgl.</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalP16"></span>
										</td>
									</tr>
									<tr>
										<td>No.</td>
										<td>:</td>
										<td>
											<span id="detail_nomorP16"></span>
										</td>
									</tr>
									<tr>
										<td>File</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileP16" target="_blank">
												Unduh / Lihat
											</a>
										</td>
									</tr>
								</table>

							</div>

						</div>
					</div>

					<div class="col-lg-4">
						<div class="card">
							<div class="card-body p-1">
								<h5 class="font-weight-bold ms-1">
									Berkas Tahap 1
								</h5>
								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tgl.</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalBerkas"></span>
										</td>
									</tr>
									<tr>
										<td>No.</td>
										<td>:</td>
										<td>
											<span id="detail_nomorBerkas"></span>
										</td>
									</tr>
									<tr>
										<td>File</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileBerkas" target="_blank">
												Unduh / Lihat
											</a>
										</td>
									</tr>
								</table>
							</div>

						</div>
					</div>

					<div class="col-lg-4">
						<div class="card">
							<div class="card-body p-1">
								<h5 class="font-weight-bold ms-1">
									Pengantar Berkas
								</h5>
								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tgl.</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalPengantarBerkas"></span>
										</td>
									</tr>
									<tr>
										<td>No.</td>
										<td>:</td>
										<td>
											<span id="detail_nomorPengantarBerkas"></span>
										</td>
									</tr>
									<tr>
										<td>File</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_filePengantarBerkas" target="_blank">
												Unduh / Lihat
											</a>
										</td>
									</tr>
								</table>

							</div>

						</div>
					</div>

					<div class="col-lg-4">
						<div class="card">
							<div class="card-body p-1">
								<h5 class="font-weight-bold ms-1">
									P-17
								</h5>
								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tgl.</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalP17"></span>
										</td>
									</tr>
									<tr>
										<td>No.</td>
										<td>:</td>
										<td>
											<span id="detail_nomorP17"></span>
										</td>
									</tr>
									<tr>
										<td>File</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileP17" target="_blank">
												Unduh / Lihat
											</a>
										</td>
									</tr>
								</table>

							</div>

						</div>
					</div>

					<div class="col-lg-4">
						<div class="card">
							<div class="card-body p-1">
								<h5 class="font-weight-bold ms-1">
									SOP Form 02
								</h5>
								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tgl.</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalSopForm"></span>
										</td>
									</tr>
									<tr>
										<td>No.</td>
										<td>:</td>
										<td>
											<span id="detail_nomorSopForm"></span>
										</td>
									</tr>
									<tr>
										<td>File</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileSopForm" target="_blank">
												Unduh / Lihat
											</a>
										</td>
									</tr>
								</table>
							</div>

						</div>
					</div>

					<div class="col-lg-4">
						<div class="card">
							<div class="card-body p-1">
								<h5 class="font-weight-bold ms-1">
									Surat Pengembalian SPDP
								</h5>
								<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
									<tr>
										<td>Tgl.</td>
										<td>:</td>
										<td>
											<span id="detail_tanggalSuratPengembalianSpdp"></span>
										</td>
									</tr>
									<tr>
										<td>No.</td>
										<td>:</td>
										<td>
											<span id="detail_nomorSuratPengembalianSpdp"></span>
										</td>
									</tr>
									<tr>
										<td>File</td>
										<td>:</td>
										<td>
											<a href="" class="badge btn btn-sm btn-info" id="detail_fileSuratPengembalianSpdp" target="_blank">
												Unduh / Lihat
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
	// send_notif('3', 'jaksa', 'Anda memiliki 1 berkas perkara yang baru masuk !');

	function pesanUpdateBerkas(action, noHpJaksa, namaJaksa, slug, tanggalPenerimaan, instansiPenyidik, tersangka, statusBerkas) {
		const d = new Date();
		let time = d.getHours();
		// let minutes = d.Minutes();

		var ucapanSalam = '';
		if (time >= 2 && time < 12) {
			ucapanSalam = 'Selamat Pagi ????';
		} else if (time >= 12 && time < 15) {
			ucapanSalam = 'Selamat Siang ????';
		} else if (time >= 15 && time < 18) {
			ucapanSalam = 'Selamat Sore ????';
		} else {
			ucapanSalam = 'Selamat Malam ????';
		}

		var isiPesan = ``;
		if (action == "tambah") {
			isiPesan = `????Anda memiliki 1 berkas perkara baru`;
		} else if (action == "ubah") {
			isiPesan = `????Data berkas anda berikut ini baru saja diperbaharui oleh operator`;
		} else if (action == "berkas-tahap-1-masuk") {
			isiPesan = `????*Berkas Tahap 1* telah diterima dan diinput oleh operator`;
		}

		var pesanNotif = `
*_INFORMASI MONITORING BERKAS PERKARA_*

${ucapanSalam} saudara/i *${namaJaksa}*,

${isiPesan}

*_Detail Berkas_*
-----------------------------
???? _Tgl. Penerimaan_ : ${tanggalPenerimaan} 
???? _Instansi Penyidik_ : ${instansiPenyidik} 
???? _Tersangka_ : ${tersangka} 
???? _Status Berkas_ : ${statusBerkas} 

Lihat lebih detail disini
https://kejariberau.id/berkas-perkara/detail/${slug}

Terima Kasih ????


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_

TTD
*_KEJAKSAAN NEGERI BERAU_*
`;

		// Ronald
		kirim_whatsapp('1fb92afe72a55161160bdd2c642055cf', noHpJaksa, pesanNotif, '');
	}

	$(document).ready(function() {
		$(function() {
			// $("#modalInput").css("z-index", "1500");

			$("#modalDetail").appendTo('body');

			$(document).on('click', '.btnShowModalDetail', function() {

				var title = $(this).data('title');
				var action = $(this).data('action');
				var idBerkasPerkara = $(this).data('idBerkas');
				var tanggalPenerimaan = $(this).data('tanggalPenerimaan');

				var tanggalBerkas = $(this).data('tanggalBerkas');
				var nomorBerkas = $(this).data('nomorBerkas');
				var fileBerkas = $(this).data('fileBerkas');

				var tanggalPengantarBerkas = $(this).data('tanggalPengantarBerkas');
				var nomorPengantarBerkas = $(this).data('nomorPengantarBerkas');
				var filePengantarBerkas = $(this).data('filePengantarBerkas');

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
				var tersangka = $(this).data('tersangka');
				var dataJaksaTerkait = $(this).data('jaksaTerkait');
				var jaksaTerkait = dataJaksaTerkait.replaceAll(`'`, `"`);
				var pidanaAnak = $(this).data('pidanaAnak');
				var statusBerkas = $(this).data('statusBerkas');
				var statusPerkara = $(this).data('statusPerkara');
				var notifikasiSend = $(this).data('notifikasiSend');
				var createDatetime = $(this).data('createDatetime');
				var updateDatetime = $(this).data('updateDatetime');
				var userCreate = $(this).data('userCreate');
				var userUpdate = $(this).data('userUpdate');
				var statusNotifikasi = $(this).data('statusNotifikasi');

				var intervalPenerimaan = $(this).data('intervalPenerimaan');
				var intervalBerkas = $(this).data('intervalBerkas');
				var intervalSpdp = $(this).data('intervalSpdp');
				var intervalP17 = $(this).data('intervalP17');
				var intervalSopForm = $(this).data('intervalSopForm');
				var intervalSuratPengembalianSpdp = $(this).data('intervalSuratPengembalianSpdp');

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

				$('#modalDetail #detail_tanggalPengantarBerkas').html(tanggalPengantarBerkas);
				$('#modalDetail #detail_nomorPengantarBerkas').html(nomorPengantarBerkas);
				if (filePengantarBerkas != "") {
					$('#modalDetail #detail_filePengantarBerkas').attr("href", filePengantarBerkas);
				} else {
					$('#modalDetail #detail_filePengantarBerkas').hide();
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
				$('#modalDetail #detail_tersangka').html(tersangka);
				$('#modalDetail #detail_jaksaTerkait').html(jaksaTerkait);
				$('#modalDetail #detail_pidanaAnak').html(pidanaAnak);
				$('#modalDetail #detail_statusBerkas').html(statusBerkas);
				$('#modalDetail #detail_notifikasiSend').html(notifikasiSend);

				$('#modalDetail #detail_createDatetime').html(createDatetime);
				$('#modalDetail #detail_updateDatetime').html(updateDatetime);
				$('#modalDetail #detail_userCreate').html(userCreate);
				$('#modalDetail #detail_userUpdate').html(userUpdate);
				$('#modalDetail #detail_statusNotifikasi').html(statusNotifikasi);
				$('#modalDetail #detail_statusPerkara').html(statusPerkara);


				var textInterval = "";
				var classIntervalPenerimaan = "";
				if (intervalPenerimaan <= 5) {
					classIntervalPenerimaan = "badge btn-success";
				} else if ((intervalPenerimaan > 5) && (intervalPenerimaan <= 14)) {
					classIntervalPenerimaan = "badge btn-warning";
				} else if ((intervalPenerimaan > 14) && (intervalPenerimaan <= 21)) {
					classIntervalPenerimaan = "badge btn-danger";
				} else if ((intervalPenerimaan > 21)) {
					classIntervalPenerimaan = "badge btn-dark";
				}

				textInterval += `
					<span class="${classIntervalPenerimaan}">` +
					intervalPenerimaan + ` hari sejak tanggal penerimaan` +
					`</span>`;

				if (nomorBerkas != "" || tanggalBerkas != "") {
					var classIntervalBerkas = "";
					if (intervalSpdp >= 30) {
						classIntervalBerkas = "badge btn-danger";
					} else {
						classIntervalBerkas = "badge btn-success";
					}
					textInterval += `
					<span class="${classIntervalBerkas}">` +
						intervalBerkas + ` hari sejak tanggal berkas` +
						`</span>`;
				} else if (nomorSpdp != "" || tanggalSpdp != "") {
					var classIntervalSpdp = "";
					if (intervalSpdp >= 30) {
						classIntervalSpdp = "badge btn-danger";
					} else {
						classIntervalSpdp = "badge btn-success";
					}
					textInterval += `
					<span class="${classIntervalSpdp}">` +
						intervalSpdp + ` hari sejak tanggal SPDP` +
						`</span>`;
				} else if (nomorP17 != "" || tanggalP17 != "") {
					var classIntervalP17 = "";
					if (intervalP17 >= 30) {
						classIntervalP17 = "badge btn-danger";
					} else {
						classIntervalP17 = "badge btn-success";
					}
					textInterval += `
					<span class="${classIntervalP17}">` +
						intervalP17 + ` hari sejak tanggal P-17` +
						`</span>`;
				} else if (nomorSopForm != "" || tanggalSopForm != "") {
					var classIntervalSopForm = "";
					if (intervalSopForm >= 30) {
						classIntervalSopForm = "badge btn-danger";
					} else {
						classIntervalSopForm = "badge btn-success";
					}
					textInterval += `
					<span class="${classIntervalSopForm}">` +
						intervalSopForm + ` hari sejak tanggal SOP-Form 02` +
						`</span>`;
				} else if (nomorSuratPengembalianSpdp != "" || tanggalSuratPengembalianSpdp != "") {
					var classIntervalSuratPengembalianSpdp = "";
					if (intervalSuratPengembalianSpdp >= 30) {
						classIntervalSuratPengembalianSpdp = "badge btn-danger";
					} else {
						classIntervalSuratPengembalianSpdp = "badge btn-success";
					}
					textInterval += `
					<span class="${classIntervalSuratPengembalianSpdp}">` +
						intervalSuratPengembalianSpdp + ` hari sejak tanggal Surat Pengembalian SPDP` +
						`</span>`;
				}

				// Tampilkan Button Tambah Berkas Jika telah melewati Batas Waktu
				if (intervalSpdp >= 30 && ((nomorP17 == "") || (tanggalP17 == "")) && ((nomorBerkas == "") || (tanggalBerkas == ""))) {
					textInterval += `
						<br>
						berkas ini telah lebih dari 30 hari sejak tanggal SPDP, silahkan
						<a href="#" class="mt-2 badge btn btn-primary text-white btnShowModalTambahanBerkas" data-toggle="modal" data-target="#modalInputTambahanBerkas" data-title="Tambah / Upload Berkas P-17" data-action="tambah" data-mode="P-17" data-id-berkas="${idBerkasPerkara}" title="Tambah / Upload Berkas P-17">
							+ Tambah / Upload Berkas P-17
						</a>
					`;
				} else if (intervalP17 >= 30 && ((nomorSopForm == "") || (tanggalSopForm == "")) && ((nomorBerkas == "") || (tanggalBerkas == ""))) {
					textInterval += `
						<br>
						berkas ini telah lebih dari 30 hari sejak tanggal P-17, silahkan
						<a href="#" class="mt-2 badge btn btn-primary text-white btnShowModalTambahanBerkas" data-toggle="modal" data-target="#modalInputTambahanBerkas" data-title="Tambah / Upload Berkas SOP-Form 02" data-action="tambah" data-mode="SOP-Form 02" data-id-berkas="${idBerkasPerkara}" title="Tambah / Upload Berkas SOP-Form 02">
							+ Tambah / Upload Berkas SOP-Form 02
						</a>
					`;
				} else if (intervalSopForm >= 30 && ((nomorSuratPengembalianSpdp == "") || (tanggalSuratPengembalianSpdp == "")) && ((nomorBerkas == "") || (tanggalBerkas == ""))) {
					textInterval += `
						<br>
						berkas ini telah lebih dari 30 hari sejak tanggal SOP-Form 02, silahkan
						<a href="#" class="mt-2 badge btn btn-primary text-white btnShowModalTambahanBerkas" data-toggle="modal" data-target="#modalInputTambahanBerkas" data-title="Tambah / Upload Berkas Surat Pengembalian SPDP" data-action="tambah" data-mode="Surat Pengembalian SPDP" data-id-berkas="${idBerkasPerkara}" title="Tambah / Upload Berkas Surat Pengembalian SPDP">
							+ Tambah / Upload Berkas Surat Pengembalian SPDP
						</a>
					`;
				}

				$('#modalDetail #detail_interval').html(textInterval);
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

					$(".text-file-update").html(`( * Jika ada)
					`);
				} else if (action == "ubah") {
					$("form").trigger("reset");

					$(".text-file-update").html(`( * Pilih jika ingin menambah atau mengubah file!)
					`);

					var idBerkasPerkara = $(this).data('idBerkasPerkara');
					var tanggalPenerimaan = $(this).data('tanggalPenerimaan');
					var idInstansiPenyidik = $(this).data('idInstansiPenyidik');

					var tanggalSpdp = $(this).data('tanggalSpdp');
					var nomorSpdp = $(this).data('nomorSpdp');
					var fileSpdp = $(this).data('fileSpdp');

					var tanggalBerkas = $(this).data('tanggalBerkas');
					var nomorBerkas = $(this).data('nomorBerkas');
					var fileBerkas = $(this).data('fileBerkas');

					var tanggalPengantarBerkas = $(this).data('tanggalPengantarBerkas');
					var nomorPengantarBerkas = $(this).data('nomorPengantarBerkas');
					var filePengantarBerkas = $(this).data('filePengantarBerkas');

					var tanggalP16 = $(this).data('tanggalP16');
					var nomorP16 = $(this).data('nomorP16');
					var fileP16 = $(this).data('fileP16');

					var tersangka = $(this).data('tersangka');
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

					$('#modalInput #tanggal_pengantar_berkas').val(tanggalPengantarBerkas);
					$('#modalInput #nomor_pengantar_berkas').val(nomorPengantarBerkas);

					$('#modalInput #tanggal_p16').val(tanggalP16);
					$('#modalInput #nomor_p16').val(nomorP16);

					$('#modalInput #status_berkas').val(statusBerkas).trigger('change');
					$('#modalInput #pidana_anak').val(pidanaAnak).trigger('change');
					$('#modalInput #tersangka').val(tersangka);

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

					var nomor_pengantar_berkas = $('#nomor_pengantar_berkas').val();
					var tanggal_pengantar_berkas = $('#tanggal_pengantar_berkas').val();
					var file_pengantar_berkas = $('#file_pengantar_berkas').prop('files')[0];

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

					formData.append('nomor_pengantar_berkas', nomor_pengantar_berkas);
					formData.append('tanggal_pengantar_berkas', tanggal_pengantar_berkas);
					formData.append('file_pengantar_berkas', file_pengantar_berkas);

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

					var nomor_pengantar_berkas = $('#nomor_pengantar_berkas').val();
					var tanggal_pengantar_berkas = $('#tanggal_pengantar_berkas').val();
					var file_pengantar_berkas = $('#file_pengantar_berkas').prop('files')[0];

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

					formData.append('nomor_pengantar_berkas', nomor_pengantar_berkas);
					formData.append('tanggal_pengantar_berkas', tanggal_pengantar_berkas);
					formData.append('file_pengantar_berkas', file_pengantar_berkas);

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
							$('#modalInput').hide();

							if (action == "tambah") {
								pesanUpdateBerkas('tambah', data.noHpJaksa, data.namaJaksa, data.slug, data.tanggalPenerimaan, data.instansiPenyidik, data.tersangka, data.statusBerkas);
								// send_notif('3', 'jaksa', 'Anda memiliki 1 berkas perkara yang baru masuk !');

								if (nomor_berkas != '' && tanggal_berkas != "") {
									pesanUpdateBerkas('berkas-tahap-1-masuk', data.noHpJaksa, data.namaJaksa, data.slug, data.tanggalPenerimaan, data.instansiPenyidik, data.tersangka, data.statusBerkas);
								}
							} else if (action == "ubah") {
								pesanUpdateBerkas('ubah', data.noHpJaksa, data.namaJaksa, data.slug, data.tanggalPenerimaan, data.instansiPenyidik, data.tersangka, data.statusBerkas);

								if (data.kirimNotifTahap1 == "Y") {
									pesanUpdateBerkas('berkas-tahap-1-masuk', data.noHpJaksa, data.namaJaksa, data.slug, data.tanggalPenerimaan, data.instansiPenyidik, data.tersangka, data.statusBerkas);
								}

							}

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
				$('#formInputTambahanBerkas input[name=tambahanBerkasIdBerkasPerkara]').attr('value', xidBerkas);

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
				var id_berkas_perkara = $('#tambahanBerkasIdBerkasPerkara').val();

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