<?php

namespace Peak\CrontabRecorder\Common;

use Carbon\Carbon;
use Peak\CrontabRecorder\Model;

trait Boot {


	private $dat;

	/**
	 * 启动初始化
	 * */
	private function boot ($id, $tag)
	{

		$this->dat = Model::get ($id, static::class, $tag);

		$this->dat = $this->dat ?: [
			'id' => $id,
			'cls' => static::class,
			'tag' => $tag,
			'start' => static::TIME_INIT,
			'end' => static::TIME_INIT,
			'step' => 3,
		];

	}



	/**
	 * 设置model的初始时间
	 * @param $time 指定的时间，datetime格式
	 * */
	protected function setStart ($time=null)
	{
		$this->dat['start'] = $time ?: (Carbon::now(static::TIME_ZONE))->toDateTimeString();
	}


	/**
	 * 设置model的结束时间
	 * @param $time 指定的时间，datetime格式
	 * */
	protected function setEnd ($time=null)
	{
		$this->dat['end'] = $time ?: (Carbon::now(static::TIME_ZONE))->toDateTimeString();
	}


	/**
	 * 设置model的结束时间
	 * @param $step int 步长时间（分钟），默认null，使用配置的常量步长
	 * */
	protected function setEndByStep ($step=null)
	{
		if (!$this->dat['start']) return $this->debug('未设置初始时间，无法通过步长计算结束时间。');
		$this->dat['end'] = (Carbon::createFromFormat('Y-m-d H:i:s', $this->dat['start']))->addMinutes($step ?: static::TIME_STEP)->toDateTimeString();
	}



	/**
	 * 获取起始时间
	 * @param $toTimestamp boolean 是否返回时间戳数字。
	 * */
	protected function getStart ($toTimestamp=false)
	{
		return $toTimestamp ? Carbon::createFromFormat('Y-m-d H:i:s', $this->dat['start'], static::TIME_ZONE)->getTimestamp() : $this->dat['start'];
	}


	/**
	 * 获取结束时间
	 * @param $toTimestamp boolean 是否返回时间戳数字。
	 * */
	protected function getEnd ($toTimestamp=false)
	{
		return $toTimestamp ? Carbon::createFromFormat('Y-m-d H:i:s', $this->dat['end'], static::TIME_ZONE)->getTimestamp() : $this->dat['end'];
	}



	/**
	 * 设置remark
	 * @param $dat mixed
	 * */
	protected function setRemark ($dat)
	{
		$this->dat['remark'] = is_array($dat) ? json_encode($dat) : $dat;
	}


	/**
	 * 获取remark
	 * */
	protected function getRemark ()
	{
		return $this->dat['remark'];
	}


	/**
	 * 获取id
	 * */
	protected function getId ()
	{
		return $this->dat['id'];
	}

}
