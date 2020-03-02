<?php

class DB
{

	protected static $instance = null;

	private function __construct () {
		self::$instance = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	}
	private function __clone () {}

	public static function get_instance () {
		if (self::$instance)
			return self::$instance;
		new self;
		return self::$instance;
	}
}

trait database
{
	public function db () {
		return DB::get_instance();
	}
}