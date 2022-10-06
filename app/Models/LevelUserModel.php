<?php

namespace App\Models;

use CodeIgniter\Model;

class LevelUserModel extends Model
{
	protected $primaryKey = 'id_level';
	protected $table = 'level_user';
	protected $allowedFields = [
		'id_level',
		'keterangan',
		'create_datetime',
		'update_datetime',
		'aktif',
	];

	public function getLevelUser($id_level = false)
	{
		if ($id_level == false) {
			return $this->orderBy('id_level', 'desc')->findAll();
		}
		return $this->where(['id_level' => $id_level])->first();
	}

	public function getLevelUserAktif()
	{
		return $this->where([
			'aktif' => 'Y'
		])->orderBy(
			'id_level',
			'desc'
		)->findAll();
	}

	public function updateLevelUser($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_level' => $id));
		return $query;
	}

	public function deleteLevelUser($id)
	{
		return $this->db->table($this->table)->delete(['id_level' => $id]);
	}
}
