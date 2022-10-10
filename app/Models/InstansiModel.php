<?php

namespace App\Models;

use CodeIgniter\Model;

class InstansiModel extends Model
{
	protected $primaryKey = 'id_instansi';
	protected $table = 'instansi';
	protected $allowedFields = [
		'id_instansi',
		'nama_instansi',
		'deskripsi',
		'create_datetime',
		'update_datetime',
		'aktif',
	];

	public function getInstansi($id_instansi = false)
	{
		if ($id_instansi == false) {
			return $this->orderBy('id_instansi', 'desc')->findAll();
		}
		return $this->where(['id_instansi' => $id_instansi])->first();
	}

	public function getListInstansiAktif()
	{
		return $this->where([
			'aktif' => 'Y'
		])->orderBy(
			'id_instansi',
			'asc'
		)->findAll();
	}

	public function getInstansiAktif()
	{
		return $this->where([
			'aktif' => 'Y'
		])->orderBy(
			'id_instansi',
			'desc'
		)->findAll();
	}

	public function updateInstansi($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_instansi' => $id));
		return $query;
	}

	public function deleteInstansi($id)
	{
		return $this->db->table($this->table)->delete(['id_instansi' => $id]);
	}
}
