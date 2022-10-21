	<nav class="navbar navbar-expand navbar-light navbar-bg modal-static">
		<a class="sidebar-toggle js-sidebar-toggle">
			<i class="hamburger align-self-center mt-2"></i>
		</a>

		<div class="navbar-collapse collapse">
			<ul class="navbar-nav navbar-align">
				<li class="nav-item dropdown" style="margin-left: 100px;">
					<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
						<i class="align-middle" data-feather="settings"></i>
					</a>

					<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
						<img src="<?= $user_foto; ?>" class="avatar img-fluid me-1" style="height: 40px; height: 40px; object-fit: cover; object-position: top; border-radius: 50%;" alt="User" />
						<span class="text-dark"><?= $user_nama_lengkap; ?></span>
					</a>

					<div class="dropdown-menu dropdown-menu-right" style="width: 180px;">
						<div class="dropdown-divider"></div>
						<div class="text-center d-block">
							<img src="<?= $user_foto; ?>" class="img-fluid me-1" style="width: 100px; height: 100px; object-fit: cover; object-position: top; border-radius: 50%;" alt="User" />
							<div>
								<span class="text-dark"><?= $user_nama_lengkap; ?></span> <br>
								<small><?= $user_username; ?></small>
							</div>
							<hr>
						</div>

						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?= base_url() ?>/pengaturan">
							<i class="align-middle me-1" data-feather="settings"></i> Pengaturan
						</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item btn-logout" href="<?= base_url() ?>/logout-user">
							<i class="align-middle me-1" data-feather="user"></i> Keluar
						</a>
						<div class="dropdown-divider"></div>
						<div class="dropdown-divider"></div>
					</div>
				</li>

			</ul>
		</div>
	</nav>