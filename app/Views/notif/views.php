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
				// file: file,
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
	kirim_whatsapp('1fb92afe72a55161160bdd2c642055cf', '085245567747', 'Hallo', '');

	// pesanBerkasBaruMasuk();

	function cekBerkasKirimPesan() {

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
			type: "GET",
			dataType: "JSON",
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

						// Kirim Pesan Penerimaan Berkas

						var pesan_sukses = "";
						var isiPesan = "";
						var no_hp_jaksa = dataDetail.hp_jaksa;
						// var no_hp_jaksa = '085245567747';
						// var no_hp_jaksa = '0895326665503';

						if ((dataDetail.interval_tanggal_penerimaan >= 5) && (dataDetail.status_berkas == "KOSONG")) {

							isiPesan += `Berkas perkara yang anda tangani berikut ini telah melewati `;

							isiPesan += `` +
								dataDetail.interval_tanggal_penerimaan + ` hari sejak tanggal penerimaan berkas` +
								``;

							var url_spdp = '';
							if (dataDetail.file_spdp != "" && dataDetail.file_spdp != null) {
								url_spdp = base_url + `/assets/berkas/` + dataDetail.file_spdp;
							}

							var pesanNotif = `
${ucapanSalam} saudara/i 
*${dataDetail.nama_jaksa}*,

${isiPesan}

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ${dataDetail.tanggal_penerimaan_format} 
👮 _Instansi Penyidik_ : ${dataDetail.nama_instansi_penyidik} 
👥 _Tersangka_ : ${dataDetail.tersangka} 
🔖 _Status Berkas_ : ${dataDetail.status_berkas} 

🪪 _No. SPDP_ : ${dataDetail.nomor_spdp}
📅 _Tgl. SPDP_ : ${dataDetail.tanggal_spdp_format}
📁 _File SPDP_ : ${url_spdp}

Lihat lebih detail disini
https://kejariberau.id/berkas-perkara/detail/${dataDetail.slug}

Mohon segera melakukan tindak lanjut atas berkas tersebut
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_


TTD
*_KEJAKSAAN NEGERI BERAU_*
`;

							if (no_hp_jaksa != "" && no_hp_jaksa != null && no_hp_jaksa.length > 10) {
								kirim_whatsapp('1fb92afe72a55161160bdd2c642055cf', no_hp_jaksa, pesanNotif, '');
								pesan_sukses += `<p>Sukses mengirim pesan Berkas ke ${no_hp_jaksa}...</p>`;
							}
						}

						// Kirim Pesan SPDP
						var isiPesanP16 = ``;
						if ((dataDetail.interval_tanggal_p16 >= 30) && (dataDetail.status_berkas == 'KOSONG')) {

							isiPesanP16 += `Berkas yang anda tangani berikut ini telah melewati `;

							isiPesanP16 += `` +
								dataDetail.interval_tanggal_p16 + ` hari sejak Surat Perintah P-16 terbit` +
								``;

							var url_spdp = '';
							if (dataDetail.file_spdp != "" && dataDetail.file_spdp != null) {
								url_spdp = base_url + `/assets/berkas/` + dataDetail.file_spdp;
							}

							var pesanNotifP16 = `
${ucapanSalam} saudara/i 
*${dataDetail.nama_jaksa}*,

${isiPesanP16}

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ${dataDetail.tanggal_penerimaan_format} 
👮 _Instansi Penyidik_ : ${dataDetail.nama_instansi_penyidik} 
👥 _Tersangka_ : ${dataDetail.tersangka} 
🔖 _Status Berkas_ : ${dataDetail.status_berkas} 

📅 _Tgl. P-16_ : ${dataDetail.tanggal_p16_format} 
🪪 _No. SPDP_ : ${dataDetail.nomor_spdp}
📅 _Tgl. SPDP_ : ${dataDetail.tanggal_spdp_format}
📁 _File SPDP_ : ${url_spdp}

Lihat lebih detail disini
https://kejariberau.id/berkas-perkara/detail/${dataDetail.slug}

Mohon segera menerbitkan surat P-17
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_


TTD
*_KEJAKSAAN NEGERI BERAU_*
`;

							if (no_hp_jaksa != "" && no_hp_jaksa != null && no_hp_jaksa.length > 10) {
								kirim_whatsapp('1fb92afe72a55161160bdd2c642055cf', no_hp_jaksa, pesanNotifP16, '');
								pesan_sukses += `<p>Sukses mengirim pesan P16 ke ${no_hp_jaksa}...</p>`;
							}
						}

						// Kirim Pesan P17
						var isiPesanP17 = ``;
						if ((dataDetail.interval_tanggal_p17 >= 30) && (dataDetail.status_berkas == 'KOSONG' || dataDetail.status_berkas == 'P-17')) {

							isiPesanP17 += `Berkas yang anda tangani berikut ini telah melewati `;

							isiPesanP17 += `` +
								dataDetail.interval_tanggal_p17 + ` hari sejak P-17 terbit` +
								``;

							var pesanNotifP17 = `
${ucapanSalam} saudara/i 
*${dataDetail.nama_jaksa}*,

${isiPesanP17}

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ${dataDetail.tanggal_penerimaan_format} 
📅 _Tgl. P-17_ : ${dataDetail.tanggal_p17_format} 
👮 _Instansi Penyidik_ : ${dataDetail.nama_instansi_penyidik} 
👥 _Tersangka_ : ${dataDetail.tersangka} 
🔖 _Status Berkas_ : ${dataDetail.status_berkas} 

Lihat lebih detail disini
https://kejariberau.id/berkas-perkara/detail/${dataDetail.slug}

Mohon segera menerbitkan SOP Form 02
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_

TTD
*_KEJAKSAAN NEGERI BERAU_*
`;

							if (no_hp_jaksa != "" && no_hp_jaksa != null && no_hp_jaksa.length > 10) {
								kirim_whatsapp('1fb92afe72a55161160bdd2c642055cf', no_hp_jaksa, pesanNotifP17, '');
								pesan_sukses += `<p>Sukses mengirim pesan P17 ke ${no_hp_jaksa}...</p>`;
							}
						}


						// Kirim Pesan P19
						var isiPesanP19 = ``;
						if ((dataDetail.interval_tanggal_sop_form_02 >= 14) && (dataDetail.status_berkas == 'P-19')) {

							isiPesanP19 += `Berkas yang anda tangani berikut ini telah melewati `;

							isiPesanP19 += `` +
								dataDetail.interval_tanggal_sop_form_02 + ` hari sejak SOP Form 02 terbit` +
								``;

							var pesanNotifP19 = `
${ucapanSalam} saudara/i 
*${dataDetail.nama_jaksa}*,

${isiPesanP19}

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ${dataDetail.tanggal_penerimaan_format} 
📅 _Tgl. P-19_ : ${dataDetail.tanggal_p19_format} 
👮 _Instansi Penyidik_ : ${dataDetail.nama_instansi_penyidik} 
👥 _Tersangka_ : ${dataDetail.tersangka} 
🔖 _Status Berkas_ : ${dataDetail.status_berkas} 

Lihat lebih detail disini
https://kejariberau.id/berkas-perkara/detail/${dataDetail.slug}

Mohon segera menerbitkan Surat P-20
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_

TTD
*_KEJAKSAAN NEGERI BERAU_*
`;

							if (no_hp_jaksa != "" && no_hp_jaksa != null && no_hp_jaksa.length > 10) {
								kirim_whatsapp('1fb92afe72a55161160bdd2c642055cf', no_hp_jaksa, pesanNotifP19, '');
							}
							pesan_sukses += `<p>Sukses mengirim pesan P-19 ke ${no_hp_jaksa}...</p>`;
						}


						// Kirim Pesan P20
						var isiPesanP20 = ``;
						if ((dataDetail.interval_tanggal_p20 >= 14) && (dataDetail.status_berkas == 'P-20')) {

							isiPesanP20 += `Berkas yang anda tangani berikut ini telah melewati `;

							isiPesanP20 += `` +
								dataDetail.interval_tanggal_p20 + ` hari sejak P-20 terbit` +
								``;

							var pesanNotifP20 = `
${ucapanSalam} saudara/i 
*${dataDetail.nama_jaksa}*,

${isiPesanP20}

*_Detail Berkas_*
-----------------------------
📅 _Tgl. Penerimaan_ : ${dataDetail.tanggal_penerimaan_format} 
📅 _Tgl. P-20_ : ${dataDetail.tanggal_p20_format} 
👮 _Instansi Penyidik_ : ${dataDetail.nama_instansi_penyidik} 
👥 _Tersangka_ : ${dataDetail.tersangka} 
🔖 _Status Berkas_ : ${dataDetail.status_berkas} 

Lihat lebih detail disini
https://kejariberau.id/berkas-perkara/detail/${dataDetail.slug}

Mohon segera menerbitkan Surat Pengembalian SPDP
Terima Kasih 🙏


_(Anda menerima pesan ini karena anda terdata sebagai jaksa yang menangani perkara ini)_

TTD
*_KEJAKSAAN NEGERI BERAU_*
`;

							if (no_hp_jaksa != "" && no_hp_jaksa != null && no_hp_jaksa.length > 10) {
								kirim_whatsapp('1fb92afe72a55161160bdd2c642055cf', no_hp_jaksa, pesanNotifP20, '');
							}
							pesan_sukses += `<p>Sukses mengirim pesan Notif P-20 ke ${no_hp_jaksa}...</p>`;
						}

					}

				}
				$('#loadData').html(pesan_sukses);
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

	// cekBerkasKirimPesan();
</script>

<?= $this->endSection('content-notif'); ?>