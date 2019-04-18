<?php

namespace Peak\CrontabRecorder;

use Peak\DB;

class Model
{

	private static $table = 'peak_crontab_recorder';

	static function table ($tb)
	{
		self::$table = $tb;
	}



	static function search ($id, $cls, $tag):object
	{
		$sql = 'select * from '.self::$table;
		$sql.= ' where ';
		$sql.= DB\SQL\Where::equal('id', $id);
		$sql.= DB\SQL\Where::equal('cls', $cls);
		$sql.= DB\SQL\Where::equal('tag', $tag);
		$sql.= ' order by datetime desc';

		return DIR\Core::read($sql, true, null);
	}



	static function store ($dat, $insert=true)
	{
		if ($insert) {
			$sql = DB\SQL\Insert::insert(self::$table, (array)$dat);
			return DB\Core::create($sql);
		} else {
			$sql = DB\SQL\Update::update(self::$table, (array)$dat);
			return DB\Core::update($sql);
		}
	}



	static function remove ($dat, $step=0, $datetime='')
	{
		$sql = 'delete from '.self::$table;
		$sql.= ' where ';
		$sql.= DB\SQL\Where::equal('id', $dat->id);
		$sql.= DB\SQL\Where::equal('cls', $dat->cls);
		$sql.= DB\SQL\Where::equal('tag', $dat->tag);
		$step && $sql.= DB\SQL\Where::equal('step', $step);
		$datetime && $sql.= DB\SQL\Where::equal('datetime<', $datetime);

		return DB\Core::delete($sql);

	}


}
