<?php

namespace Peak\CrontabRecorder\Common;

use Peak\Plugin\DB as DIR;

class DB
{

	private static $table = 'peak_crontab_recorder';

	static function table ($tb)
	{
		self::$table = $tb;
	}

	static function search ($id, $type, $type):object
	{
		$sql = 'select * from '.self::$table;
		$sql.= ' where ';
		$sql.= DIR\SQL\Where::equal('id', $id);
		$sql.= DIR\SQL\Where::equal('type', $type);
		$sql.= DIR\SQL\Where::equal('category', $type);
		$sql.= ' order by datetime desc';

		return DIR\Core::read($sql, true, null);
	}


	static function store ($dat, $insert=true)
	{
		if ($insert) {
			$sql = DIR\SQL\Insert::insert(self::$table, (array)$dat);
			return DIR\Core::create($sql);
		} else {
			$sql = DIR\SQL\Update::update(self::$table, (array)$dat);
			return DIR\Core::update($sql);
		}
	}


	static function remove ($dat, $step=0, $datetime='')
	{
		$sql = 'delete from '.self::$table;
		$sql.= ' where ';
		$sql.= DIR\SQL\Where::equal('id', $dat->id);
		$sql.= DIR\SQL\Where::equal('type', $dat->type);
		$sql.= DIR\SQL\Where::equal('category', $dat->category);
		$step && $sql.= DIR\SQL\Where::equal('step', $step);
		$datetime && $sql.= DIR\SQL\Where::equal('datetime<', $datetime);

		return DIR\Core::delete($sql);

	}




}
