<?php
namespace Peak\CrontabRecorder;

use Peak\Plugin\DB;

abstract class Factory {

	use Common\Boot;
	use Common\Start;
	use Common\Run;
	use Common\End;

	use \Peak\Plugin\Debuger\Base;

	# debug code<0 致命性错误
	# debug code=0 正常性错误

	private static $config = [
//		'TASK_MODE' => '任务模式',
		'TIME_ZONE' => '时区',
		'TIME_INIT' => '初始时间',
		'TIME_STEP' => '步长间隔',
		'TIME_WARD' => '安全时间设置',
	];



	/**
	 * 必填参数检测
	 * */
	function __construct($type='mysql', $db, $usr=null, $pwd=null, $host='localhost', $port=null, array $option=[])
	{
		DB\Connector::configDb($db, $usr, $pwd);
		DB\Connector::configHost($host, $port);
		$option ? DB\Connector::configOption($option) : DB\Connector::configOption();
		DB\Core::connect($type);

		foreach (self::$config as $key=>&$val) {
			if ( !defined('static::'.$key)) {
				self::debug('初始化错误: 参数“'.$val.'['.$key.']”未设置。');
				return;
			}
		}
	}




	/**
	 * 执行同步业务 最终调用方法
	 * */
	final public function handle ($id, $category=null):bool
	{

		#1 检测初始化过程中是否异常
		if ($this->debug()) {
			return false;
		}


		#2 启动
		$this->boot($id, $category ? $category : '/');

		#3 开始
		if (!$this->start()) {
			return false;
		}
		$this->step();


		#4 组织参数 发起api请求
		if (!$this->run()) {
			return false;
		}
		$this->step();

		#5 存储数据
		\Peak\Plugin\DB\Core::transaction();
		try {
			if (!$this->end()) {
				throw new \Exception('Error happened in the "End" part.');
			}
			$this->step();
		} catch (\Exception $e) {
			\Peak\Plugin\DB\Core::transaction(-1);
		}
		\Peak\Plugin\DB\Core::transaction(1);


		// 清除历史记录
//			self::clearHistory();

		return true;
	}


	abstract function run():bool;
	abstract function end():bool;


}
