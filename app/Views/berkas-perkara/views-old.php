<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
	<div class="row row-deck row-cards">

		<div class="col-lg-12 mb-4">
			<div class="card h-100">

				<div class="card-header">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="card-title">
							Data Berkas Perkara
						</h3>

						<div>
							<?php if ($user_level == 2) : ?>
								<a href="#" class="btn btn-success text-white btnShowModal" data-toggle="modal" data-target="#modalInput" data-title="Tambah Data Berkas Perkara" data-action="tambah" data-toggle="tooltip" data-placement="bottom" title="Tambah Data">
									<i class="align-middle" data-feather="plus"></i> Tambah
								</a>
							<?php endif; ?>
						</div>

					</div>
				</div>

				<div class="card-body border-bottom row">

					<div class="col-lg-3 mb-3">
						<div class="form-group">
							<label for="cariTanggalPenerimaan">Tanggal Penerimaan</label>
							<div class="cariTanggal">
								<div class="input-group date">
									<span class="input-group-append">
										<span class="input-group-text bg-light d-block">
											<i class="fa fa-calendar"></i>
										</span>
									</span>
									<input type="text" class="form-control form-control-sm pull-right" id="cariTanggalPenerimaan" placeholder="Cth : 01/10/2022 - 31/10/2022">
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3 mb-3">
						<label for="jaksaTerkaitSelect">Jaksa Terkait</label>
						<select class="form-control form-control-sm js-select-2" name="jaksaTerkaitSelect" id="jaksaTerkaitSelect" onchange="getDataTable()">
							<option value="">Semua</option>
							<?php foreach ($list_jaksa as $row) : ?>
								<option value="<?= $row['id_user']; ?>"><?= $row['nama_lengkap']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="col-lg-2 mb-3">
						<label for="instansiPenyidikSelect">Instansi Penyidik</label>
						<select class="form-control form-control-sm js-select-2" name="instansiPenyidikSelect" id="instansiPenyidikSelect" onchange="getDataTable()">
							<option value="">Semua</option>
							<?php foreach ($list_instansi as $row) : ?>
								<option value="<?= $row['id_instansi']; ?>"><?= $row['nama_instansi']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="col-lg-3 mb-3">
						<label for="tersangkaSelect">Tersangka</label>
						<select class="form-control form-control-sm js-select-2" name="tersangkaSelect" id="tersangkaSelect" onchange="getDataTable()">
							<option value="">Semua</option>
							<?php foreach ($list_tersangka as $row) : ?>
								<option value="<?= $row['tersangka']; ?>"><?= $row['tersangka']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="col-lg-1 mb-3">
						<label for="statusBerkasSelect">Status</label>
						<select class="form-control form-control-sm js-select-2" name="statusBerkasSelect" id="statusBerkasSelect" onchange="getDataTable()">
							<option value="">Semua</option>
							<?php foreach ($list_status_berkas as $row) : ?>
								<option value="<?= $row['status_berkas']; ?>"><?= $row['status_berkas']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="col-12">

						<div id="loadTable"></div>

					</div>

				</div>

			</div>
		</div>

	</div>
</div>

<?= $this->include('berkas-perkara/modal-views'); ?>

<script>
	$(document).ready(function() {
		getDataTable();
	});

	function getDataTable() {
		const jaksaTerkaitSelect = $('#jaksaTerkaitSelect').val();
		const instansiPenyidikSelect = $('#instansiPenyidikSelect').val();
		const tersangkaSelect = $('#tersangkaSelect').val();
		const statusBerkasSelect = $('#statusBerkasSelect').val();

		$('#loadTable').html(`<h5 style="text-align:center;">Mengambil Data . . .</h5>`);

		let request = $.ajax({
			url: base_url + '/berkas-perkara/get-data-table',
			type: "POST",
			dataType: "JSON",
			// contentType: "application/json",
			// processData: false,
			// contentType: false,
			// cache: false,
			data: {
				jaksa_terkait: jaksaTerkaitSelect,
				instansi_penyidik: instansiPenyidikSelect,
				tersangka: tersangkaSelect,
				status_berkas: statusBerkasSelect,
			},
		});

		request.done(function(msg) {
			const status = msg.status;
			console.log(msg.instansi_penyidik);
			if (status == 1) {
				const listData = msg.data;
				const banyakData = listData.length;

				let isiTabel = ``;
				if (banyakData == 0) {
					isiTabel = `<tr><td colspan="9" style="text-align:center">Tidak ada data ...</td></tr>`;
				} else {
					for (let i = 0; i < banyakData; i++) {
						const no = i + 1;
						const data = listData[i];

						var spdp = '';
						if (data.file_spdp != "") {
							spdp += `
								<a href="` + base_url + `/assets/berkas/${data.file_spdp}" target="_blank" class="d-inline-block text-truncate" style="max-width: 100px;">
									No. : ${data.nomor_spdp}
								</a> <br>
								Tgl. : ${data.tanggal_spdp} 
							`;
						} else {
							if (data.nomor_spdp != "") {
								spdp += `
									<span class="d-inline-block text-truncate" style="max-width: 100px;">
										No. : ${data.nomor_spdp}
									</span> <br>
									Tgl. : ${data.tanggal_spdp} 
								`;
							}
						}

						var berkas_tahap_1 = '';
						if (data.file_berkas != "") {
							berkas_tahap_1 += `
								<a href="` + base_url + `/assets/berkas/${data.file_berkas}" target="_blank" class="d-inline-block text-truncate" style="max-width: 100px;">
									No. : ${data.nomor_berkas}
								</a> <br>
								Tgl. : ${data.tanggal_berkas} 
							`;
						} else {
							if (data.nomor_berkas != "") {
								berkas_tahap_1 += `
									<span class="d-inline-block text-truncate" style="max-width: 100px;">
										No. : ${data.nomor_berkas}
									</span> <br>
									Tgl. : ${data.tanggal_berkas} 
								`;
							}
						}

						var p16 = '';
						if (data.file_p16 != "") {
							p16 += `
								<a href="` + base_url + `/assets/berkas/${data.file_p16}" target="_blank" class="d-inline-block text-truncate" style="max-width: 100px;">
									No. : ${data.nomor_p16}
								</a> <br>
								Tgl. : ${data.tanggal_p16} 
							`;
						} else {
							if (data.nomor_p16 != "") {
								p16 += `
									<span class="d-inline-block text-truncate" style="max-width: 100px;">
										No. : ${data.nomor_p16}
									</span> <br>
									Tgl. : ${data.tanggal_p16} 
								`;
							}
						}

						var buttonAction = '';
						if (data.editable == 'Y') {
							buttonAction += `
								<li class="mr-1">
									<a href="#" data-toggle="modal" data-target="#modalInput" data-action="ubah" data-title="Ubah Data Berkas Perkara" data-id="${data.id_berkas_perkara}" class="btn btn-sm btn-info text-white btnShowModal" data-toggle="tooltip" data-placement="bottom" title="Ubah">
										<i class="fa fa-edit"></i>
									</a>
								</li>
								<li>
									<a href="#" onclick="hapus_data(${data.id_berkas_perkara})" class="btn btn-sm btn-danger text-white" data-toggle="tooltip" data-placement="bottom" title="Hapus">
										<i class="fa fa-trash"></i>
									</a>
								</li>
							`;
						}

						isiTabel += `
						<tr>
							<td class="text-center">${no}.</td>
							<td>${data.tanggal_penerimaan_format}</td>
							<td>${spdp}</td>
							<td>${berkas_tahap_1}</td>
							<td>${p16}</td>
							<td>${data.tersangka}</td>
							<td>${data.nama_instansi_penyidik}</td>
							<td>${data.jaksa_terkait_text}</td>
							<td>${data.status_berkas}</td>
							<td>
								<div class="list-unstyled d-flex align-items-center justify-content-center">
									<li class="mr-1">
										<a href="#" data-toggle="modal" data-target="#modalDetail" data-action="detail" data-title="Detail Data Berkas Perkara" data-id="${data.id_berkas_perkara}" class="btn btn-sm btn-success text-white btnShowModalDetail" data-toggle="tooltip" data-placement="bottom" title="Detail">
											<i class="fa fa-list"></i>
										</a>
									</li>
									${buttonAction}
								</div>
							</td>
						</tr>
						`;
					}
				}

				$('#loadTable').html(`
						<table class="table table-sm table-hover table-responsivea table-striped" id="data-table-custom" style="font-size: 10px;">
							<thead>
								<tr>
									<th>No.</th>
									<th>Tanggal Penerimaan</th>
									<th>SPDP</th>
									<th>Berkas Tahap 1</th>
									<th>P16</th>
									<th>Tersangka</th>
									<th>Instansi Penyidik</th>
									<th>Jaksa Terkait</th>
									<th>Status Berkas</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>${isiTabel}</tbody>
					</table>
					`);

				if (banyakData > 0) {
					var $dTable = $('#data-table-custom').DataTable({
						<?php if ($user_level < 3) : ?> "dom": '<"d-block d-lg-flex justify-content-between"lf<"btn btn-sm"B>r>t<"d-block d-lg-flex justify-content-between"ip>',
						<?php endif; ?> "paging": true,
						"responsive": true,
						"searching": true,
						"deferRender": true,
						"initComplete": function(settings, json) {},
						"lengthMenu": [
							[10, 25, 50, 100, 250, 500, -1],
							['10', '25', '50', '100', '250', '500', 'Semua']
						],
						"buttons": [{
								extend: 'excelHtml5',
								filename: 'DATA BERKAS PERKARA KEJAKSAAN NEGERI BERAU - update ' + tanggalHariIni,
								text: 'Export Excel (*xlsx)',
								exportOptions: {
									columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
									stripHtml: true,
									modifier: {
										page: 'current'
									}
								}
							},
							{
								extend: 'pdfHtml5',
								filename: 'DATA BERKAS PERKARA KEJAKSAAN NEGERI BERAU - update ' + tanggalHariIni,
								text: 'Export PDF (*pdf)',
								message: 'DATA BERKAS PERKARA',
								messageBottom: 'Data dibuat otomatis oleh sistem : ' + tanggalHariIni,
								exportOptions: {
									columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
									stripHtml: true,
									modifier: {
										page: 'current'
									}
								},
								orientation: 'landscape',
								pageSize: 'LEGAL',
								customize: function(doc) {
									doc.pageMargins = [20, 20, 20, 20];
									doc.defaultStyle.fontSize = 10;
									doc.styles.tableHeader.fontSize = 10;
									doc.styles.title.fontSize = 14;
									doc.content[0].text = doc.content[0].text.trim();
									// Create a footer
									doc['footer'] = (function(page, pages) {
										return {
											columns: [
												'BERKAS PERKARA - KEJAKSAAN NEGERI BERAU',
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
						]
					});

					var datetime = new Date();
					var tanggalHariIni = datetime.getDate() + '-' + datetime.getMonth() + '-' + datetime.getFullYear();

					var start_date;
					var end_date;

					var filterTanggalPenerimaan = (function(oSettings, aData, iDataIndex) {
						var dateStart = parseDateValue(start_date);
						var dateEnd = parseDateValue(end_date);
						var evalDate = parseDateValue(aData[1]);
						if ((isNaN(dateStart) && isNaN(dateEnd)) ||
							(isNaN(dateStart) && evalDate <= dateEnd) ||
							(dateStart <= evalDate && isNaN(dateEnd)) ||
							(dateStart <= evalDate && evalDate <= dateEnd)) {
							return true;
						}
						return false;
					});

					function parseDateValue(rawDate) {
						var dateArray = rawDate.split("/");
						var parsedDate = new Date(dateArray[2], parseInt(dateArray[1]) - 1, dateArray[0]);
						return parsedDate;
					}

					document.getElementsByClassName("cariTanggal")[0].style.textAlign = "right";

					//konfigurasi daterangepicker pada input dengan id cariTanggalPenerimaan
					$('#cariTanggalPenerimaan').daterangepicker({
						autoUpdateInput: false
					});

					$('#cariTanggalPenerimaan').on('apply.daterangepicker', function(ev, picker) {
						$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
						start_date = picker.startDate.format('DD/MM/YYYY');
						end_date = picker.endDate.format('DD/MM/YYYY');
						$.fn.dataTableExt.afnFiltering.push(filterTanggalPenerimaan);
						$dTable.draw();
					});

					$('#cariTanggalPenerimaan').on('cancel.daterangepicker', function(ev, picker) {
						$(this).val('');
						start_date = '';
						end_date = '';
						$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(filterTanggalPenerimaan, 1));
						$dTable.draw();
					});
				}
			} else {
				$('#loadTable').html(`<h3 style="text-align:center">${msg.msg}</h3>`);
			}
		});

		request.fail(function(jqXHR, textStatus) {
			$('#loadTable').html(`
				<h5 style="text-align: center; color: red;">
					Gagal Mengambil Data, Terjadi Kesalahan Teknis<br>
					<button class="btn btn-primary" onClick="getDataTable()">Coba Lagi</button>
				</h5>
			`);
		});
	}

	function hapus_data(id_berkas_perkara) {
		event.preventDefault(); // prevent form submit

		var urlPost = base_url + "/berkas-perkara/delete";

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
						id_berkas_perkara: id_berkas_perkara
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
</script>

<?= $this->endSection('content'); ?>