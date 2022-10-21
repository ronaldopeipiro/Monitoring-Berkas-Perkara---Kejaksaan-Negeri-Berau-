<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="<?= base_url() ?>">
			<span class="align-middle d-flex">
				<img src="<?= base_url() ?>/assets/img/logo.png" style="height: 55px; margin-top: 7px;" alt="logo">
				<span style="line-height: 20px; margin-top: 5px; margin-left: 5px; font-size: 11px;">
					APLIKASI MONITORING <br>
					BERKAS PERKARA <br>
					KEJAKSAAN NEGERI BERAU
				</span>
			</span>
		</a>
		<hr>
		<div class="text-center">
			<img src="<?= $user_foto ?>" style="width: 100px; height: 100px; object-fit: cover; object-position: top; border-radius: 50%;">
		</div>
		<span class="text-center mt-3 text-white">
			<?= $user_nama_lengkap; ?> <br>
			<i class="text-muted"><?= $user_username; ?></i>
		</span>
		<hr>

		<ul class="sidebar-nav">
			<li class="sidebar-item <?= $request->uri->getSegment(1) == '' ? 'active' : ''; ?>">
				<a class="sidebar-link" href="<?= base_url() ?>">
					<i class="align-middle" data-feather="home"></i>
					<span class="align-middle">Dashboard</span>
				</a>
			</li>

			<li class="sidebar-item <?= $request->uri->getSegment(1) == 'berkas-perkara' ? 'active' : ''; ?>">
				<a class="sidebar-link" href="<?= base_url() ?>/berkas-perkara">
					<i class="align-middle" data-feather="file-text"></i>
					<span class="align-middle">
						Berkas Perkara
					</span>
				</a>
			</li>

			<?php if ($user_level < 3) : ?>
				<li class="sidebar-item <?= $request->uri->getSegment(1) == 'data-master' ? 'active' : ''; ?>">
					<a data-target="#data-master" data-toggle="collapse" class="sidebar-link collapsed">
						<i class="align-middle" data-feather="layers"></i>
						<span class="align-middle">Data Master</span>
					</a>
					<ul id="data-master" class="sidebar-dropdown list-unstyled collapse <?= $request->uri->getSegment(1) == 'data-master' ? 'show' : ''; ?>" data-parent="#sidebar">
						<li class="sidebar-item <?= (($request->uri->getSegment(1) == 'data-master') and ($request->uri->getSegment(2) == 'jaksa')) ? 'active' : ''; ?>">
							<a class="sidebar-link" href="<?= base_url() ?>/data-master/jaksa">
								Data Jaksa
							</a>
						</li>
						<li class="sidebar-item <?= (($request->uri->getSegment(1) == 'data-master') and ($request->uri->getSegment(2) == 'instansi')) ? 'active' : ''; ?>">
							<a class="sidebar-link" href="<?= base_url() ?>/data-master/instansi">
								Data Instansi
							</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>

			<li class="sidebar-item <?= $request->uri->getSegment(1) == 'pengaturan' ? 'active' : ''; ?>">
				<a class="sidebar-link" href="<?= base_url() ?>/pengaturan">
					<i class="align-middle" data-feather="sliders"></i>
					<span class="align-middle">
						Pengaturan
					</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link btn-logout" href="<?= base_url() ?>/logout-user">
					<i class="align-middle" data-feather="log-out"></i>
					<span class="align-middle">Logout</span>
				</a>
			</li>

		</ul>

	</div>
</nav>