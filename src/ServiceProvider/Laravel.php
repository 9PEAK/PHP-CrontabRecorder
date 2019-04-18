<?php

namespace Peak\CrontabRecorder\ServiceProvider;

class Laravel extends \Illuminate\Support\ServiceProvider
{


	public function boot()
	{
		// 创建迁移
		$this->publishes(
			[
				__DIR__.'/../Init/Laravel.php' => database_path('migrations/2019_01_13_170327_peak_crontab_recorder.php'),
			],
			'migration'
		);
	}

}
