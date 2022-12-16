<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="APP MONITORING BERKAS PERKARA - KEJARI BERAU">
	<meta name="author" content="RONALD">
	<meta name="keywords" content="monitoring, berkas, perkara, kejari, kejaksaan, jaksa, kejagung, tersangka, p16, website, web, aplikasi">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="<?= base_url() ?>/assets/img/logo.png" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="Brew">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<meta name="theme-color" content="black">

	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url(); ?>/assets/img/logo.png" type="image/png">
	<link rel="apple-touch-icon" sizes="167x167" href="<?= base_url(); ?>/assets/img/logo.png" type="image/png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(); ?>/assets/img/logo.png" type="image/png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url(); ?>/assets/img/logo.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>/assets/img/logo.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url(); ?>/assets/img/logo.png">

	<title><?= $title; ?> | APP MONITORING BERKAS PERKARA - KEJARI BERAU</title>

	<link href="<?= base_url() ?>/template/css/app.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="<?= base_url() ?>/template/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/select2/css/select2.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/dropzone/min/dropzone.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>/template/toastr/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<!-- <link rel="stylesheet" href="<?= base_url() ?>/template/dropify/dist/css/dropify.min.css"> -->
	<link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

	<link rel="stylesheet" href="<?= base_url() ?>/template/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">


	<script src="<?= base_url() ?>/template/js/app.js"></script>
	<script src="<?= base_url() ?>/template/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>/template/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>/template/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>/template/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url() ?>/template/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

	<script src="<?= base_url() ?>/template/select2/js/select2.min.js"></script>
	<script src="<?= base_url() ?>/template/toastr/toastr.min.js"></script>
	<script src="<?= base_url() ?>/template/sweetalert2/sweetalert2.min.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

	<!-- <script type="text/javascript" src="<?= base_url() ?>/template/dropify/dist/js/dropify.min.js"></script> -->

	<script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>

	<script>
		const base_url = "<?= base_url() ?>";
	</script>

</head>

<body>

	<div id="loader" style="display: none;">
		<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
			<img src="<?= base_url() ?>/assets/img/loading.gif" style="width: 350px; height: 350px; object-fit: cover; object-position: center;">
		</div>
	</div>

	<?= $this->renderSection('content-notif'); ?>

</body>

</html>