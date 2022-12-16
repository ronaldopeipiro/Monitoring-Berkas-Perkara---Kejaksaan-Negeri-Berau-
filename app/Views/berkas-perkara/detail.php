<?= $this->extend('layout/template-notif'); ?>

<?= $this->section('content-notif'); ?>

<div class="container my-4">
	<div class="row row-deck row-cards">

		<div class="col-lg-12 mb-4">
			<div class="card">
				<div class="card-body">
					<div class="row justify-content-between align-items-center">
						<div class="text-center col-lg-5">
							<p class="font-weight-bold">
								APLIKASI MONITORING BERKAS PERKARA
							</p>
						</div>
						<div class="text-center col-lg-2 mb-3 mb-lg-0">
							<img src="<?= base_url(); ?>/assets/img/logo.png" alt="" style="height: 80px;">
						</div>
						<div class="text-center col-lg-5">
							<p class="font-weight-bold">
								KEJAKSAAN NEGERI BERAU
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="card my-3">

				<div class="card-header">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="card-title font-weight-bold">
							Detail Berkas Perkara
						</h3>
						<div>
							<a href="<?= base_url() ?>/berkas-perkara" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Kembali">
								<i class="fa fa-arrow-right"></i> Portal Aplikasi
							</a>
						</div>
					</div>
				</div>

				<div class="card-body border-bottom pb-1 row">

					<div class="col-lg-12 mb-3">

						<div id="loadData"></div>

					</div>


				</div>

			</div>
		</div>

	</div>
</div>


<script>
	$(document).ready(function() {

		$('#loadData').html(`<h5 style="text-align:center; margin-top: 50px;">Mengambil Data . . .</h5>`);

		var slug = "<?= $slug ?>";
		let requestDetail = $.ajax({
			url: base_url + '/berkas-perkara/detail',
			type: "POST",
			dataType: "JSON",
			data: {
				slug: slug
			},
		});

		requestDetail.done(function(msg) {
			const statusData = msg.status;

			if (statusData == 1) {
				const listData = msg.data;
				const jumlahData = listData.length;

				let isiDataDetail = ``;
				if (jumlahData == 0) {
					isiDataDetail = `<h4 class="text-danger font-italic" style="text-align:center; margin-top: 50px;">Maaf, Data tidak ditemukan . . .</h4>`;
				} else {
					for (let i = 0; i < jumlahData; i++) {
						const no = i + 1;
						const dataDetail = listData[i];

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

						textInterval += ` <span class="${classIntervalPenerimaan}">` +
							dataDetail.interval_tanggal_penerimaan + ` hari sejak tanggal penerimaan` +
							`</span>`;

						if (dataDetail.nomor_berkas != "" || dataDetail.tanggal_berkas != "") {
							var classIntervalBerkas = "";
							if (dataDetail.interval_tanggal_spdp >= 30) {
								classIntervalBerkas = "badge btn-danger";
							} else {
								classIntervalBerkas = "badge btn-success";
							}
							textInterval += ` <span class="${classIntervalBerkas}">` +
								dataDetail.interval_tanggal_berkas + ` hari sejak tanggal berkas` +
								`</span>`;
						} else if (dataDetail.nomor_spdp != "" || dataDetail.tanggal_spdp != "") {
							var classIntervalSpdp = "";
							if (dataDetail.interval_tanggal_spdp >= 30) {
								classIntervalSpdp = "badge btn-danger";
							} else {
								classIntervalSpdp = "badge btn-success";
							}
							textInterval += ` <span class="${classIntervalSpdp}">` +
								dataDetail.interval_tanggal_spdp + ` hari sejak tanggal SPDP` +
								`</span>`;
						} else if (dataDetail.nomor_p17 != "" || dataDetail.tanggal_p17 != "") {
							var classIntervalP17 = "";
							if (dataDetail.interval_tanggal_p17 >= 30) {
								classIntervalP17 = "badge btn-danger";
							} else {
								classIntervalP17 = "badge btn-success";
							}
							textInterval += ` <span class="${classIntervalP17}">` +
								dataDetail.interval_tanggal_p17 + ` hari sejak tanggal P-17` +
								`</span>`;
						} else if (dataDetail.nomor_sop_form_02 != "" || dataDetail.tanggal_sop_form_02 != "") {
							var classIntervalSopForm = "";
							if (dataDetail.interval_tanggal_sop_form_02 >= 30) {
								classIntervalSopForm = "badge btn-danger";
							} else {
								classIntervalSopForm = "badge btn-success";
							}
							textInterval += ` <span class="${classIntervalSopForm}">` +
								dataDetail.interval_tanggal_sop_form_02 + ` hari sejak tanggal SOP-Form 02` +
								`</span>`;
						} else if (dataDetail.nomor_surat_pengembalian_spdp != "" || dataDetail.tanggal_surat_pengembalian_spdp != "") {
							var classIntervalSuratPengembalianSpdp = "";
							if (dataDetail.interval_tanggal_surat_pengembalian_spdp >= 30) {
								classIntervalSuratPengembalianSpdp = "badge btn-danger";
							} else {
								classIntervalSuratPengembalianSpdp = "badge btn-success";
							}
							textInterval += ` <span class="${classIntervalSuratPengembalianSpdp}">` +
								dataDetail.interval_tanggal_surat_pengembalian_spdp + ` hari sejak tanggal Surat Pengembalian SPDP` +
								`</span>`;
						}

						// Tampilkan Button Tambah Berkas Jika telah melewati Batas Waktu
						if (dataDetail.interval_tanggal_spdp >= 30 && ((dataDetail.nomor_p17 == "") || (dataDetail.tanggal_p17 == "")) && ((dataDetail.nomor_berkas == "") || (dataDetail.tanggal_berkas == ""))) {
							textInterval += `
										<br>
										berkas ini telah lebih dari 30 hari sejak tanggal SPDP
									`;
						} else if (dataDetail.interval_tanggal_p17 >= 30 && ((dataDetail.nomor_sop_form_02 == "") || (dataDetail.tanggal_sop_form_02 == "")) && ((dataDetail.nomor_berkas == "") || (dataDetail.tanggal_berkas == ""))) {
							textInterval += `
										<br>
										berkas ini telah lebih dari 30 hari sejak tanggal P-17
									`;
						} else if (dataDetail.interval_tanggal_sop_form_02 >= 30 && ((dataDetail.nomor_surat_pengembalian_spdp == "") || (dataDetail.tanggal_surat_pengembalian_spdp == "")) && ((dataDetail.nomor_berkas == "") || (dataDetail.tanggal_berkas == ""))) {
							textInterval += `
										<br>
										berkas ini telah lebih dari 30 hari sejak tanggal SOP-Form 02
									`;
						}

						var url_berkas = '';
						if (dataDetail.file_berkas != "" && dataDetail.file_berkas != null) {
							url_berkas = `
								<a href="` + base_url + `/assets/berkas/` + dataDetail.file_berkas + `" class="badge btn btn-sm btn-info" target="_blank">
									Unduh / Lihat
								</a>
							`;
						}

						var url_spdp = '';
						if (dataDetail.file_spdp != "" && dataDetail.file_spdp != null) {
							url_spdp = `
								<a href="` + base_url + `/assets/berkas/` + dataDetail.file_spdp + `" class="badge btn btn-sm btn-info" target="_blank">
									Unduh / Lihat
								</a>
							`;
						}

						var url_p16 = '';
						if (dataDetail.file_p16 != "" && dataDetail.file_p16 != null) {
							url_p16 = `
								<a href="` + base_url + `/assets/berkas/` + dataDetail.file_p16 + `" class="badge btn btn-sm btn-info" target="_blank">
									Unduh / Lihat
								</a>
							`;
						}

						var url_p17 = '';
						if (dataDetail.file_p17 != "" && dataDetail.file_p17 != null) {
							url_p17 = `
								<a href="` + base_url + `/assets/berkas/` + dataDetail.file_p17 + `" class="badge btn btn-sm btn-info" target="_blank">
									Unduh / Lihat
								</a>
							`;
						}

						var url_sop_form_02 = '';
						if (dataDetail.file_sop_form_02 != "" && dataDetail.file_sop_form_02 != null) {
							url_sop_form_02 = `
								<a href="` + base_url + `/assets/berkas/` + dataDetail.file_sop_form_02 + `" class="badge btn btn-sm btn-info" target="_blank">
									Unduh / Lihat
								</a>
							`;
						}

						var url_surat_pengembalian_spdp = '';
						if (dataDetail.file_surat_pengembalian_spdp != "" && dataDetail.file_surat_pengembalian_spdp != null) {
							url_surat_pengembalian_spdp = `
								<a href="` + base_url + `/assets/berkas/` + dataDetail.file_surat_pengembalian_spdp + `" class="badge btn btn-sm btn-info" target="_blank">
									Unduh / Lihat
								</a>
							`;
						}

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
														${dataDetail.nama_jaksa}
													</td>
												</tr>
												<tr>
													<td>Input at</td>
													<td>:</td>
													<td>
														${dataDetail.update_datetime}
														${dataDetail.nama_user_create}
													</td>
												</tr>
												<tr>
													<td>Update at</td>
													<td>:</td>
													<td>
														${dataDetail.update_datetime}
														${dataDetail.nama_user_update}
													</td>
												</tr>
												<tr>
													<td>Status Perkara</td>
													<td>:</td>
													<td>
														${dataDetail.status}
													</td>
												</tr>
											</table>

										</div>

										<div class="col-lg-4">
											<div class="card">
												<div class="card-body p-1">
													<h5 class="font-weight-bold ml-1">SPDP</h5>
													<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
														<tr>
															<td>Tanggal</td>
															<td>:</td>
															<td>
																${dataDetail.tanggal_spdp_format}
															</td>
														</tr>
														<tr>
															<td>Nomor</td>
															<td>:</td>
															<td>
																${dataDetail.nomor_spdp}
															</td>
														</tr>
														<tr>
															<td>File</td>
															<td>:</td>
															<td>
																${url_spdp}
															</td>
														</tr>
													</table>

												</div>

											</div>
										</div>

										<div class="col-lg-4">
											<div class="card">
												<div class="card-body p-1">
													<h5 class="font-weight-bold ml-1">Berkas Tahap 1</h5>
													<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
														<tr>
															<td>Tanggal</td>
															<td>:</td>
															<td>
																${dataDetail.tanggal_berkas_format}
															</td>
														</tr>
														<tr>
															<td>Nomor</td>
															<td>:</td>
															<td>
																${dataDetail.nomor_berkas}
															</td>
														</tr>
														<tr>
															<td>File</td>
															<td>:</td>
															<td>
																${url_berkas}
															</td>
														</tr>
													</table>
												</div>

											</div>
										</div>

										<div class="col-lg-4">
											<div class="card">
												<div class="card-body p-1">
													<h5 class="font-weight-bold ml-1">Berkas P-16</h5>
													<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
														<tr>
															<td>Tanggal</td>
															<td>:</td>
															<td>
																${dataDetail.tanggal_p16_format}
															</td>
														</tr>
														<tr>
															<td>Nomor</td>
															<td>:</td>
															<td>
																${dataDetail.nomor_p16}
															</td>
														</tr>
														<tr>
															<td>File</td>
															<td>:</td>
															<td>
																${url_p16}
															</td>
														</tr>
													</table>

												</div>

											</div>
										</div>

										<div class="col-lg-4">
											<div class="card">
												<div class="card-body p-1">
													<h5 class="font-weight-bold ml-1">Berkas P-17</h5>
													<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
														<tr>
															<td>Tanggal</td>
															<td>:</td>
															<td>
																${dataDetail.tanggal_p17_format}
															</td>
														</tr>
														<tr>
															<td>Nomor</td>
															<td>:</td>
															<td>
																${dataDetail.nomor_p17}
															</td>
														</tr>
														<tr>
															<td>File</td>
															<td>:</td>
															<td>
																${url_p17}
															</td>
														</tr>
													</table>

												</div>

											</div>
										</div>

										<div class="col-lg-4">
											<div class="card">
												<div class="card-body p-1">
													<h5 class="font-weight-bold ml-1">SOP Form 02</h5>
													<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
														<tr>
															<td>Tanggal</td>
															<td>:</td>
															<td>
																${dataDetail.tanggal_sop_form_02_format}
															</td>
														</tr>
														<tr>
															<td>Nomor</td>
															<td>:</td>
															<td>
																${dataDetail.nomor_sop_form_02}
															</td>
														</tr>
														<tr>
															<td>File</td>
															<td>:</td>
															<td>
																${url_sop_form_02}
															</td>
														</tr>
													</table>
												</div>

											</div>
										</div>

										<div class="col-lg-4">
											<div class="card">
												<div class="card-body p-1">
													<h5 class="font-weight-bold ml-1">Surat Pengembalian SPDP</h5>
													<table class="table-sm table-borderless table-responsive" style="font-size: 12px;">
														<tr>
															<td>Tanggal</td>
															<td>:</td>
															<td>
																${dataDetail.tanggal_surat_pengembalian_spdp_format}
															</td>
														</tr>
														<tr>
															<td>Nomor</td>
															<td>:</td>
															<td>
																${dataDetail.nomor_surat_pengembalian_spdp}
															</td>
														</tr>
														<tr>
															<td>File</td>
															<td>:</td>
															<td>
																${url_surat_pengembalian_spdp}
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
</script>

<?= $this->endSection('content-notif'); ?>