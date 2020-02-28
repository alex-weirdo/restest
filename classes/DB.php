<?php

class DB
{
	private function __construct () {}
	private function __clone () {}

	public static function get_instance () {
		require 'config/dbcfg.php';
		return new mysqli($host, $username, $password, $database);
	}
}

trait database
{
	public function db () {
		return DB::get_instance();
	}
}