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

		switch (@static::TASK_MODE) {
			case 'force': // 强制模式
				// 设置开始和结束时间
				$this->setStartTime(@$this->dat->end_time ?: static::TIME_INIT);
				$this->setEndTimeByStep();
				$this->dat->step = 0;
				unset ($this->dat->datetime);
				break;

			case 'continue': // 接续模式
				if (!$this->is_step_able($this->dat->step)) {
					return (boolean)$this->debug('[失败] 上条记录异常：'.json_encode($this->dat));
				}
				// 设置开始和结束时间
				$this->setStartTime(@$this->dat->end_time ?: static::TIME_INIT);
				$this->setEndTimeByStep();

				if (!$this->is_end_time_valid($this->getEndTime(true), static::TIME_WARD)) {
					return (boolean)$this->debug('新任务超出限制时间。');
				}
				$this->dat->step = 0;
				unset ($this->dat->datetime);
				break;

			default: // 修复模式
				if (!$this->is_step_able($this->dat->step)) {
					$this->dat->step = 0;
				}
		}

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
	private function is_end_time_valid ($timestamp, $guard)
	{
		return $timestamp<=time()-$guard*60;
	}


}
