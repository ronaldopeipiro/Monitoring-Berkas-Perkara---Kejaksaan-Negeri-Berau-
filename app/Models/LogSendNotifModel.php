<?php

namespace App\Models;

use CodeIgniter\Model;

class LogSendNotifModel extends Model
{
	protected $primaryKey = 'id_log';
	protected $table = 'log_send_notif';
	protected $allowedFields = [
		'id_log',
		'waktu',
		'id_berkas_perkara',
		'share_to'
	];

	public function getLogSendNotif($id_log = false)
	{
		if ($id_log == false) {
			return $this->orderBy('id_log', 'desc')->findAll();
		}
		return $this->where(['id_log' => $id_log])->first();
	}

	public function updateLogSendNotif($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_log' => $id));
		return $query;
	}

	public function deleteLogSendNotif($id)
	{
		return $this->db->table($this->table)->delete(['id_log' => $id]);
	}
}
