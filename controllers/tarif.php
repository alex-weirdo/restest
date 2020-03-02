<?php

class PUT_Tarif_Controller
{
	use database;

	public $result = 'error';

	public function work () {

		global $user_id;
		global $service_id;

		header('Content-Type: application/json');

		//parse_str(file_get_contents("php://input"),$putData);
		$tarif_id = @$_REQUEST['tarif_id'];

		if (!$tarif_id) {echo json_encode($this); return;}

		$q = 'select tarif_group_id from tarifs where ID = (select tarif_id from services where ID = '.(int)$service_id.' and user_id = '.(int)$user_id.')';
		$tarif_group_id = self::db()->query($q)->fetch_assoc();

		$q = 'select * from tarifs where ID = '.(int)$tarif_id;
		$tarif_exist = self::db()->query($q)->fetch_assoc();

		if (
			$tarif_exist === null ||
			$tarif_group_id['tarif_group_id'] != $tarif_exist['tarif_group_id']
		) {echo json_encode($this); return;}

		$new_pay_day = date('Y-m-d', strtotime('today midnight') + (int)$tarif_exist['pay_period'] * 30 * 24 * 3600);

		$q = 'update services set tarif_id='.(int)$tarif_id.', payday = "'.$new_pay_day.'" where ID='.(int)$service_id.' and user_id='.(int)$user_id;
		$result = self::db()->query($q);

		if ($result) {
			$this->result = 'ok';
		}

		echo json_encode($this);

	}
}

(new PUT_Tarif_Controller)->work();