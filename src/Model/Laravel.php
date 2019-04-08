<?php

namespace Peak\CrontabRecorder\Model;


class Laravel extends \Illuminate\Database\Eloquent\Model implements Core
{

	protected $table = 'sdfsdfsdfdsf';

	public $timestamps = false;

    protected $fillable = [
        'id' => 'id', // id
        'type' => 'type', // id
	    'category' => 'category', // id
	    'start_time' => 'start_time',
	    'end_time' => 'end_time',
	    'step' => 'step',
	    'datetime' => 'datetime', // id
        'remark' => 'remark',
    ];


	static function search ($id, $type, $category):array
	{
		$id = [
			'id' => $id,
			'type' => $type,
			'category' => $category,
		];
		$obj = static::query()->where($id)->orderBy('datetime', 'desc')->first();
		return $obj ? $obj->toArray() : $id;
	}


	static function store (array $dat, $insert=true)
	{
		if ($insert) {
			static::insert($dat);
		} else {
			static::query()->where([
				'id' => $dat['id'],
				'type' => $dat['type'],
				'category' => $dat['category'],
				'datetime' => $dat['datetime'],
			])->update($dat);
		}
	}


	static function remove (array $dat, $step=0, $limit=0)
	{

	}


}
