<?php

namespace Peak\CrontabRecorder;

use Peak\DB;

final class ServiceProvider
{

	static function init ($type='mysql', $name='default')
	{
		if ($pdo = DB\Connector::pdo($type, $name)) {
			DB\Core::connect($pdo);
			return true;
		}

		return DB\Connector::debug();
	}


	/**
	 * 安装
	 * */
	static function install ($tb)
	{

		DB\Core::query('CREATE TABLE IF NOT EXISTS `'.$tb.'` (
  `id` varchar(50) NOT NULL,
  `cls` varchar(200) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `remark` text,
  `step` tinyint(1) NOT NULL,
  `datetime` datetime NOT NULL ,
  UNIQUE KEY `id` (`id`,`cls`,`tag`, `datetime`),
  KEY `time` (`start`,`end`),
  KEY `step` (`step`),
  KEY `datetime` (`datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;', []);

		if ($error=DB\Core::debug()) {
			\Log::info($error);
		}

	}



	/**
	 * 卸载
	 * */
	static function uninstall ($tb)
	{

	}



}
