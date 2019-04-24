<?php

namespace Peak\CrontabRecorder;

final class ServiceProvider
{


	/**
	 * 安装
	 * */
	static function install ($tb, $frame='Laravel')
	{
		$sql = 'CREATE TABLE IF NOT EXISTS `'.$tb.'` (
  `id` varchar(50) NOT NULL,
  `cls` varchar(200) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `remark` text,
  `step` tinyint(1) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`,`cls`,`tag`),
  KEY `time` (`start`,`end`),
  KEY `step` (`step`),
  KEY `datetime` (`datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


	}



	/**
	 * 卸载
	 * */
	static function uninstall ($tb, $frame='Laravel')
	{

	}



}
