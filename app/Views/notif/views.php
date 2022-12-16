<?= $this->extend('layout/template-notif'); ?>

<?= $this->section('content-notif'); ?>

<div id="status"></div>
<div id="loadData"></div>

<script>
	function kirim_whatsapp(device_id, no_hp, pesan, file) {
		const urlPost = base_url + "/notif/whatsapp";

		$.ajax({
			type: "POST",
			url: urlPost,
			dataType: "JSON",
			data: {
				device_id: device_id,
				no_hp: no_hp,
				pesan: pesan,
				file: file,
			},
			beforeSend: function() {
				$("#loader").show();
			},
			success: function(data) {
				toastr.success(data.pesan);
				$("#status").html(`
					${data.pesan}
				`);
			},
			complete: function(data) {
				$("#loader").hide();
			}
		});
	}

	// Pak ITO
	// kirim_whatsapp('328b01352c9390ab1f20fedc72398bcf', '085750597580', 'Test', '');

	function pesanBerkasBaruMasuk() {
		const d = new Date();
		let time = d.getHours();
		// let minutes = d.Minutes();

		var ucapanSalam = '';
		if (time >= 2 && time < 12) {
			ucapanSalam = 'Selamat Pagi 🙏';
		} else if (time >= 12 && time < 15) {
			ucapanSalam = 'Selamat Siang 🙏';
		} else if (time >= 15 && time < 18) {
			ucapanSalam = 'Selamat Sore 🙏';
		} else {
			ucapanSalam = 'Selamat Malam 🙏';
		}


		var namaJaksa = 'Ronald';
		var slug = 'IgUOx2gBvqua6he1OUNqsQeffLNyLJqZ9P7hFy7Kf8sfPHYBg5Ynm2XtFb7IkQAmlXRq8OAR5pkA1wGxqVX3D67764W3NZ5HBEKC';
		var pesanBerkasBaruMasuk = `
*_INFORMASI BERKAS PERKARA_*

${ucapanSalam} saudara/i *${namaJaksa}*,

📎Anda memiliki 1 berkas perkara baru

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : 24/10/2022 
🪪 _No. SPDP_ : B/39/X/Res.4.2./2022/Resnarkoba
📅 _Tgl. SPDP_ : 20/10/2022
📁 _Berkas SPDP_ : https://kejariberau.id/assets/berkas/spdp-1667963577_94cae4d76ccff7116316.pdf

Lihat lebih detail disini
https://kejariberau.id/berkas-perkara/detail/${slug}

Mohon segera melakukan tindak lanjut atas berkas tersebut
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_

*TTD*
_KEJAKSAAN NEGERI BERAU_
`;

		// Ronald
		kirim_whatsapp('1fb92afe72a55161160bdd2c642055cf', '085245567747', pesanBerkasBaruMasuk, '');
	}

	// pesanBerkasBaruMasuk();


	function cekAllBerkas() {

		const d = new Date();
		let time = d.getHours();
		// let minutes = d.Minutes();

		var ucapanSalam = '';
		if (time >= 2 && time < 12) {
			ucapanSalam = 'Selamat Pagi 🙏';
		} else if (time >= 12 && time < 15) {
			ucapanSalam = 'Selamat Siang 🙏';
		} else if (time >= 15 && time < 18) {
			ucapanSalam = 'Selamat Sore 🙏';
		} else {
			ucapanSalam = 'Selamat Malam 🙏';
		}


		$('#loadData').html(`<h5 style="text-align:center; margin-top: 50px;">Mengambil Data . . .</h5>`);

		let requestDetail = $.ajax({
			url: base_url + '/berkas-perkara/get-all-proses',
			type: "POST",
			dataType: "JSON",
			data: {},
		});

		requestDetail.done(function(msg) {
			const statusData = msg.status;

			if (statusData == 1) {
				const listData = msg.data;
				const jumlahData = listData.length;

				if (jumlahData == 0) {
					isiDataDetail = `<p class="text-danger font-italic" style="text-align:center; margin-top: 50px;">Data tidak ditemukan . . .</p>`;
				} else {
					for (let i = 0; i < jumlahData; i++) {
						const no = i + 1;
						const dataDetail = listData[i];

						var isiPesan = "";

						isiPesan += `` +
							dataDetail.interval_tanggal_penerimaan + ` hari sejak tanggal penerimaan` +
							``;

						if (dataDetail.nomor_berkas != "" || dataDetail.tanggal_berkas != "") {
							isiPesan += ` || ` +
								dataDetail.interval_tanggal_berkas + ` hari sejak tanggal berkas` +
								``;
						} else if (dataDetail.nomor_spdp != "" || dataDetail.tanggal_spdp != "") {
							isiPesan += ` || ` +
								dataDetail.interval_tanggal_spdp + ` hari sejak tanggal SPDP` +
								``;
						} else if (dataDetail.nomor_p17 != "" || dataDetail.tanggal_p17 != "") {
							isiPesan += ` || ` +
								dataDetail.interval_tanggal_p17 + ` hari sejak tanggal P-17` +
								``;
						} else if (dataDetail.nomor_sop_form_02 != "" || dataDetail.tanggal_sop_form_02 != "") {
							isiPesan += ` || ` +
								dataDetail.interval_tanggal_sop_form_02 + ` hari sejak tanggal SOP-Form 02` +
								``;
						} else if (dataDetail.nomor_surat_pengembalian_spdp != "" || dataDetail.tanggal_surat_pengembalian_spdp != "") {
							isiPesan += ` || ` +
								dataDetail.interval_tanggal_surat_pengembalian_spdp + ` hari sejak tanggal Surat Pengembalian SPDP` +
								``;
						}

						var url_spdp = '';
						if (dataDetail.file_spdp != "" && dataDetail.file_spdp != null) {
							url_spdp = base_url + `/assets/berkas/` + dataDetail.file_spdp;
						}

						var pesanNotif = `
*_INFORMASI BERKAS PERKARA_*

${ucapanSalam} saudara/i *${dataDetail.nama_jaksa}*,

${isiPesan}

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ${dataDetail.tanggal_penerimaan_format} 
🪪 _No. SPDP_ : ${dataDetail.nomor_spdp}
📅 _Tgl. SPDP_ : ${dataDetail.tanggal_spdp_format}
📁 _Berkas SPDP_ : ${url_spdp}

Lihat lebih detail disini
https://kejariberau.id/berkas-perkara/detail/${dataDetail.slug}

Mohon segera melakukan tindak lanjut atas berkas tersebut
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_

*TTD*
_KEJAKSAAN NEGERI BERAU_
`;

						var no_hp_jaksa = dataDetail.hp_jaksa;
						if (no_hp_jaksa != "" && no_hp_jaksa != null && no_hp_jaksa.length > 10) {
							kirim_whatsapp('1fb92afe72a55161160bdd2c642055cf', dataDetail.hp_jaksa, pesanNotif, '');
						}
					}

				}

			} else {
				$('#loadData').html(`<h3 style="text-align:center">${msg.msg}</h3>`);
			}
		});

		requestDetail.fail(function(jqXHR, textStatus) {
			$('#loadData').html(`
					<h5 style="text-align: center; color: red;">
						Gagal Mengambil Data, Terjadi Kesalahan Teknis
					</h5>
				`);
		});
	}

	cekAllBerkas();
</script>

<?= $this->endSection('content-notif'); ?>