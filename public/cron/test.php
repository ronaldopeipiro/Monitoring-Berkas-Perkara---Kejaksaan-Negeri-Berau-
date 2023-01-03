<?php if ($argc > 1 and $argv[1] == "gyYaOg9me10TQH9ZJXRGMXi132mjX34bDWiGQUme0KTmzRc4YPAETOJ7Cq58YOHugxVyuWcqElE4Uz8QMGTLXvL9ot9N8Ac81xCQ") : ?>

	<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	include "koneksiPDO.php";
	//header('Content-Type:application/json');

	$base_url = "https://kejariberau.id/";

	function send_notif_whatsapp($device_id, $no_hp, $pesan)
	{
		$url = 'https://app.whacenter.com/api/send';
		$ch = curl_init($url);

		$data = array(
			'device_id' => $device_id,
			'number' => $no_hp,
			'message' => $pesan,
			// 'file' => $file,
		);

		$payload = $data;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		echo json_encode(array(
			'pesan' => $result
		));
	}

	send_notif_whatsapp('1fb92afe72a55161160bdd2c642055cf', '085161671197', 'Hallo test WA Gateway', '');


	?>

<?php else : ?>
	<h2>
		Terjadi kesalahan !
	</h2>
<?php endif; ?>