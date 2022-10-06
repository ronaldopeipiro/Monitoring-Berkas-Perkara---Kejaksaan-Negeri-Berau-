<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid p-0">
	<div class="row row-deck row-cards">

		<div class="col-lg-12 mb-4">
			<div class="card h-100">

				<div class="card-header">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="card-title">
							Data ULPL
						</h3>
						<div>
							<?php if ($user_level <= 2) : ?>
								<a href="#" class="btn btn-success text-white btnShowModal" data-toggle="modal" data-target="#modalInput" data-title="Tambah Data ULPL" data-action="tambah" data-toggle="tooltip" data-placement="bottom" title="Tambah Data">
									<i class="align-middle" data-feather="plus"></i> Tambah
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="card-body border-bottom pb-1 row">

					<div class="col-12">
						<table class="table table-sm table-hover table-responsive-sm table-striped" id="data-table-custom" style="font-size: 12px;">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama ULPL</th>
									<th>Keterangan</th>
									<th>Create at</th>
									<th>Update at</th>
									<?php if ($user_level <= 2) : ?>
										<th>Aksi</th>
									<?php endif; ?>
								</tr>
							</thead>

							<tbody>
								<?php $no = 1; ?>
								<?php foreach ($data_ulpl as $row) : ?>
									<tr>
										<td class="text-center"><?= $no++; ?>.</td>
										<td class="text-left" style="width: 25%;">
											<?= $row['nama_ulpl']; ?>
										</td>
										<td class="text-left" style="width: 35%;">
											<?= $row['keterangan']; ?>
										</td>
										<td>
											<?= strftime('%d/%m/%Y %H:%M:%S', strtotime($row['create_datetime'])); ?>
										</td>
										<td>
											<?= strftime('%d/%m/%Y %H:%M:%S', strtotime($row['update_datetime'])); ?>
										</td>
										<?php if ($user_level <= 2) : ?>
											<td class="table-action">
												<div class="list-unstyled d-flex align-items-center justify-content-center">
													<li>
														<a href="#" class="btn btn-warning text-white btnShowModal" data-toggle="modal" data-target="#modalInput" data-action="ubah" data-title="Ubah Data ULPL" data-id="<?= $row['id_ulpl']; ?>" data-namaulpl="<?= $row['nama_ulpl']; ?>" data-keterangan="<?= $row['keterangan']; ?>" class="btn btn-info d-flex text-white" data-toggle="tooltip" data-placement="bottom" title="Ubah">
															<i class="align-middle" data-feather="edit"></i>
														</a>
													</li>
													<li>
														<a href="#" onclick="hapus_data(<?= $row['id_ulpl'] ?>)" class="btn btn-danger text-white" data-toggle="tooltip" data-placement="bottom" title="Hapus">
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
	<div class="modal-dialog modal-dialog-centered" role="document">
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
					<input type="hidden" id="id_ulpl" name="id_ulpl" value="">

					<div class="form-group row mb-2">
						<label for="nama_ulpl" class="col-sm-12 col-form-label">
							Nama ULPL
						</label>
						<div class="col-sm-12">
							<input type="text" autofocus class="form-control" id="nama_ulpl" name="nama_ulpl" placeholder="Masukkan nama ULPL ...">
						</div>
					</div>

					<div class="form-group row mb-2">
						<label for="keterangan" class="col-sm-12 col-form-label">
							Keterangan
						</label>
						<div class="col-sm-12">
							<textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Masukkan keterangan ..."></textarea>
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
					var id_ulpl = $(this).data('id');
					var namaulpl = $(this).data('namaulpl');
					var keterangan = $(this).data('keterangan');

					$('#modalInput #id_ulpl').val(id_ulpl);
					$('#modalInput #nama_ulpl').val(namaulpl);
					$('#modalInput #keterangan').val(keterangan);
				}
			});

			$("#formInput").submit(function(e) {
				e.preventDefault();

				var action = $('#action').val();

				if (action == "tambah") {
					var urlPost = base_url + "/data-master/ulpl/add";
				} else if (action == "ubah") {
					var urlPost = base_url + "/data-master/ulpl/edit";
				}

				var id_ulpl = $('#id_ulpl').val();
				var nama_ulpl = $('#nama_ulpl').val();
				var keterangan = $('#keterangan').val();

				$.ajax({
					type: "POST",
					url: urlPost,
					dataType: "JSON",
					data: {
						id_ulpl: id_ulpl,
						nama_ulpl: nama_ulpl,
						keterangan: keterangan,
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

	function hapus_data(id_ulpl) {
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
						id_ulpl: id_ulpl
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
			<?php if ($user_level == 1) : ?> "dom": 'lBfrtip',
			<?php endif; ?> "paging": true,
			"responsive": true,
			"searching": true,
			"deferRender": true,
			"lengthMenu": [
				[10, 25, 50, 100, -1],
				['10', '25', '50', '100', 'Semua']
			],
			"buttons": [{
					extend: 'excelHtml5',
					filename: 'DATA ULPL - UPDK KAPUAS - update ' + tanggalHariIni,
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
					filename: 'DATA ULPL - UPDK KAPUAS - update ' + tanggalHariIni,
					text: 'Export PDF (*pdf)',
					message: 'DATA ULPL',
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
						doc.defaultStyle.fontSize = 7;
						doc.styles.tableHeader.fontSize = 7;
						doc.styles.title.fontSize = 9;
						// Remove spaces around page title
						doc.content[0].text = doc.content[0].text.trim();
						// Create a footer
						doc['footer'] = (function(page, pages) {
							return {
								columns: [
									'Data ULPL',
									{
										// This is the right column
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

	});
</script>

<?= $this->endSection('content'); ?>