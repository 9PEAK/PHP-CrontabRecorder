<?php

namespace Peak\CrontabRecorder\Common;

use Carbon\Carbon;

trait Start
{


	/*
    |--------------------------------------------------------------------------
    | 部件I： 初始化
    |--------------------------------------------------------------------------
	|
    */

	/**
	 * @param
	 * @return true if success, null if cannot continue, false if last record is error.
	 * */
	public function start ():bool
	{

		if (defined('static::FORCE_MODE')&&static::FORCE_MODE) {
			// 强制模式
			$this->setStart(@$this->dat['end']);
			$this->setEndByStep();
			unset($this->dat['datetime']);
		} else {
			// 接续模式
			if ($this->is_step_able($this->dat['step'])) {
				// 上条记录正常
				$this->setStart(@$this->dat['end']);
				$this->setEndByStep();
				unset($this->dat['datetime']);
			}

			if (!$this->is_end_valid($this->getEnd(true), static::TIME_WARD)) {
				return (boolean)$this->debug('新任务超出限制时间。');
			}

		}

		$this->dat['step'] = 0;

		return true;
	}


	/**
	 * 判断步骤是否允许接续
	 * @param $step int 步骤
	 * @return bool
	 * */
	private function is_step_able ($step)
	{
		return $step==3;
	}



	/**
	 * 判断轮询在时间上是否允许接续
	 * @param $timestamp int 时间戳
	 * @param $guard int 限制时长（分钟）
	 * @return boolean
	 * */
	private function is_end_valid ($timestamp, $guard)
	{
		return $timestamp<=time()-$guard*60;
	}


}
