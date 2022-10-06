<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasPerkaraModel extends Model
{
	protected $primaryKey = 'id_berkas_perkara';
	protected $table = 'berkas_perkara';
	protected $allowedFields = [
		'id_berkas_perkara',
		'tanggal_berkas',
		'tanggal_p16',
		'nomor_berkas',
		'nomor_p16',
		'id_instansi_penyidik',
		'id_instansi_pelaksana_penyidikan',
		'file_berkas',
		'status_berkas',
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
