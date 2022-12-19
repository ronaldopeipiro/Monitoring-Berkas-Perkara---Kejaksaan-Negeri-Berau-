<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasPerkaraModel extends Model
{
	protected $primaryKey = 'id_berkas_perkara';
	protected $table = 'berkas_perkara';
	protected $allowedFields = [
		'id_berkas_perkara',
		'slug',
		'tanggal_penerimaan',
		'nomor_berkas',
		'tanggal_berkas',
		'file_berkas',
		'nomor_pengantar_berkas',
		'tanggal_pengantar_berkas',
		'file_pengantar_berkas',
		'nomor_spdp',
		'tanggal_spdp',
		'file_spdp',
		'nomor_p16',
		'tanggal_p16',
		'file_p16',
		'nomor_p17',
		'tanggal_p17',
		'file_p17',
		'nomor_sop_form_02',
		'tanggal_sop_form_02',
		'file_sop_form_02',
		'nomor_surat_pengembalian_spdp',
		'tanggal_surat_pengembalian_spdp',
		'file_surat_pengembalian_spdp',
		'status_berkas',
		'id_instansi_penyidik',
		'tersangka',
		'jaksa_terkait',
		'pidana_anak',
		'status',
		'notifikasi_send',
		'create_datetime',
		'update_datetime',
		'id_user_create',
		'id_user_update'
	];

	public function getBerkasPerkara($id_berkas_perkara = false)
	{
		if ($id_berkas_perkara == false) {
			return $this->orderBy('id_berkas_perkara', 'desc')->findAll();
		}
		return $this->where(['id_berkas_perkara' => $id_berkas_perkara])->first();
	}

	public function updateBerkasPerkara($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_berkas_perkara' => $id));
		return $query;
	}

	public function deleteBerkasPerkara($id)
	{
		return $this->db->table($this->table)->delete(['id_berkas_perkara' => $id]);
	}
}
