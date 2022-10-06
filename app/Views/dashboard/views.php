<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php
function rupiah($angka)
{
	$hasil_rupiah = "Rp. " . number_format($angka, 0, ',', '.') . ',-';
	return $hasil_rupiah;
}

$jumlah_berkas_perkara = $db->query("SELECT * FROM berkas_perkara")->getNumRows();
$jumlah_pengantar_berkas = $db->query("SELECT * FROM pengantar_berkas")->getNumRows();
$jumlah_instansi = $db->query("SELECT * FROM instansi WHERE aktif='Y' ")->getNumRows();
$jumlah_jaksa = $db->query("SELECT * FROM user WHERE id_level='3' AND aktif='Y'")->getNumRows();
?>

<div class="container-fluid p-0">

	<div class="row mb-2 mb-xl-3">
		<div class="col-auto d-none d-sm-block">
			<h3> <?= $title; ?></h3>
		</div>

		<div class="col-auto ml-auto text-right mt-n1">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
					<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
				</ol>
			</nav>
		</div>
	</div>

	<div class="row">

		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="d-block d-lg-flex justify-content-start align-items-center">
						<div class="mr-3">
							<img src="<?= base_url(); ?>/assets/img/logo.png" style="height: 100px;" alt="">
						</div>
						<div>
							<h3 class="mt-3 d-none d-lg-block">
								SELAMAT DATANG DI
							</h3>
							<h1 class="text-danger font-weight-bold">APLIKASI MONITORING BERKAS PERKARA</h1>
							<h3 class="font-weight-bold text-success">KEJAKSAAN NEGERI BERAU - KALIMANTAN TIMUR</h3>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12 d-flex">
			<div class="w-100">
				<div class="row">

					<div class="col-lg-3">
						<a href="<?= base_url(); ?>/berkas-perkara" style="text-decoration: none;">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title text-success font-weight-bold mb-4">Data Berkas Perkara</h5>
									<h1 class="mt-1">
										<?= $jumlah_berkas_perkara; ?>
									</h1>
								</div>
							</div>
						</a>
					</div>

					<div class="col-lg-3">
						<a href="<?= base_url(); ?>/berkas-perkara" style="text-decoration: none;">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title text-success font-weight-bold mb-4">Pengantar Berkas</h5>
									<h1 class="mt-1">
										<?= $jumlah_pengantar_berkas; ?>
									</h1>
								</div>
							</div>
						</a>
					</div>

					<div class="col-lg-3">
						<a href="<?= base_url(); ?>/data-master/instansi" style="text-decoration: none;">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title text-success font-weight-bold mb-4">Data Instansi</h5>
									<h1 class="mt-1">
										<?= $jumlah_instansi; ?>
									</h1>
								</div>
							</div>
						</a>
					</div>

					<div class="col-lg-3">
						<a href="<?= base_url(); ?>/data-master/jaksa" style="text-decoration: none;">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title text-success font-weight-bold mb-4">Jaksa</h5>
									<h1 class="mt-1">
										<?= $jumlah_jaksa; ?>
									</h1>
								</div>
							</div>
						</a>
					</div>

				</div>
			</div>
		</div>

		<div class="col-12 col-lg-9">
			<div class="card flex-fill w-100">
				<div class="card-header">
					<h5 class="card-title text-success font-weight-bold mb-0 font-weight-bold">Grafik Data Berkas Perkara Perbulan Tahun <?= date("Y"); ?></h5>
				</div>
				<div class="card-body py-3">
					<div class="chart chart-sm">
						<canvas id="chartjs-dashboard-line" style="height: 320px;"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-lg-3 d-flex">
			<div class="card flex-fill">
				<div class="card-body d-flex">
					<div class="align-self-center w-100">
						<div class="chart">
							<div id="datetimepicker-dashboard"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
		var gradient = ctx.createLinearGradient(0, 0, 0, 225);
		gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
		gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
		// Line chart
		new Chart(document.getElementById("chartjs-dashboard-line"), {
			type: "line",
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
				datasets: [{
					label: "Data Berkas Perkara",
					fill: true,
					backgroundColor: gradient,
					borderColor: window.theme.primary,
					data: [
						<?php
						for ($bulan = 1; $bulan <= 12; $bulan++) {
							$total_perbulan = $db->query("SELECT * FROM berkas_perkara WHERE MONTH(tanggal_berkas)='$bulan' ")->getNumRows();
							echo "$total_perbulan,";
						}
						?>
					]
				}]
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					display: false
				},
				tooltips: {
					intersect: false
				},
				hover: {
					intersect: true
				},
				plugins: {
					filler: {
						propagate: false
					}
				},
				scales: {
					xAxes: [{
						reverse: true,
						gridLines: {
							color: "rgba(0,0,0,0.0)"
						}
					}],
					yAxes: [{
						ticks: {
							stepSize: 1000
						},
						display: true,
						borderDash: [3, 3],
						gridLines: {
							color: "rgba(0,0,0,0.0)"
						}
					}]
				}
			}
		});
	});
</script>

<!-- <script>
	document.addEventListener("DOMContentLoaded", function() {
		// Bar chart
		new Chart(document.getElementById("chartjs-dashboard-bar"), {
			type: "bar",
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				datasets: [{
					label: "This year",
					backgroundColor: window.theme.primary,
					borderColor: window.theme.primary,
					hoverBackgroundColor: window.theme.primary,
					hoverBorderColor: window.theme.primary,
					data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
					barPercentage: .75,
					categoryPercentage: .5
				}]
			},
			options: {
				maintainAspectRatio: false,
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						gridLines: {
							display: false
						},
						stacked: false,
						ticks: {
							stepSize: 20
						}
					}],
					xAxes: [{
						stacked: false,
						gridLines: {
							color: "transparent"
						}
					}]
				}
			}
		});
	});
</script> -->

<script>
	document.addEventListener("DOMContentLoaded", function() {
		document.getElementById("datetimepicker-dashboard").flatpickr({
			inline: true,
			prevArrow: "<span class=\"fas fa-chevron-left\" title=\"Previous month\"></span>",
			nextArrow: "<span class=\"fas fa-chevron-right\" title=\"Next month\"></span>",
		});
	});
</script>

<?= $this->endSection('content'); ?>