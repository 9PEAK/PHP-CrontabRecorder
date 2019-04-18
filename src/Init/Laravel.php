<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PeakCrontabRecorder extends Migration
{

	const TABLE_NAME = '9peak_crontab_recorder';


	public function up()
	{
		DB::statement(
			\Peak\CrontabRecorder\Init\Table::sql(self::TABLE_NAME)
		);
	}


	public function down()
	{
		Schema::dropIfExists(self::TABLE_NAME);
	}
}
