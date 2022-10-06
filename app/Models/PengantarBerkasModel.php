<?php

namespace App\Models;

use CodeIgniter\Model;

class PengantarBerkasModel extends Model
{
	protected $primaryKey = 'id_pengantar_berkas';
	protected $table = 'pengantar_berkas';
	protected $allowedFields = [
		'id_pengantar_berkas',
		'id_berkas_perkara',
		'nomor_pengantar',
		'tanggal_pengantar',
		'tanggal_terima',
		'nama_tersangka',
		'pasal_uu',
		'file_berkas',
		'create_datetime',
		'update_datetime',
	];

	public function getPengantarBerkas($id_pengantar_berkas = false)
	{
		if ($id_pengantar_berkas == false) {
			return $this->orderBy('id_pengantar_berkas', 'desc')->findAll();
		}
		return $this->where(['id_pengantar_berkas' => $id_pengantar_berkas])->first();
	}

	public function updatePengantarBerkas($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_pengantar_berkas' => $id));
		return $query;
	}

	public function deletePengantarBerkas($id)
	{
		return $this->db->table($this->table)->delete(['id_pengantar_berkas' => $id]);
	}
}
