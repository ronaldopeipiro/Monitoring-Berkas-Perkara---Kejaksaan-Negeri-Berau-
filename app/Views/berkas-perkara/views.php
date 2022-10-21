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
								<div class="form-group">
									<label for="cariTanggalBerkas">Tanggal Berkas</label>
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
									<label for="cariTanggalP16">Tanggal P-16</label>
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
								<div id="instansiPenyidikSelect" style="font-size: 12px;"></div>
							</div>

							<div class="col-lg-1 mb-3">
								<label for="statusSelect">Status</label>
								<div id="statusSelect" style="font-size: 12px;"></div>
							</div>
						</div>
					</div>

					<div class="col-12">
						<!-- <a id="card-view-table" class="btn btn-success" href="#">CARD VIEW</a> -->
						<table class="table table-sm table-hover table-responsive-sm table-striped" id="data-table-custom" style="font-size: 12px;">
							<thead>
								<tr>
									<th>No.</th>
									<th>Tanggal Penerimaan</th>
									<th>Nomor Berkas</th>
									<th>Tanggal Berkas</th>
									<th>Nomor P16</th>
									<th>Tanggal P16</th>
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
									$tanggal_penerimaan = date_create($row['tanggal_penerimaan']);
									$tgl_hari_ini = date_create(date('Y-m-d'));
									$interval = date_diff($tanggal_penerimaan, $tgl_hari_ini);

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
											<?php if ($row['file_berkas'] != "") : ?>
												<a href="<?= base_url(); ?>/assets/berkas/<?= $row['file_berkas']; ?>" target="_blank">
													<?= $row['nomor_berkas']; ?>
												</a>
											<?php else : ?>
												<?= $row['nomor_berkas']; ?>
											<?php endif; ?>
										</td>
										<td>
											<?php if (($row['tanggal_berkas'] != "0000-00-00") and ($row['tanggal_berkas'] != "")) : ?>
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
											<?php if (($row['tanggal_p16'] != "0000-00-00") and ($row['tanggal_p16'] != "")) : ?>
												<?= date('d/m/Y', strtotime($row['tanggal_p16'])); ?>
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
													<a href="#" data-toggle="modal" data-target="#modalDetail" data-action="detail" data-title="Detail Data Berkas Perkara" data-id-berkas-perkara="<?= $row['id_berkas_perkara']; ?>" data-nomor-berkas="<?= $row['nomor_berkas']; ?>" data-tanggal-berkas="<?= (($row['tanggal_berkas'] != "0000-00-00") and ($row['tanggal_berkas'] != "")) ? date('d/m/Y', strtotime($row['tanggal_berkas'])) : '' ?>" data-tanggal-penerimaan="<?= date('d/m/Y', strtotime($row['tanggal_penerimaan'])); ?>" data-file-berkas="<?= ($row['file_berkas'] != "") ? base_url() . '/assets/berkas/' . $row['file_berkas'] : ''; ?>" data-nomor-spdp="<?= $row['nomor_spdp']; ?>" data-tanggal-spdp="<?= (($row['tanggal_spdp'] != "0000-00-00") and ($row['tanggal_spdp'] != "")) ? date('d/m/Y', strtotime($row['tanggal_spdp'])) : '' ?>" data-file-spdp="<?= ($row['file_spdp'] != "") ? base_url() . '/assets/berkas/' . $row['file_spdp'] : ''; ?>" data-nomor-p16="<?= $row['nomor_p16']; ?>" data-tanggal-p16="<?= (($row['tanggal_p16'] != "0000-00-00") and ($row['tanggal_p16'] != "")) ? date('d/m/Y', strtotime($row['tanggal_p16'])) : '' ?>" data-file-p16="<?= ($row['file_p16'] != "") ? base_url() . '/assets/berkas/' . $row['file_p16'] : ''; ?>" data-nomor-p17="<?= $row['nomor_p17']; ?>" data-tanggal-p17="<?= (($row['tanggal_p17'] != "0000-00-00") and ($row['tanggal_p17'] != "")) ? date('d/m/Y', strtotime($row['tanggal_p17'])) : '' ?>" data-file-p17="<?= ($row['file_p17'] != "") ? base_url() . '/assets/berkas/' . $row['file_p17'] : ''; ?>" data-nomor-sop-form="<?= $row['nomor_sop_form_02']; ?>" data-tanggal-sop-form="<?= (($row['tanggal_sop_form_02'] != "0000-00-00") and ($row['tanggal_sop_form_02'] != "")) ? date('d/m/Y', strtotime($row['tanggal_sop_form_02'])) : '' ?>" data-file-sop-form="<?= ($row['file_sop_form_02'] != "") ? base_url() . '/assets/berkas/' . $row['file_sop_form_02'] : ''; ?>" data-nomor-surat-pengembalian-spdp="<?= $row['nomor_surat_pengembalian_spdp']; ?>" data-tanggal-surat-pengembalian-spdp="<?= (($row['tanggal_surat_pengembalian_spdp'] != "0000-00-00") and ($row['tanggal_sop_form_02'] != "")) ? date('d/m/Y', strtotime($row['tanggal_surat_pengembalian_spdp'])) : '' ?>" data-file-surat-pengembalian-spdp="<?= ($row['file_surat_pengembalian_spdp'] != "") ? base_url() . '/assets/berkas/' . $row['file_surat_pengembalian_spdp'] : ''; ?>" data-instansi-penyidik="<?= $instansi_penyidik->nama_instansi; ?>" data-jaksa-terkait="<?= $jaksa_terkait; ?>" data-status-berkas="<?= $row['status_berkas']; ?>" data-pidana-anak="<?= $row['pidana_anak']; ?>" data-create-datetime="<?= (($row['create_datetime'] != "0000-00-00") and ($row['create_datetime'] != "")) ? ' pada ' . date('d/m/Y H:i:s', strtotime($row['create_datetime'])) : '' ?>" data-update-datetime="<?= (($row['update_datetime'] != "0000-00-00") and ($row['update_datetime'] != "")) ? ' pada ' . date('d/m/Y H:i:s', strtotime($row['update_datetime'])) : '' ?>" data-user-create="<?= $nama_user_create; ?>" data-user-update="<?= $nama_user_update; ?>" data-status-notifikasi="<?= $status_notifikasi; ?>" data-status-perkara="<?= $row['status']; ?>" data-interval-hari="<?= $interval->days; ?>" class="btn btn-success text-white btnShowModalDetail" data-toggle="tooltip" data-placement="bottom" title="Detail">
														<i class="align-middle" data-feather="list"></i>
													</a>
												</li>

												<?php if (($user_level < 3) or ($user_id == $row['id_user_create'])) : ?>

													<li>
														<a href="#" data-toggle="modal" data-target="#modalInput" data-action="ubah" data-title="Ubah Data Berkas Perkara" data-id-berkas-perkara="<?= $row['id_berkas_perkara']; ?>" data-nomor-berkas="<?= $row['nomor_berkas']; ?>" data-tanggal-berkas="<?= date('Y-m-d', strtotime($row['tanggal_berkas'])); ?>" data-file-berkas="<?= $row['file_berkas']; ?>" data-tanggal-penerimaan="<?= date('Y-m-d', strtotime($row['tanggal_penerimaan'])); ?>" data-nomor-p16="<?= $row['nomor_p16']; ?>" data-tanggal-p16="<?= ($row['tanggal_p16'] != "0000-00-00") ? date('Y-m-d', strtotime($row['tanggal_p16'])) : ""; ?>" data-file-p16="<?= $row['file_p16']; ?>" data-id-instansi-penyidik="<?= $row['id_instansi_penyidik']; ?>" data-jaksa-terkait="<?= $row['jaksa_terkait']; ?>" data-status-berkas="<?= $row['status_berkas']; ?>" data-pidana-anak="<?= $row['pidana_anak']; ?>" class="btn btn-info text-white btnShowModal" data-toggle="tooltip" data-placement="bottom" title="Ubah">
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
					<input type="hidden" id="file_berkas_lama" name="file_berkas_lama" value="">
					<input type="hidden" id="file_p16_lama" name="file_p16_lama" value="">

					<div class="row">

						<div class="col-lg-6 mb-3 mb-lg-0">
							<div class="row">
								<label for="tanggal_penerimaan" class="col-sm-12 col-form-label">
									Tanggal Penerimaan
									<small class="text-danger">(*Wajib diisi !)</small>
								</label>
								<div class="col-sm-12">
									<input type="date" class="form-control" id="tanggal_penerimaan" name="tanggal_penerimaan" placeholder="0" value="<?= date('Y-m-d'); ?>">
								</div>
							</div>
						</div>

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
											<small class="text-info text-file-update">
												(*Jika Ada)
											</small>
										</label>
										<div class="col-sm-12">
											<input type="file" data-default-file="" name="file_berkas" id="file_berkas" class="dropify" data-height="100" data-show-remove="true" data-show-loader="true" data-show-errors="true" data-errors-position="outside" style="font-size: 12px;" />
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
											<small class="text-info text-file-update">
												(*Jika Ada)
											</small>
										</label>
										<div class="col-sm-12">
											<input type="file" data-default-file="" name="file_p16" id="file_p16" class="dropify" data-height="100" data-show-remove="true" data-show-loader="true" data-show-errors="true" data-errors-position="outside" style="font-size: 12px;" />
										</div>
									</div>
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

					<div class="row">
						<div class="col-lg-6">
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
						</div>

						<div class="col-lg-6">
							<div class="form-group row mb-3">
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
									<a href="" id="detail_fileSpdp" target="_blank">
										Unduh / Lihat file SPDP
									</a>
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
										Unduh / Lihat file berkas
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
										Unduh / Lihat file P-16
									</a>
								</td>
							</tr>

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
									<a href="" id="detail_fileP17" target="_blank">
										Unduh / Lihat file P-17
									</a>
								</td>
							</tr>

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
									<a href="" id="detail_fileSopForm" target="_blank">
										Unduh / Lihat file SOP Form 02
									</a>
								</td>
							</tr>

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
									<a href="" id="detail_fileSuratPengembalianSpdp" target="_blank">
										Unduh / Lihat file Surat Pengembalian SPDP
									</a>
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
				</div>

			</div>

		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$(function() {
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

					$(".text-file-update").html(`(*Pilih jika ingin menambah atau mengubah file !)`);

					var idBerkasPerkara = $(this).data('idBerkasPerkara');
					var tanggalPenerimaan = $(this).data('tanggalPenerimaan');
					var idInstansiPenyidik = $(this).data('idInstansiPenyidik');
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
					$('#modalInput #tanggal_berkas').val(tanggalBerkas);
					$('#modalInput #nomor_berkas').val(nomorBerkas);
					$('#modalInput #file_berkas_lama').val(fileBerkas);
					$('#modalInput #tanggal_p16').val(tanggalP16);
					$('#modalInput #nomor_p16').val(nomorP16);
					$('#modalInput #file_p16_lama').val(fileP16);
					$('#modalInput #status_berkas').val(statusBerkas).trigger('change');
					$('#modalInput #pidana_anak').val(pidanaAnak).trigger('change');

					if (fileBerkas != "") {
						$('#modalInput #file_berkas').data("default-file", base_url + "/assets/berkas/" + fileBerkas);
						// $('#modalInput #file_berkas').dropify();
					}

					if (fileP16 != "") {
						$('#modalInput #file_p16').data("default-file", base_url + "/assets/berkas/" + fileP16);
						// $('#modalInput #file_p16').dropify();
					}

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

				$('#modalDetail #judulFormDetail').text(title);
				$('#modalDetail #detail_idBerkasPerkara').text(idBerkasPerkara);

				$('#modalDetail #detail_tanggalPenerimaan').text(tanggalPenerimaan);
				$('#modalDetail #detail_tanggalBerkas').text(tanggalBerkas);
				$('#modalDetail #detail_nomorBerkas').text(nomorBerkas);
				if (fileBerkas != "") {
					$('#modalDetail #detail_fileBerkas').attr("href", fileBerkas);
				} else {
					$('#modalDetail #detail_fileBerkas').hide();
				}

				$('#modalDetail #detail_tanggalSpdp').text(tanggalSpdp);
				$('#modalDetail #detail_nomorSpdp').text(nomorSpdp);
				if (fileSpdp != "") {
					$('#modalDetail #detail_fileSpdp').attr("href", fileSpdp);
				} else {
					$('#modalDetail #detail_fileSpdp').hide();
				}

				$('#modalDetail #detail_tanggalP16').text(tanggalP16);
				$('#modalDetail #detail_nomorP16').text(nomorP16);
				if (fileP16 != "") {
					$('#modalDetail #detail_fileP16').attr("href", fileP16);
				} else {
					$('#modalDetail #detail_fileP16').hide();
				}

				$('#modalDetail #detail_tanggalP17').text(tanggalP17);
				$('#modalDetail #detail_nomorP17').text(nomorP17);
				if (fileP17 != "") {
					$('#modalDetail #detail_fileP17').attr("href", fileP17);
				} else {
					$('#modalDetail #detail_fileP17').hide();
				}

				$('#modalDetail #detail_tanggalSopForm').text(tanggalSopForm);
				$('#modalDetail #detail_nomorSopForm').text(nomorSopForm);
				if (fileSopForm != "") {
					$('#modalDetail #detail_fileSopForm').attr("href", fileSopForm);
				} else {
					$('#modalDetail #detail_fileSopForm').hide();
				}

				$('#modalDetail #detail_tanggalSuratPengembalianSpdp').text(tanggalSuratPengembalianSpdp);
				$('#modalDetail #detail_nomorSuratPengembalianSpdp').text(nomorSuratPengembalianSpdp);
				if (fileSuratPengembalianSpdp != "") {
					$('#modalDetail #detail_fileSuratPengembalianSpdp').attr("href", fileSuratPengembalianSpdp);
				} else {
					$('#modalDetail #detail_fileSuratPengembalianSpdp').hide();
				}

				$('#modalDetail #detail_instansiPenyidik').text(instansiPenyidik);
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

			$("#formInput").submit(function(e) {
				e.preventDefault();

				let formData = new FormData();
				var action = $('#action').val();
				var id_user = $('#id_user').val();
				formData.append('id_user', id_user);

				if (action == "tambah") {
					var urlPost = base_url + "/berkas-perkara/add";

					var tanggal_penerimaan = $('#tanggal_penerimaan').val();
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

		var filterTanggalBerkas = (function(oSettings, aData, iDataIndex) {
			var dateStart = parseDateValue(start_date);
			var dateEnd = parseDateValue(end_date);
			var evalDate = parseDateValue(aData[3]);
			if ((isNaN(dateStart) && isNaN(dateEnd)) ||
				(isNaN(dateStart) && evalDate <= dateEnd) ||
				(dateStart <= evalDate && isNaN(dateEnd)) ||
				(dateStart <= evalDate && evalDate <= dateEnd)) {
				return true;
			}
			return false;
		});

		var filterTanggalP16 = (function(oSettings, aData, iDataIndex) {
			var dateStart = parseDateValue(start_date);
			var dateEnd = parseDateValue(end_date);
			var evalDate = parseDateValue(aData[5]);
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

				var instansiPenyidik = this.api().column(6);
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

				var status = this.api().column(8);
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

		//konfigurasi daterangepicker pada input dengan id cariTanggalBerkas
		$('#cariTanggalBerkas').daterangepicker({
			autoUpdateInput: false
		});

		//menangani proses saat apply date range
		$('#cariTanggalBerkas').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
			start_date = picker.startDate.format('DD/MM/YYYY');
			end_date = picker.endDate.format('DD/MM/YYYY');
			$.fn.dataTableExt.afnFiltering.push(filterTanggalBerkas);
			$dTable.draw();
		});

		$('#cariTanggalBerkas').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
			start_date = '';
			end_date = '';
			$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(filterTanggalBerkas, 1));
			$dTable.draw();
		});


		//konfigurasi daterangepicker pada input dengan id cariTanggalPenerimaan
		$('#cariTanggalPenerimaan').daterangepicker({
			autoUpdateInput: false
		});

		//menangani proses saat apply date range
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


		//konfigurasi daterangepicker pada input dengan id cariTanggalP16
		$('#cariTanggalP16').daterangepicker({
			autoUpdateInput: false
		});

		//menangani proses saat apply date range
		$('#cariTanggalP16').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
			start_date = picker.startDate.format('DD/MM/YYYY');
			end_date = picker.endDate.format('DD/MM/YYYY');
			$.fn.dataTableExt.afnFiltering.push(filterTanggalP16);
			$dTable.draw();
		});

		$('#cariTanggalP16').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
			start_date = '';
			end_date = '';
			$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(filterTanggalP16, 1));
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