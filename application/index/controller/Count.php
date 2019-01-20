<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-01-16
 * Time: 14:19
 */
namespace app\index\controller;
use think\Db;
class Count extends Base{
    public function yeji(){
        $OrdersModel=Db::table('Orders');
        $counts=$OrdersModel->alias("o")->join("admin a"," a.id=o.aid")->group('o.aid')->field('a.*,sum(money) as total')->select();
        $this->assign("counts",$counts);
        return $this->fetch();
    }

    public function shouhou(){
        $RepairModel=Db::table('repair');
        $counts=$RepairModel->group('gid')->field('*,count(*) as total')->order('total desc')->select();
        $this->assign("counts",$counts);
        return $this->fetch();
    }
}