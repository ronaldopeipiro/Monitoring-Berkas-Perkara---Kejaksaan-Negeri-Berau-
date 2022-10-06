<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $primaryKey = 'id_user';
	protected $table = 'user';
	protected $allowedFields = [
		'id_user',
		'id_level',
		'username',
		'password',
		'nama_lengkap',
		'email',
		'no_hp',
		'foto',
		'token_reset_password',
		'create_datetime',
		'update_datetime',
		'last_login',
		'aktif',
	];

	public function getUser($id_user = false)
	{
		if ($id_user == false) {
			return $this->orderBy('id_user', 'desc')->findAll();
		}
		return $this->where(['id_user' => $id_user])->first();
	}

	public function getUserAktif()
	{
		return $this->where([
			'aktif' => 'Y'
		])->orderBy(
			'id_user',
			'desc'
		)->findAll();
	}

	public function getListUserAktif()
	{
		return $this->where([
			'aktif' => 'Y'
		])->orderBy(
			'nama_user',
			'asc'
		)->findAll();
	}

	public function getUserAktifByLevel($id_level)
	{
		return $this->where([
			'id_level' => $id_level,
			'aktif' => 'Y'
		])->orderBy(
			'id_user',
			'desc'
		)->findAll();
	}

	public function getListUserAktifByLevel($id_level)
	{
		return $this->where([
			'id_level' => $id_level,
			'aktif' => 'Y'
		])->orderBy(
			'nama_user',
			'asc'
		)->findAll();
	}

	public function updateUser($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_user' => $id));
		return $query;
	}

	public function deleteUser($id)
	{
		return $this->db->table($this->table)->delete(['id_user' => $id]);
	}
}
