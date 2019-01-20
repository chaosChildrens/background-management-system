<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-01-07
 * Time: 23:45
 */
namespace app\index\controller;
use think\Controller;
use think\Session;


class Base extends Controller{
    /**
     * 检测用户是否登录

     */
    protected function is_logined()
    {
        $status = Session::has('admin_id');
        if (empty($status)){
            $this->error('您还未登陆,请先登录！',url('Index/Index/login'));
        }


    }
}