<?php

class GET_Tarifs_Controller
{
	use database;

	public $result = 'error';
	public $tarifs = [];

	public function work () {

		global $user_id;
		global $service_id;

		header('Content-Type: application/json');

		$q = 'select * from services where ID='.(int)$service_id.' and user_id='.(int)$user_id;
		$services = self::db()->query($q);

		foreach ($services as $service) {
			$tarif = 'select * from tarifs where ID =' . @(int)$service['tarif_id'];
			$tarif = self::db()->query($tarif)->fetch_assoc();

			$q = 'select * from tarifs where tarif_group_id = (' . (int)$tarif['tarif_group_id'] . ')';
			$res = self::db()->query($q);
			$this->tarifs[] = (object)['title' => $tarif['title'], 'link' => $tarif['link'], 'speed' => $tarif['speed'], 'tarifs' => []];
			foreach ($res as $item) {
				$this->tarifs[count($this->tarifs) - 1]->tarifs[] =
					[
						'ID' => $item['ID'],
						'title' => $item['title'],
						'price' => $item['price'],
						'link' => $item['link'],
						'speed' => $item['speed'],
						'pay_period' => $item['pay_period'],
						'tarif_group_id' => $item['tarif_group_id'],
						'new_pay_day' => strtotime('today midnight') + $item['pay_period'] * 30 * 24 * 3600
					];
			}
		}

		if (count($this->tarifs)) $this->result = 'ok';

		$result = json_encode($this, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

		echo $result;
	}
}

(new GET_Tarifs_Controller)->work();