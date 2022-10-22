<?php

namespace App\Models;

use CodeIgniter\Model;

class RefEmailModel extends Model
{
	protected $primaryKey = 'email';
	protected $table = 'ref_email';
	protected $allowedFields = [
		'email',
		'nama_akun',
		'password',
		'create_datetime',
		'update_datetime',
		'aktif',
	];

	public function getRefEmail()
	{
		return $this->first();
	}

	public function getRefEmailAktif()
	{
		return $this->where([
			'aktif' => 'Y'
		])->orderBy(
			'email',
			'desc'
		)->first();
	}

	public function updateRefEmail($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('email' => $id));
		return $query;
	}

	public function deleteRefEmail($id)
	{
		return $this->db->table($this->table)->delete(['email' => $id]);
	}
}
