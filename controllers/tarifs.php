<?php

class GET_Tarifs_Controller
{
	use database;

	public static function work () {

		global $user_id;
		global $service_id;

		echo '$user_id = ' . $user_id;
		echo '<br>';
		echo '$service_id = ' . $service_id;


		$q = 'select * from rooms';
		$rooms = self::db()->query($q)->fetch_all();
		$result = json_encode($rooms, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
		echo "<pre>";
		var_dump($result);
		echo "</pre>";
	}
}

GET_Tarifs_Controller::work();