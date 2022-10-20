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

							<!-- <div class="col-lg-3 mb-3">
								<div class="form-group">
									<label for="tanggalBerkasSelect">Tanggal Berkas</label>
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
									<label for="tanggalP16Select">Tanggal P-16</label>
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
							</div> -->

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
									<th>Nomor Berkas</th>
									<th>Tanggal Berkas</th>
									<th>Nomor P16</th>
									<th>Tanggal P16</th>
									<th>Instansi Penyidik</th>
									<th>Instansi Pelaksana Penyidikan</th>
									<th>Jaksa Terkait</th>
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

									$array_jaksa_terkait = $row['jaksa_terkait'];
									$data_jaksa_terkait = $db->query("SELECT * FROM user WHERE id_user IN ($array_jaksa_terkait) ORDER BY nama_lengkap ASC ");

									$jaksa_terkait = "";
									foreach ($data_jaksa_terkait->getResult('array') as $jt) {
										$jaksa_terkait .= "<span class='badge btn-primary'>" . $jt['nama_lengkap'] . "</span> <br>";
									}

									?>

									<tr>
										<td class="text-center"><?= $no++; ?>.</td>
										<td>
											<?php if ($row['file_berkas'] != "") : ?>
												<a href="<?= base_url(); ?>/assets/berkas/<?= $row['file_berkas']; ?>" target="_blank">
													<?= $row['nomor_berkas']; ?>
												</a>
											<?php else : ?>
												<?= $row['nomor_berkas']; ?>
											<?php endif; ?>
										</td>
										<td>
											<?php if ($row['tanggal_berkas'] != "0000-00-00") : ?>
												<?= date('d/m/Y', strtotime($row['tanggal_berkas'])); ?>
											<?php endif; ?>
										</td>
										<td>
											<?php if ($row['file_p16'] != "") : ?>
												<a href="<?= base_url(); ?>/assets/berkas/<?= $row['file_p16']; ?>" target="_blank">
													<?= $row['nomor_p16']; ?>
												</a>
											<?php else : ?>
												<?= $row['nomor_p16']; ?>
											<?php endif; ?>
										</td>
										<td>
											<?php if ($row['tanggal_p16'] != "0000-00-00") : ?>
												<?= date('d/m/Y', strtotime($row['tanggal_p16'])); ?>
											<?php endif; ?>
										</td>
										<td>
											<?= $instansi_penyidik->nama_instansi; ?>
										</td>
										<td>
											<?= $instansi_pelaksana_penyidikan->nama_instansi; ?>
										</td>
										<td class="text-left">
											<?= $jaksa_terkait; ?>
										</td>
										<td class="text-center">
											<?= $row['status']; ?>
										</td>
										<td class="table-action">
											<div class="list-unstyled d-flex align-items-center justify-content-center">
												<li>
													<a href="#" data-toggle="modal" data-target="#modalDetail" data-action="detail" data-title="Detail Data Berkas Perkara" data-id-berkas-perkara="<?= $row['id_berkas_perkara']; ?>" data-nomor-berkas="<?= $row['nomor_berkas']; ?>" data-tanggal-berkas="<?= date('d/m/Y', strtotime($row['tanggal_berkas'])); ?>" data-file-berkas="<?= ($row['file_berkas'] != "") ? base_url() . '/assets/berkas/' . $row['file_berkas'] : ''; ?>" data-nomor-p16="<?= $row['nomor_p16']; ?>" data-tanggal-p16="<?= ($row['tanggal_p16'] != "0000-00-00") ? date('d/m/Y', strtotime($row['tanggal_p16'])) : '' ?>" data-file-p16="<?= ($row['file_p16'] != "") ? base_url() . '/assets/berkas/' . $row['file_p16'] : ''; ?>" data-instansi-penyidik="<?= $instansi_penyidik->nama_instansi; ?>" data-instansi-pelaksana-penyidikan="<?= $instansi_pelaksana_penyidikan->nama_instansi; ?>" data-jaksa-terkait="<?= $jaksa_terkait; ?>" data-pidana-anak="<?= $row['pidana_anak']; ?>" class="btn btn-success d-flex text-white btnShowModalDetail" data-toggle="tooltip" data-placement="bottom" title="Detail">
														<i class="align-middle" data-feather="list"></i>
													</a>
												</li>

												<?php if (($user_level < 3) or ($user_id == $row['id_user_create'])) : ?>

													<li>
														<a href="#" data-toggle="modal" data-target="#modalInput" data-action="ubah" data-title="Ubah Data Berkas Perkara" data-id-berkas-perkara="<?= $row['id_berkas_perkara']; ?>" data-nomor-berkas="<?= $row['nomor_berkas']; ?>" data-tanggal-berkas="<?= date('Y-m-d', strtotime($row['tanggal_berkas'])); ?>" data-nomor-p16="<?= $row['nomor_p16']; ?>" data-tanggal-p16="<?= ($row['tanggal_p16'] != "0000-00-00") ? date('Y-m-d', strtotime($row['tanggal_p16'])) : ""; ?>" data-instansi-penyidik="<?= $row['id_instansi_penyidik']; ?>" data-instansi-pelaksana-penyidikan="<?= $row['id_instansi_pelaksana_penyidikan']; ?>" data-jaksa-terkait="<?= $row['jaksa_terkait']; ?>" data-pidana-anak="<?= $row['pidana_anak']; ?>" class="btn btn-info d-flex text-white btnShowModal" data-toggle="tooltip" data-placement="bottom" title="Ubah">
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

					<div class="form-check mb-3">
						<input class="form-check-input" type="checkbox" id="pidana_anak" name="pidana_anak" value="">
						<label class="form-check-label" for="pidana_anak">Pidana Anak</label>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<div class="col-lg-8 mb-3 mb-lg-0">
									<div class="row">
										<label for="nomor_berkas" class="col-sm-12 col-form-label">
											Nomor Berkas <br>
											<small class="text-danger">(*Wajib diisi !)</small>
										</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" id="nomor_berkas" name="nomor_berkas" placeholder="Masukkan Nomor Berkas ..." value="">
										</div>
									</div>
								</div>

								<div class="col-lg-4 mb-3 mb-lg-0">
									<div class="row">
										<label for="tanggal_berkas" class="col-sm-12 col-form-label">
											Tanggal Berkas <br>
											<small class="text-danger">(*Wajib diisi !)</small>
										</label>
										<div class="col-sm-12">
											<input type="date" class="form-control" id="tanggal_berkas" name="tanggal_berkas" placeholder="0" value="">
										</div>
									</div>
								</div>

								<div class="col-lg-12 mb-3 mb-lg-0 mt-3">
									<div class="form-group row mb-2">
										<label for="file_berkas" class="col-sm-12 col-form-label">
											File Berkas
											<small class="text-info">
												(*Jika Ada)
											</small>
											<small class="text-danger">
												(*Maks 4 MB)
											</small>
										</label>
										<div class="col-sm-12">
											<input type="file" name="file_berkas" id="file_berkas" class="dropify" data-height="100" data-max-file-size="4M" data-show-remove="true" data-show-loader="true" data-show-errors="true" data-errors-position="outside" data-max-file-size-preview="4M" style="font-size: 12px;" />
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
											Nomor P-16 <br>
											<small class="text-info">(*Jika ada)</small>
										</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" id="nomor_p16" name="nomor_p16" placeholder="Masukkan Nomor P-16 ..." value="">
										</div>
									</div>
								</div>

								<div class="col-lg-4 mb-3 mb-lg-0">
									<div class="row">
										<label for="tanggal_p16" class="col-sm-12 col-form-label">
											Tanggal P-16 <br>
											<small class="text-info">(*Jika ada)</small>
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
											<small class="text-info">
												(*Jika Ada)
											</small>
											<small class="text-danger">
												(*Maks 4 MB)
											</small>
										</label>
										<div class="col-sm-12">
											<input type="file" name="file_p16" id="file_p16" class="dropify" data-height="100" data-max-file-size="4M" data-show-remove="true" data-show-loader="true" data-show-errors="true" data-errors-position="outside" data-max-file-size-preview="4M" style="font-size: 12px;" />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6 mb-3 mb-lg-0">
							<div class="form-group row mb-3">
								<label for="id_instansi_penyidik" class="col-sm-12 col-form-label">
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
						</div>

						<div class="col-lg-6 mb-3 mb-lg-0">
							<div class="form-group row mb-3">
								<label for="id_instansi_pelaksana_penyidikan" class="col-sm-12 col-form-label">
									Instansi Pelaksana Penyidikan
									<small class="text-danger">(*Wajib diisi !)</small>
								</label>
								<div class="col-sm-12">
									<select name="id_instansi_pelaksana_penyidikan" id="id_instansi_pelaksana_penyidikan" class="form-control js-select-2">
										<option value=""></option>
										<?php foreach ($list_instansi as $instansi) : ?>
											<option value="<?= $instansi['id_instansi']; ?>">
												<?= $instansi['nama_instansi']; ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row mb-3">
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

					<div class="form-group row mb-3">
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
					<div class="col-12">
						<table class="table-sm table-borderless table-responsive">
							<tr>
								<td>Pidana Anak</td>
								<td>:</td>
								<td>
									<span id="detail_pidanaAnak"></span>
								</td>
							</tr>
							<tr>
								<td>Tanggal Berkas</td>
								<td>:</td>
								<td>
									<span id="detail_tanggalBerkas"></span>
								</td>
							</tr>
							<tr>
								<td>Nomor Berkas</td>
								<td>:</td>
								<td>
									<span id="detail_nomorBerkas"></span>
								</td>
							</tr>
							<tr>
								<td>File Berkas</td>
								<td>:</td>
								<td>
									<a href="" id="detail_fileBerkas" target="_blank">
										Lihat file berkas
									</a>
								</td>
							</tr>
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
									<a href="" id="detail_fileP16" target="_blank">
										Lihat file P-16
									</a>
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
								<td>Instansi Pelaksana Penyidikan</td>
								<td>:</td>
								<td>
									<span id="detail_instansiPelaksanaPenyidikan"></span>
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
								<td>Status Pengiriman Notifikasi</td>
								<td>:</td>
								<td>
									<span id="detail_notifikasiSend"></span>
								</td>
							</tr>
						</table>
					</div>
				</div>

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
			$(document).on('click', '.btnShowModal', function() {
				var title = $(this).data('title');
				var action = $(this).data('action');

				$('#modalInput #judulForm').text(title);
				$('#modalInput #action').val(action);

				if (action == "tambah") {
					$("form").trigger("reset");
				} else if (action == "ubah") {
					$("form").trigger("reset");
					var id_berkas_perkara = $(this).data('idBerkasPerkara');
					var jaksaTerkait = $(this).data('jaksaTerkait');

					$('#modalInput #id_berkas_perkara').val(id_berkas_perkara);
					// $('#modalInput #jaksa_terkait').select2("val", [jaksaTerkait]).trigger('change');
					$.each(jaksaTerkait.split(","), function(i, e) {
						$("#modalInput #jaksa_terkait option[value='" + e + "']").prop("selected", "true").trigger('change');
					});
				}
			});

			$("#modalDetail").appendTo('body');

			$(document).on('click', '.btnShowModalDetail', function() {

				var title = $(this).data('title');
				var action = $(this).data('action');
				var idBerkasPerkara = $(this).data('idBerkasPerkara');
				var tanggalBerkas = $(this).data('tanggalBerkas');
				var nomorBerkas = $(this).data('nomorBerkas');
				var fileBerkas = $(this).data('fileBerkas');
				var tanggalP16 = $(this).data('tanggalP16');
				var nomorP16 = $(this).data('nomorP16');
				var fileP16 = $(this).data('fileP16');
				var instansiPenyidik = $(this).data('instansiPenyidik');
				var instansiPelaksanaPenyidikan = $(this).data('instansiPelaksanaPenyidikan');
				var dataJaksaTerkait = $(this).data('jaksaTerkait');
				var jaksaTerkait = dataJaksaTerkait.replaceAll(`'`, `"`);
				var pidanaAnak = $(this).data('pidanaAnak');
				var statusBerkas = $(this).data('statusBerkas');
				var status = $(this).data('status');
				var notifikasiSend = $(this).data('notifikasiSend');

				$('#modalDetail #judulFormDetail').text(title);
				$('#modalDetail #detail_idBerkasPerkara').text(idBerkasPerkara);

				$('#modalDetail #detail_nomorBerkas').text(nomorBerkas);
				$('#modalDetail #detail_tanggalBerkas').text(tanggalBerkas);
				if (fileBerkas != "") {
					$('#modalDetail #detail_fileBerkas').attr("href", fileBerkas);
				} else {
					$('#modalDetail #detail_fileBerkas').hide();
				}

				$('#modalDetail #detail_nomorP16').text(nomorP16);
				$('#modalDetail #detail_tanggalP16').text(tanggalP16);

				if (fileP16 != "") {
					$('#modalDetail #detail_fileP16').attr("href", fileP16);
				} else {
					$('#modalDetail #detail_fileP16').hide();
				}

				$('#modalDetail #detail_instansiPenyidik').text(instansiPenyidik);
				$('#modalDetail #detail_instansiPelaksanaPenyidikan').text(instansiPelaksanaPenyidikan);
				$('#modalDetail #detail_jaksaTerkait').html(jaksaTerkait);
				$('#modalDetail #detail_pidanaAnak').text(pidanaAnak);
				$('#modalDetail #detail_statusBerkas').text(statusBerkas);
				$('#modalDetail #detail_status').text(status);
				$('#modalDetail #detail_notifikasiSend').text(notifikasiSend);
			});

			$("#formInput").submit(function(e) {
				e.preventDefault();

				let formData = new FormData();
				var action = $('#action').val();
				var id_user = $('#id_user').val();
				formData.append('id_user', id_user);

				if (action == "tambah") {
					var urlPost = base_url + "/berkas-perkara/add";

					var pidana_anak = $('#pidana_anak');
					if (pidana_anak.checked == true) {
						pidana_anak = "Ya";
					} else {
						pidana_anak = "Tidak";
					}

					var nomor_berkas = $('#nomor_berkas').val();
					var tanggal_berkas = $('#tanggal_berkas').val();
					var file_berkas = $('#file_berkas').prop('files')[0];
					var nomor_p16 = $('#nomor_p16').val();
					var tanggal_p16 = $('#tanggal_p16').val();
					var file_p16 = $('#file_p16').prop('files')[0];
					var status_berkas = $('#status_berkas').val();
					var id_instansi_penyidik = $('#id_instansi_penyidik').val();
					var id_instansi_pelaksana_penyidikan = $('#id_instansi_pelaksana_penyidikan').val();
					var jaksa_terkait = $('#jaksa_terkait').val();

					formData.append('pidana_anak', pidana_anak);
					formData.append('nomor_berkas', nomor_berkas);
					formData.append('tanggal_berkas', tanggal_berkas);
					formData.append('file_berkas', file_berkas);
					formData.append('nomor_p16', nomor_p16);
					formData.append('tanggal_p16', tanggal_p16);
					formData.append('file_p16', file_p16);
					formData.append('status_berkas', status_berkas);
					formData.append('id_instansi_penyidik', id_instansi_penyidik);
					formData.append('id_instansi_pelaksana_penyidikan', id_instansi_pelaksana_penyidikan);
					formData.append('jaksa_terkait', jaksa_terkait);

				} else if (action == "ubah") {
					var urlPost = base_url + "/berkas-perkara/edit";

					var pidana_anak = $('#pidana_anak').val();
					var nomor_berkas = $('#nomor_berkas').val();
					var tanggal_berkas = $('#tanggal_berkas').val();
					var file_berkas = $('#file_berkas').prop('files')[0];
					var nomor_p16 = $('#nomor_p16').val();
					var tanggal_p16 = $('#tanggal_p16').val();
					var file_p16 = $('#file_p16').prop('files')[0];
					var status_berkas = $('#status_berkas').val();
					var id_instansi_penyidik = $('#id_instansi_penyidik').val();
					var id_instansi_pelaksana_penyidikan = $('#id_instansi_pelaksana_penyidikan').val();
					var jaksa_terkait = $('#jaksa_terkait').val();

					formData.append('pidana_anak', pidana_anak);
					formData.append('nomor_berkas', nomor_berkas);
					formData.append('tanggal_berkas', tanggal_berkas);
					formData.append('file_berkas', file_berkas);
					formData.append('nomor_p16', nomor_p16);
					formData.append('tanggal_p16', tanggal_p16);
					formData.append('file_p16', file_p16);
					formData.append('status_berkas', status_berkas);
					formData.append('id_instansi_penyidik', id_instansi_penyidik);
					formData.append('id_instansi_pelaksana_penyidikan', id_instansi_pelaksana_penyidikan);
					formData.append('jaksa_terkait', jaksa_terkait);
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

<?= $this->endSection('content'); ?>