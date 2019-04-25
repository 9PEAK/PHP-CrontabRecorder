<?php

namespace Peak\CrontabRecorder\Common;

trait Run
{

	/**
	 * 设置流程
	 * */
	private function step ()
	{
		$this->dat['step']++;
		\Peak\CrontabRecorder\Model::save($this->dat);
	}

}
