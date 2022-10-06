<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalSendNotifModel extends Model
{
	protected $primaryKey = 'id_jadwal';
	protected $table = 'jadwal_send_notif';
	protected $allowedFields = [
		'id_jadwal',
		'hari_ke',
		'create_datetime',
		'update_datetime'
	];

	public function getJadwalSendNotif($id_jadwal = false)
	{
		if ($id_jadwal == false) {
			return $this->orderBy('id_jadwal', 'desc')->findAll();
		}
		return $this->where(['id_jadwal' => $id_jadwal])->first();
	}

	public function updateJadwalSendNotif($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_jadwal' => $id));
		return $query;
	}

	public function deleteJadwalSendNotif($id)
	{
		return $this->db->table($this->table)->delete(['id_jadwal' => $id]);
	}
}
