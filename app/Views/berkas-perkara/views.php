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

					<div class="col-lg-4 mb-3">
						<label for="instansiPenyidikSelect">Instansi Penyidik</label>
						<div id="instansiPenyidikSelect"></div>
					</div>

					<div class="col-lg-2 mb-3">
						<label for="statusSelect">Status</label>
						<div id="statusSelect"></div>
					</div>

					<div class="col-12">
						<!-- <a id="card-view-table" class="btn btn-success" href="#">CARD VIEW</a> -->
						<table class="table table-sm table-hover table-responsive-sm table-striped" id="data-table-custom" style="font-size: 12px;">
							<thead>
								<tr>
									<th>No.</th>
									<th>Tanggal Penerimaan</th>
									<th>SPDP</th>
									<th>Berkas Tahap 1</th>
									<th>P16</th>
									<th>Instansi Penyidik</th>
									<th>Jaksa Terkait</th>
									<th>Status Berkas</th>
									<th>Aksi</th>
								</tr>
							</thead>

							<tbody>
								<?php $no = 1; ?>
								<?php foreach ($data_berkas_perkara as $row) : ?>
									<?php
									$interval_tanggal_penerimaan = date_diff(date_create($row['tanggal_penerimaan']), date_create(date('Y-m-d')))->days;

									$interval_tanggal_spdp = 0;
									if ($row['tanggal_spdp'] != "") {
										$interval_tanggal_spdp = date_diff(date_create($row['tanggal_spdp']), date_create(date('Y-m-d')))->days;
									}

									if ($row['notifikasi_send'] == "Y") {
										$status_notifikasi = "Notifikasi telah dikirim kepada jaksa terkait";
									} else if ($row['notifikasi_send'] == "N") {
										$status_notifikasi = "Menunggu jadwal";
									}

									$id_instansi_penyidik = $row['id_instansi_penyidik'];
									$instansi_penyidik = $db->query("SELECT * FROM instansi WHERE id_instansi='$id_instansi_penyidik' ")->getRow();

									$array_jaksa_terkait = $row['jaksa_terkait'];
									$data_jaksa_terkait = $db->query("SELECT * FROM user WHERE id_user IN ($array_jaksa_terkait) ORDER BY nama_lengkap ASC ");
									$jaksa_terkait = "";
									foreach ($data_jaksa_terkait->getResult('array') as $jt) {
										$jaksa_terkait .= "<span class='badge btn-primary'>" . $jt['nama_lengkap'] . "</span> <br>";
									}

									$nama_user_create = "";
									if ($row['id_user_create'] != "") {
										$id_user_create = $row['id_user_create'];
										$user_create = $db->query("SELECT * FROM user WHERE id_user='$id_user_create' ")->getRow();
										$nama_user_create = $user_create->nama_lengkap;
									}

									$nama_user_update = "";
									if ($row['id_user_update'] != "") {
										$id_user_update = $row['id_user_update'];
										$user_update = $db->query("SELECT * FROM user WHERE id_user='$id_user_update' ")->getRow();
										$nama_user_update = $user_update->nama_lengkap;
									}

									?>

									<tr>
										<td class="text-center"><?= $no++; ?>.</td>
										<td>
											<?php if (($row['tanggal_penerimaan'] != "0000-00-00") and ($row['tanggal_penerimaan'] != "")) : ?>
												<?= date('d/m/Y', strtotime($row['tanggal_penerimaan'])); ?>
											<?php endif; ?>
										</td>

										<td>
											<?php if ($row['file_spdp'] != "") : ?>
												<a href="<?= base_url(); ?>/assets/berkas/<?= $row['file_spdp']; ?>" target="_blank">
													No. : <?= $row['nomor_spdp']; ?>
												</a>
											<?php else : ?>
												<?php if ($row['nomor_spdp'] != "") : ?>
													No. : <?= $row['nomor_spdp']; ?>
												<?php endif; ?>
											<?php endif; ?>
											<br>
											<?php if (($row['tanggal_spdp'] != "0000-00-00") and ($row['tanggal_spdp'] != "")) : ?>
												Tgl. : <?= date('d/m/Y', strtotime($row['tanggal_spdp'])); ?>
											<?php endif; ?>
										</td>

										<td>
											<?php if ($row['file_berkas'] != "") : ?>
												<a href="<?= base_url(); ?>/assets/berkas/<?= $row['file_berkas']; ?>" target="_blank">
													No. : <?= $row['nomor_berkas']; ?>
												</a>
											<?php else : ?>
												<?php if ($row['nomor_berkas'] != "") : ?>
													No. : <?= $row['nomor_berkas']; ?>
												<?php endif; ?>
											<?php endif; ?>
											<br>
											<?php if (($row['tanggal_berkas'] != "0000-00-00") and ($row['tanggal_berkas'] != "")) : ?>
												Tgl. : <?= date('d/m/Y', strtotime($row['tanggal_berkas'])); ?>
											<?php endif; ?>
										</td>

										<td>
											<?php if ($row['file_p16'] != "") : ?>
												<a href="<?= base_url(); ?>/assets/p16/<?= $row['file_p16']; ?>" target="_blank">
													No. : <?= $row['nomor_p16']; ?>
												</a>
											<?php else : ?>
												<?php if ($row['nomor_p16'] != "") : ?>
													No. : <?= $row['nomor_p16']; ?>
												<?php endif; ?>
											<?php endif; ?>
											<br>
											<?php if (($row['tanggal_p16'] != "0000-00-00") and ($row['tanggal_p16'] != "")) : ?>
												Tgl. : <?= date('d/m/Y', strtotime($row['tanggal_p16'])); ?>
											<?php endif; ?>
										</td>
										<td>
											<?= $instansi_penyidik->nama_instansi; ?>
										</td>
										<td class="text-left">
											<?= $jaksa_terkait; ?>
										</td>
										<td class="text-center">
											<?= $row['status_berkas']; ?>
										</td>
										<td>
											<div class="list-unstyled d-flex align-items-center justify-content-center">
												<li>
													<a href="#" data-toggle="modal" data-target="#modalDetail" data-action="detail" data-title="Detail Data Berkas Perkara" data-id-berkas-perkara="<?= $row['id_berkas_perkara']; ?>" data-nomor-berkas="<?= $row['nomor_berkas']; ?>" data-tanggal-berkas="<?= (($row['tanggal_berkas'] != "0000-00-00") and ($row['tanggal_berkas'] != "")) ? date('d/m/Y', strtotime($row['tanggal_berkas'])) : '' ?>" data-tanggal-penerimaan="<?= date('d/m/Y', strtotime($row['tanggal_penerimaan'])); ?>" data-file-berkas="<?= ($row['file_berkas'] != "") ? base_url() . '/assets/berkas/' . $row['file_berkas'] : ''; ?>" data-nomor-spdp="<?= $row['nomor_spdp']; ?>" data-tanggal-spdp="<?= (($row['tanggal_spdp'] != "0000-00-00") and ($row['tanggal_spdp'] != "")) ? date('d/m/Y', strtotime($row['tanggal_spdp'])) : '' ?>" data-file-spdp="<?= ($row['file_spdp'] != "") ? base_url() . '/assets/berkas/' . $row['file_spdp'] : ''; ?>" data-nomor-p16="<?= $row['nomor_p16']; ?>" data-tanggal-p16="<?= (($row['tanggal_p16'] != "0000-00-00") and ($row['tanggal_p16'] != "")) ? date('d/m/Y', strtotime($row['tanggal_p16'])) : '' ?>" data-file-p16="<?= ($row['file_p16'] != "") ? base_url() . '/assets/berkas/' . $row['file_p16'] : ''; ?>" data-nomor-p17="<?= $row['nomor_p17']; ?>" data-tanggal-p17="<?= (($row['tanggal_p17'] != "0000-00-00") and ($row['tanggal_p17'] != "")) ? date('d/m/Y', strtotime($row['tanggal_p17'])) : '' ?>" data-file-p17="<?= ($row['file_p17'] != "") ? base_url() . '/assets/berkas/' . $row['file_p17'] : ''; ?>" data-nomor-sop-form="<?= $row['nomor_sop_form_02']; ?>" data-tanggal-sop-form="<?= (($row['tanggal_sop_form_02'] != "0000-00-00") and ($row['tanggal_sop_form_02'] != "")) ? date('d/m/Y', strtotime($row['tanggal_sop_form_02'])) : '' ?>" data-file-sop-form="<?= ($row['file_sop_form_02'] != "") ? base_url() . '/assets/berkas/' . $row['file_sop_form_02'] : ''; ?>" data-nomor-surat-pengembalian-spdp="<?= $row['nomor_surat_pengembalian_spdp']; ?>" data-tanggal-surat-pengembalian-spdp="<?= (($row['tanggal_surat_pengembalian_spdp'] != "0000-00-00") and ($row['tanggal_surat_pengembalian_spdp'] != "")) ? date('d/m/Y', strtotime($row['tanggal_surat_pengembalian_spdp'])) : '' ?>" data-file-surat-pengembalian-spdp="<?= ($row['file_surat_pengembalian_spdp'] != "") ? base_url() . '/assets/berkas/' . $row['file_surat_pengembalian_spdp'] : ''; ?>" data-instansi-penyidik="<?= $instansi_penyidik->nama_instansi; ?>" data-jaksa-terkait="<?= $jaksa_terkait; ?>" data-status-berkas="<?= $row['status_berkas']; ?>" data-pidana-anak="<?= $row['pidana_anak']; ?>" data-create-datetime="<?= (($row['create_datetime'] != "0000-00-00") and ($row['create_datetime'] != "")) ? ' pada ' . date('d/m/Y H:i:s', strtotime($row['create_datetime'])) : '' ?>" data-update-datetime="<?= (($row['update_datetime'] != "0000-00-00") and ($row['update_datetime'] != "")) ? ' pada ' . date('d/m/Y H:i:s', strtotime($row['update_datetime'])) : '' ?>" data-user-create="<?= $nama_user_create; ?>" data-user-update="<?= $nama_user_update; ?>" data-status-notifikasi="<?= $status_notifikasi; ?>" data-status-perkara="<?= $row['status']; ?>" data-interval-penerimaan="<?= $interval_tanggal_penerimaan; ?>" data-interval-spdp="<?= $interval_tanggal_spdp; ?>" class="btn btn-success text-white btnShowModalDetail" data-toggle="tooltip" data-placement="bottom" title="Detail">
														<i class="align-middle" data-feather="list"></i>
													</a>
												</li>

												<?php if (($user_level < 3) or ($user_id == $row['id_user_create'])) : ?>

													<li>
														<a href="#" data-toggle="modal" data-target="#modalInput" data-action="ubah" data-title="Ubah Data Berkas Perkara" data-id-berkas-perkara="<?= $row['id_berkas_perkara']; ?>" data-nomor-spdp="<?= $row['nomor_spdp']; ?>" data-tanggal-spdp="<?= (($row['tanggal_spdp'] != "0000-00-00") and ($row['tanggal_spdp'] != "")) ? date('Y-m-d', strtotime($row['tanggal_spdp'])) : '' ?>" data-file-spdp="<?= $row['file_spdp']; ?>" data-nomor-berkas="<?= $row['nomor_berkas']; ?>" data-tanggal-berkas="<?= (($row['tanggal_berkas'] != "0000-00-00") and ($row['tanggal_berkas'] != "")) ? date('Y-m-d', strtotime($row['tanggal_berkas'])) : '' ?>" data-file-berkas="<?= $row['file_berkas']; ?>" data-tanggal-penerimaan="<?= date('Y-m-d', strtotime($row['tanggal_penerimaan'])); ?>" data-nomor-p16="<?= $row['nomor_p16']; ?>" data-tanggal-p16="<?= (($row['tanggal_p16'] != "0000-00-00") and ($row['tanggal_p16'] != "")) ? date('Y-m-d', strtotime($row['tanggal_p16'])) : '' ?>" data-file-p16="<?= $row['file_p16']; ?>" data-id-instansi-penyidik="<?= $row['id_instansi_penyidik']; ?>" data-jaksa-terkait="<?= $row['jaksa_terkait']; ?>" data-status-berkas="<?= $row['status_berkas']; ?>" data-pidana-anak="<?= $row['pidana_anak']; ?>" class="btn btn-info text-white btnShowModal" data-toggle="tooltip" data-placement="bottom" title="Ubah">
															<i class="align-middle" data-feather="edit"></i>
														</a>
													</li>

													<li>
														<a href="#" onclick="hapus_data(<?= $row['id_berkas_perkara'] ?>)" class="btn btn-danger text-white" data-toggle="tooltip" data-placement="bottom" title="Hapus">
															<i class="align-middle" data-feather="trash"></i>
														</a>
													</li>

												<?php endif; ?>
											</div>
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

<?= $this->include('berkas-perkara/modal-views'); ?>

<script>
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

				var instansiPenyidik = this.api().column(5);
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

				var status = this.api().column(7);
				var statusSelect = $('<select class="filter form-control js-select-2"><option value="">Semua</option></select>')
					.appendTo('#statusSelect')
					.on('change', function() {
						var val = $(this).val();
						status.search(val ? '^' + $(this).val() + '$' : val, true, false).draw();
					});
				status.data().unique().sort().each(function(d, j) {
					statusSelect.append('<option value="' + d + '">' + d + '</option>');
				});
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

	});
</script>

<?= $this->endSection('content'); ?>