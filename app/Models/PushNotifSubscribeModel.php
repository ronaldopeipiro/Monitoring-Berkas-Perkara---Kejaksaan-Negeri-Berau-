<?php

namespace App\Models;

use CodeIgniter\Model;

class PushNotifSubscribeModel extends Model
{
	protected $primaryKey = 'id_push_notif';
	protected $table = 'push_notif_subscribe';
	protected $allowedFields = [
		'id_push_notif',
		'id_user',
		'tipe_user',
		'endpoint',
		'p256dh',
		'auth',
		'create_datetime'
	];

	public function getPushNotifSubscribe($id_push_notif = false)
	{
		if ($id_push_notif == false) {
			return $this->orderBy('id_push_notif', 'desc')->findAll();
		}
		return $this->where(['id_push_notif' => $id_push_notif])->first();
	}

	public function updatePushNotifSubscribe($data, $id)
	{
		$query = $this->db->table($this->table)->update($data, array('id_push_notif' => $id));
		return $query;
	}

	public function deletePushNotifSubscribe($id)
	{
		return $this->db->table($this->table)->delete(['id_push_notif' => $id]);
	}
}
