<?php

namespace Peak\CrontabRecorder\Model;

interface Core
{

	static function search ($id, $type, $category):array;

	static function store (array $dat, $insert=true);

	static function remove (array $condition, $step=3, $datetime=null);

}
