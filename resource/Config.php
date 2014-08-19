<?php

class Config {

	protected $config;

	static private $CONFIG_FILE = 'config.ini';
	static private $JSON_FILE = 'products.json';

	public function __construct() {
		$this->parseConfig();
	}

	public function getJson() {
		$conf = $this->config;
		return $conf['json'];
	}

	public function getVersion() {
		$conf = $this->config;
		return $conf['version'];
	}

	private function parseConfig() {
		if (!file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . self::$CONFIG_FILE)) {
			error_log('No config file.');
			$this->defaultConfig();
		}
		else {
			$this->config = parse_ini_file(self::$CONFIG_FILE, true);
		}
	}

	private function defaultConfig() {
		$this->config = array(
			'version' => '',
			'json' => self::$JSON_FILE
		);
	}
} 