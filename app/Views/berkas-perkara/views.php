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

				<div class="card-body border-bottom pb-1 row">

					<div class="col-12">
						<div class="row">

							<div class="col-lg-3 mb-3">
								<div class="form-group">
									<label for="tanggalOrderSelect">Tanggal</label>
									<div class="cariTanggal">
										<div class="input-group date">
											<span class="input-group-append">
												<span class="input-group-text bg-light d-block">
													<i class="fa fa-calendar"></i>
												</span>
											</span>
											<input type="text" class="form-control form-control-sm pull-right" id="cariTanggalBerkas" placeholder="Cth : 01/10/2022 - 31/10/2022">
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-3 mb-3">
								<div class="form-group">
									<label for="tanggalOrderSelect">Tanggal</label>
									<div class="cariTanggal">
										<div class="input-group date">
											<span class="input-group-append">
												<span class="input-group-text bg-light d-block">
													<i class="fa fa-calendar"></i>
												</span>
											</span>
											<input type="text" class="form-control form-control-sm pull-right" id="cariTanggalP16" placeholder="Cth: 01/10/2022 - 31/10/2022">
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-2 mb-3">
								<label for="instansiPenyidikSelect">Instansi Penyidik</label>
								<div id="instansiPenyidikSelect"></div>
							</div>

							<div class="col-lg-2 mb-3">
								<label for="instansiPelaksanaPenyidikanSelect">Instansi Pelaksana</label>
								<div id="instansiPelaksanaPenyidikanSelect"></div>
							</div>

							<div class="col-lg-2 mb-3">
								<label for="statusSelect">Status</label>
								<div id="statusSelect"></div>
							</div>
						</div>
					</div>

					<div class="col-12">
						<!-- <a id="card-view-table" class="btn btn-success" href="#">CARD VIEW</a> -->
						<table class="table table-sm table-hover table-responsive-sm table-striped" id="data-table-custom" style="font-size: 12px;">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nomor / Tgl. Berkas</th>
									<th>Nomor / Tgl. P16</th>
									<th>Instansi Penyidik</th>
									<th>Instansi Pelaksana Penyidikan</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
							</thead>

							<tbody>
								<?php $no = 1; ?>
								<?php foreach ($data_berkas_perkara as $row) : ?>
									<?php
									$id_instansi_penyidik = $row['id_instansi_penyidik'];
									$instansi_penyidik = $db->query("SELECT * FROM instansi WHERE id_instansi='$id_instansi_penyidik' ")->getRow();
									$id_instansi_pelaksana_penyidikan = $row['id_instansi_pelaksana_penyidikan'];
									$instansi_pelaksana_penyidikan = $db->query("SELECT * FROM instansi WHERE id_instansi='$id_instansi_pelaksana_penyidikan' ")->getRow();
									?>

									<tr>
										<td class="text-center"><?= $no++; ?>.</td>
										<td>
											<?= $row['nomor_berkas']; ?> <br>
											<?= strftime('%d/%m/%Y', strtotime($row['tanggal_berkas'])); ?>
										</td>
										<td>
											<?= $row['nomor_p16']; ?> <br>
											<?= strftime('%d/%m/%Y', strtotime($row['tanggal_p16'])); ?>
										</td>
										<td>
											<?= $instansi_penyidik->nama_instansi; ?>
										</td>
										<td>
											<?= $instansi_pelaksana_penyidikan->nama_instansi; ?>
										</td>
										<td>
											<?= $data_pltd->nama_pltd; ?>
										</td>
										<td>
											<?= $data_mesin->nama_mesin; ?>
										</td>
										<td class="text-center">
											<?= $row['status']; ?>
										</td>
										<td class="table-action">
											<?php if (($user_level <= 2) or ($user_id == $row['id_user'])) : ?>
												<div class="list-unstyled d-flex align-items-center justify-content-center">
													<li>
														<a href="#" class="btn btn-warning text-white btnShowModal" data-toggle="modal" data-target="#modalInput" data-action="ubah" data-title="Ubah Data Berkas Perkara" data-id="<?= $row['id_berkas_perkara']; ?>" class="btn btn-info d-flex text-white" data-toggle="tooltip" data-placement="bottom" title="Ubah">
															<i class="align-middle" data-feather="edit"></i>
														</a>
													</li>
													<li>
														<a href="#" onclick="hapus_data(<?= $row['id_berkas_perkara'] ?>)" class="btn btn-danger text-white" data-toggle="tooltip" data-placement="bottom" title="Hapus">
															<i class="align-middle" data-feather="trash"></i>
														</a>
													</li>
												</div>
											<?php endif; ?>
										</td>
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
					<input type="hidden" id="id_berkas_perkara" name="id_berkas_perkara" value="">
					<input type="hidden" id="id_user" name="id_user" value="<?= $user_id; ?>">

					<div class="form-group row mb-3">
						<label for="pidana_anak" class="col-sm-12 col-form-label">
							Pidana Anak
						</label>
						<div class="col-sm-12">
							<input type="checkbox" class="form-control" id="pidana_anak" name="pidana_anak" value="Ya">
						</div>
					</div>

					<div class="form-group row mb-3">
						<div class="col-lg-6 mb-3 mb-lg-0">
							<div class="row">
								<label for="nomor_berkas" class="col-sm-12 col-form-label">
									Nomor Berkas
								</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="nomor_berkas" name="nomor_berkas" placeholder="Masukkan Nomor Berkas ..." value="">
								</div>
							</div>
						</div>

						<div class="col-lg-6 mb-3 mb-lg-0">
							<div class="row">
								<label for="tanggal_berkas" class="col-sm-12 col-form-label">
									Tanggal Berkas
								</label>
								<div class="col-sm-12">
									<input type="date" class="form-control" id="tanggal_berkas" name="tanggal_berkas" placeholder="0" value="<?= date('Y-m-d'); ?>" style="width: 200px;">
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row mb-3">
						<div class="col-lg-6 mb-3 mb-lg-0">
							<div class="row">
								<label for="nomor_p16" class="col-sm-12 col-form-label">
									Nomor P-16
								</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="nomor_p16" name="nomor_p16" placeholder="Masukkan Nomor P-16 ..." value="">
								</div>
							</div>
						</div>

						<div class="col-lg-6 mb-3 mb-lg-0">
							<div class="row">
								<label for="tanggal_p16" class="col-sm-12 col-form-label">
									Tanggal P-16
								</label>
								<div class="col-sm-12">
									<input type="date" class="form-control" id="tanggal_p16" name="tanggal_p16" placeholder="0" value="<?= date('Y-m-d'); ?>" style="width: 200px;">
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row mb-3">
						<div class="col-lg-6 mb-3 mb-lg-0">
							<div class="row">
								<label for="id_instansi_penyidik" class="col-sm-12 col-form-label">
									Instansi Penyidik
								</label>
								<div class="col-sm-12">
									<select name="id_instansi_penyidik" id="id_instansi_penyidik" class="form-control js-select-2">
										<option value="">-- Pilih Instansi Penyidik --</option>
										<?php foreach ($list_instansi as $d_ins) : ?>
											<option value="<?= $d_ins['id_instansi']; ?>">
												<?= $d_ins['nama_instansi']; ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-6 mb-3 mb-lg-0">
							<label for="id_instansi_pelaksana_penyidikan" class="col-sm-12 col-form-label">
								Instansi Pelaksana Penyidikan
							</label>
							<div class="col-sm-12">
								<select name="id_instansi_pelaksana_penyidikan" id="id_instansi_pelaksana_penyidikan" class="form-control js-select-2">
									<option value="">-- Pilih Instansi Pelaksana Penyidikan --</option>
									<?php foreach ($list_instansi as $d_ins_2) : ?>
										<option value="<?= $d_ins_2['id_instansi']; ?>">
											<?= $d_ins_2['nama_instansi']; ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group row mb-3">
						<label for="jaksa_terkait" class="col-sm-12 col-form-label">
							Jaksa Terkait
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

					<div class="form-group row mb-3">
						<label for="status_berkas" class="col-sm-12 col-form-label">
							Status Berkas
						</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="status_berkas" name="status_berkas" placeholder="Masukkan Status Berkas ..." value="">
						</div>
					</div>

					<div class="form-group row mb-2">
						<label for="file_berkas" class="col-sm-12 col-form-label">
							File Berkas
							<small class="text-danger">
								(*Jika Ada) (*Maks 4 MB)
							</small>
						</label>
						<div class="col-sm-12">
							<input type="file" name="file_berkas" class="dropify" data-max-file-size="4M" data-show-remove="true" data-show-loader="true" data-show-errors="true" data-errors-position="outside" data-max-file-size-preview="4M" />
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

<script>
	$(document).ready(function() {
		$(function() {
			// Modal Ubah
			// $("#modalInput").css("z-index", "1500");
			$("#modalInput").appendTo('body');

			$(document).on('click', '.btnShowModal', function() {
				var title = $(this).data('title');
				var action = $(this).data('action');

				$('#modalInput #judulForm').text(title);
				$('#modalInput #action').val(action);

				if (action == "tambah") {
					$("form").trigger("reset");
				} else if (action == "ubah") {
					var id_berkas_perkara = $(this).data('id');
					var tanggalwaktu = $(this).data('tanggalwaktu');
					var iduser = $(this).data('iduser');
					var idpltd = $(this).data('idpltd');
					var idmesin = $(this).data('idmesin');
					var unit = $(this).data('unit');
					var idjenisperiodik = $(this).data('idjenisperiodik');
					var rencana = $(this).data('rencana');
					var realisasi = $(this).data('realisasi');
					var catatan = $(this).data('catatan');

					$('#modalInput #id_berkas_perkara').val(id_berkas_perkara);
					$('#modalInput #tanggal_waktu').val(tanggalwaktu);
					$('#modalInput #id_user').val(iduser);
					$('#modalInput #id_pltd').val(idpltd);
					$('#modalInput #id_mesin').val(idmesin);
					$('#modalInput #unit').val(unit);
					$('#modalInput #id_jenis_periodik').val(idjenisperiodik);
					$('#modalInput #rencana').val(rencana);
					$('#modalInput #realisasi').val(realisasi);
					$('#modalInput #catatan').val(catatan);
				}
			});

			$("#formInput").submit(function(e) {
				e.preventDefault();

				var action = $('#action').val();

				if (action == "tambah") {
					var urlPost = base_url + "/berkas-perkara/add";
				} else if (action == "ubah") {
					var urlPost = base_url + "/berkas-perkara/edit";
				}

				var id_berkas_perkara = $('#id_berkas_perkara').val();
				var tanggal_waktu = $('#tanggal_waktu').val();
				var id_user = $('#id_user').val();
				var id_pltd = $('#id_pltd').val();
				var id_mesin = $('#id_mesin').val();
				var unit = $('#unit').val();
				var id_jenis_periodik = $('#id_jenis_periodik').val();
				var rencana = $('#rencana').val();
				var realisasi = $('#realisasi').val();
				var catatan = $('#catatan').val();

				$.ajax({
					type: "POST",
					url: urlPost,
					dataType: "JSON",
					data: {
						id_berkas_perkara: id_berkas_perkara,
						tanggal_waktu: tanggal_waktu,
						id_user: id_user,
						id_pltd: id_pltd,
						id_mesin: id_mesin,
						unit: unit,
						id_jenis_periodik: id_jenis_periodik,
						rencana: rencana,
						realisasi: realisasi,
						catatan: catatan
					},
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

	$(document).ready(function() {
		var datetime = new Date();
		var tanggalHariIni = datetime.getDate() + '-' + datetime.getMonth() + '-' + datetime.getFullYear();

		var start_date;
		var end_date;

		var filterTanggalWaktu = (function(oSettings, aData, iDataIndex) {
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

		var $dTable = $('#data-table-custom').DataTable({
			<?php if ($user_level < 3) : ?> "dom": '<"d-block d-lg-flex justify-content-between"lf<"btn btn-sm"B>r>t<"d-block d-lg-flex justify-content-between"ip>',
			<?php endif; ?> "paging": true,
			"responsive": true,
			"searching": true,
			"deferRender": true,
			"initComplete": function(settings, json) {
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
									$(`<span class="colHeader font-weight-bold">` + labels[column] + `</span>`).prependTo(
										`<span class="text-left">` +
										$(this) +
										`</span>`
									);
								});
						});
					}
					$("#data-table-custom").toggleClass("card");
				});

				var status = this.api().column(5);
				var statusSelect = $('<select class="filter form-control js-select-2"><option value="">Semua</option></select>')
					.appendTo('#statusSelect')
					.on('change', function() {
						var val = $(this).val();
						status.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				status.data().unique().sort().each(function(d, j) {
					statusSelect.append('<option value="' + d + '">' + d + '</option>');
				});

				var instansiPenyidik = this.api().column(3);
				var instansiPenyidikSelect = $('<select class="filter form-control form-control-sm js-select-2"><option value="">Semua</option></select>')
					.appendTo('#instansiPenyidikSelect')
					.on('change', function() {
						var val = $(this).val();
						instansiPenyidik.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				instansiPenyidikSelect.append(`
				<?php foreach ($list_instansi as $row) : ?>
					<option value="<?= $row['nama_instansi'] ?>"><?= $row['nama_instansi'] ?></option>
				<?php endforeach; ?>
					`);

				var instansiPelaksanaPenyidikan = this.api().column(4);
				var instansiPelaksanaPenyidikanSelect = $('<select class="filter form-control form-control-sm js-select-2"><option value="">Semua</option></select>')
					.appendTo('#instansiPelaksanaPenyidikanSelect')
					.on('change', function() {
						var val = $(this).val();
						instansiPelaksanaPenyidikan.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				instansiPelaksanaPenyidikanSelect.append(`
				<?php foreach ($list_instansi as $row) : ?>
					<option value="<?= $row['nama_instansi'] ?>"><?= $row['nama_instansi'] ?></option>
				<?php endforeach; ?>
					`);
			},
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				['10', '25', '50', '100', 'Semua']
			],
			"buttons": [{
					extend: 'excelHtml5',
					filename: 'DATA BERKAS PERKARA KEJAKSAAN NEGERI BERAU - update ' + tanggalHariIni,
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
					filename: 'DATA BERKAS PERKARA KEJAKSAAN NEGERI BERAU - update ' + tanggalHariIni,
					text: 'Export PDF (*pdf)',
					message: 'DATA BERKAS PERKARA',
					messageBottom: 'Data dibuat otomatis oleh sistem : ' + tanggalHariIni,
					exportOptions: {
						// columns: [0, 1, 2, 3, 4, 5],
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

		document.getElementsByClassName("cariTanggal")[0].style.textAlign = "right";

		//konfigurasi daterangepicker pada input dengan id cariTanggalBerkas
		$('#cariTanggalBerkas').daterangepicker({
			autoUpdateInput: false
		});

		//menangani proses saat apply date range
		$('#cariTanggalBerkas').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
			start_date = picker.startDate.format('DD/MM/YYYY');
			end_date = picker.endDate.format('DD/MM/YYYY');
			$.fn.dataTableExt.afnFiltering.push(filterTanggalWaktu);
			$dTable.draw();
		});

		$('#cariTanggalBerkas').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
			start_date = '';
			end_date = '';
			$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(filterTanggalWaktu, 1));
			$dTable.draw();
		});

		//konfigurasi daterangepicker pada input dengan id cariTanggalP16
		$('#cariTanggalP16').daterangepicker({
			autoUpdateInput: false
		});

		//menangani proses saat apply date range
		$('#cariTanggalP16').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
			start_date = picker.startDate.format('DD/MM/YYYY');
			end_date = picker.endDate.format('DD/MM/YYYY');
			$.fn.dataTableExt.afnFiltering.push(filterTanggalWaktu);
			$dTable.draw();
		});

		$('#cariTanggalP16').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
			start_date = '';
			end_date = '';
			$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(filterTanggalWaktu, 1));
			$dTable.draw();
		});
	});

	$('.dropify').dropify({
		messages: {
			'default': 'Drag and drop a file here or click',
			'replace': 'Drag and drop or click to replace',
			'remove': 'Hapus',
			'error': 'Maaf, terjadi kesalahan !'
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

<?= $this->endSection('content'); ?>