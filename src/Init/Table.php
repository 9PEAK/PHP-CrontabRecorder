<?php

namespace Peak\CrontabRecorder\Init;

trait Table
{


	static function sql ($tb)
	{
		return 'CREATE TABLE IF NOT EXISTS `'.$tb.'` (
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


	protected static function create ($tb='9peak_crontab_recorder')
	{

	}

}
