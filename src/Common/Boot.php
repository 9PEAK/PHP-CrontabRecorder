<?php

namespace Peak\CrontabRecorder\Common;

use Carbon\Carbon;
use Peak\CrontabRecorder\Model\Laravel as Model;

trait Boot {

	/**
	 * 根据参数查询或生成Model
	 * @param $id string|int id
	 * @param $type string 业务模块
	 * @param $category string 业务分类
	 * @return object
	 * */
//	private function model ($id, $type, $category)
//	{
//		$id = [
//			'id' => $id,
//			'type' => $type,
//			'category' => $category,
//		];
//		$dat = Model::where($id)->orderBy('datetime', 'desc')->first();
//		return $dat ?: new Model($id);
//	}



	private $dat;

	/**
	 * 启动初始化
	 * */
	private function boot ($id, $category)
	{

		$this->dat = static::$db::search ($id, static::class, $category);

		$this->dat = $this->dat ?: [
			'id' => $id,
			'type' => static::class,
			'category' => $category,
		];

		$this->dat = (object)$this->dat;

//
//		return;
//
//		$id = [
//			'id' => $id,
//			'type' => static::class,
//			'category' => $category,
//		];
//		$category = Model::where($id)->orderBy('datetime', 'desc')->first();
//		$this->dat = $category ?: new Model($id);

	}



	/**
	 * 设置model的初始时间
	 * @param $time 指定的时间，datetime格式
	 * */
	protected function setStartTime ($time=null)
	{
		$this->dat->start_time = $time ?: (Carbon::now(static::TIME_ZONE))->toDateTimeString();
	}


	/**
	 * 设置model的结束时间
	 * @param $time 指定的时间，datetime格式
	 * */
	protected function setEndTime ($time=null)
	{
		$this->dat->end_time = $time ?: (Carbon::now(static::TIME_ZONE))->toDateTimeString();
	}


	/**
	 * 设置model的结束时间
	 * @param $step int 步长时间（分钟），默认null，使用配置的常量步长
	 * */
	protected function setEndTimeByStep ($step=null)
	{
		if (!$this->dat->start_time) return $this->debug('未设置初始时间，无法通过步长计算结束时间。');
		$this->dat->end_time = (Carbon::createFromFormat('Y-m-d H:i:s', $this->dat->start_time))->addMinutes($step ?: static::TIME_STEP)->toDateTimeString();
	}



	/**
	 * 获取起始时间
	 * @param $toTimestamp boolean 是否返回时间戳数字。
	 * */
	protected function getStartTime ($toTimestamp=false)
	{
		return $toTimestamp ? Carbon::createFromFormat('Y-m-d H:i:s', $this->dat->start_time, static::TIME_ZONE)->getTimestamp() : $this->dat->start_time;
	}


	/**
	 * 获取结束时间
	 * @param $toTimestamp boolean 是否返回时间戳数字。
	 * */
	protected function getEndTime ($toTimestamp=false)
	{
		return $toTimestamp ? Carbon::createFromFormat('Y-m-d H:i:s', $this->dat->end_time, static::TIME_ZONE)->getTimestamp() : $this->dat->end_time;
	}



	/**
	 * 设置remark
	 * @param $dat mixed
	 * */
	protected function setRemark ($dat)
	{
		$this->dat->remark = is_array($dat) ? json_encode($dat) : $dat;
	}


	/**
	 * 获取remark
	 * */
	protected function getRemark ()
	{
		return $this->dat->remark;
	}


	/**
	 * 获取id
	 * */
	protected function getId ()
	{
		return $this->dat->id;
	}


}