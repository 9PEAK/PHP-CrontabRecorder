# PHP-CrontabRecorder

CrontabRecorder 是一个可接续的定时任务组件，可用于定时轮询、自动更新同步等场景，如持续地、自动地同步来自第三方的订单明细。其生命周期如下：<br>


每次组件运行都记录任务的始末时间，由此避免业务重复、防止任务错漏。<br>


#### 安装
> composer require 9peak/crontab-recorder

#### 初始化
```php
// 安装表
\Peak\CrontabRecorder\ServiceProvider::install('table_name');
// 删除表
\Peak\CrontabRecorder\ServiceProvider::uninstall('table_name');
```

#### 核心
CrontabRecorder的核心部分采用装饰器设计模式（面向切面），将流程定义为Start、Run、End三个步骤，其中，Run和End步骤必须自定义，Start步骤默认接续上一次的记录——以上次的结束时间作为本次的开始时间——也可复写重新定义Start步骤。

```php
class DownloadOrderDetail extends \Peak\CrontabRecorder\Factiory
{

    
    const FORCE_MODE = false; // 是否使用强制模式
    
    const TIME_ZONE = 'Asia/Shanghai'; // 时区
    const TIME_INIT = '2019-09-09 09:09:09'; // 开始时间：如果数据库中没有相应记录将以此作为开始时间
    const TIME_STEP = 30; // 步长时间：单位分钟，结束时间=开始时间+步长时间
    const TIME_WARD = 15'; // 安全时间：每次运行时，必须满足“结束时间<=当前时间-安全时间”，否则任务停止。
    
    
    
    // 设置初始时间和结束时间
    public function start ():bool
    {
        // 设置时间
    }
    
    
    // 业务逻辑运行
    public function run ():bool
    {
    
    }
        

    // 存储至数据库（DB事务）
    public function end ():bool
    {
    
    }

}


$factory = new DownloadOrderDetail();

// 参数1 id，业务id；参数2 tag，业务标记。
$factory->handle('alibaba', 'tmall-order');
$factory->handle('alibaba', 'taobao-order');
if (!$factory->handle('alibaba', '速卖通-order')) {
    print_r($factory->debug());
}

```

#### Debug




#### 可用的(protected)方法
<ul>
    <li>$this->setStart($time=null) ： 设置开始时间，$time必须是datetime格式。</li>
    <li>$this->setEnd($time=null) ： 设置结束时间，$time必须是datetime格式。</li>
    <li>$this->setEndByStep($step=null) ： 用步长设置结束时间，$step int 分钟，默认null表示使用“TIME_STEP”作为步长。</li>
    <li>$this->getStart($toTimestamp=false) ： 获取开始时间，$toTimestamp bool 是否返回时间戳数字，默认false，返回datetime格式数据。</li>
    <li>$this->getEnd($toTimestamp=false) ： 获取结束时间，$toTimestamp bool 是否返回时间戳数字，默认false，返回datetime格式数据。</li>
    <li>$this->setRemark($dat) ： 设置备注，$dat mixed 如果是数组或对象将自动转成json字符。</li>
    <li>$this->getRemark() ： 获取备注。</li>
    <li>$this->getId() ： 获取id。</li>
</ul>
