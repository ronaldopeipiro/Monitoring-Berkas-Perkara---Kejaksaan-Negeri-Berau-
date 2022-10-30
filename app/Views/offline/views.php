<?= $this->extend('layout-auth/template'); ?>

<?= $this->section('content-auth'); ?>

<main class="d-flex w-100" style="background: #eee; height: 100vh;">

	<div class="container d-flex flex-column">
		<div class="row vh-100">
			<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
				<div class="d-table-cell align-middle">

					<div class="card">
						<div class="card-body py-5">
							<div class="text-center">
								<img src="<?= base_url(); ?>/assets/img/offline-logo.png" style="width: 100px;" alt="">
								<h3 class="mt-5">
									Anda sedang offline ...
								</h3>
								<br>
								<a href="<?= base_url(); ?>" class="">
									<i class="fa fa-sync"></i> Muat Ulang
								</a>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

</main>

<?= $this->endSection('content-auth'); ?>