<?php

namespace Peak\CrontabRecorder;

use Peak\DB;

class Model
{

	private static $table = '9peak_crontab_recorder';

	static function table ($tb)
	{
		self::$table = $tb;
	}



	static function get ($id, $cls, $tag)
	{
		DB\SQL\Common::bind([], true);

		$sql = 'select * from '.self::$table;
		$sql.= ' where ';
		$sql.= DB\SQL\Where::equal('id', $id);
		$sql.= ' and '.DB\SQL\Where::equal('cls', $cls);
		$sql.= ' and '.DB\SQL\Where::equal('tag', $tag);
		$sql.= ' order by end desc';

		return DB\Core::read($sql, true);
	}



	static function save (array &$dat)
	{
		DB\SQL\Common::bind([], true);

		if (@$dat['datetime']) {
			$sql = DB\SQL\Update::update(self::$table, $dat);
			$sql.= ' where '.DB\SQL\Where::equal('id', $dat['id']);
			$sql.= ' and '.DB\SQL\Where::equal('cls', $dat['cls']);
			$sql.= ' and '.DB\SQL\Where::equal('tag', $dat['tag']);
			$sql.= ' and '.DB\SQL\Where::equal('datetime', $dat['datetime']);
			return DB\Core::query($sql, DB\SQL\Common::$bind);
		} else {
			$dat['datetime'] = date('Y-m-d H:i:s');
			$sql = DB\SQL\Insert::insert(self::$table, $dat);
			$res = DB\Core::create($sql, DB\SQL\Common::$bind);
			return $res;
		}
	}



	static function delete (array $dat, $step=0, $datetime='')
	{
		DB\SQL\Common::bind([], true);

		$sql = 'delete from '.self::$table;
		$sql.= ' where ';
		$sql.= DB\SQL\Where::equal('id', $dat['id']);
		$sql.= ' and '.DB\SQL\Where::equal('cls', $dat['cls']);
		$sql.= ' and '.DB\SQL\Where::equal('tag', $dat['tag']);
		$step && $sql.= ' and '.DB\SQL\Where::equal('step', $step);
		$datetime && $sql.= DB\SQL\Where::equal('datetime<', $datetime);

		return DB\Core::delete($sql);

	}

	/*

		static function delete ($dat)
		{
			DB\SQL\Common::bind([], true);

			$sql = 'delete from '.self::$table;
			$sql.= ' where ';
			$sql.= DB\SQL\Where::equal('id', $dat->id);
			$sql.= ' and '.DB\SQL\Where::equal('cls', $dat->cls);
			$sql.= ' and '.DB\SQL\Where::equal('tag', $dat->tag);
			$sql.= DB\SQL\Where::equal('datetime', $dat->datetime);

			return DB\Core::delete($sql);

		}
	*/


}
