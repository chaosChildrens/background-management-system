<?php
namespace app\index\controller;


use think\Db;
use think\Request;
use think\Session;

class Index extends Base
{
    public function index()
    {
        $this->is_logined();
        $this->assign("role",array("管理员","经理","销售","售后"));
        //var_dump($_SESSION);
        return  $this->fetch();
    }
    public function login(){
        $request = Request::instance();
        if($request->isPost()){
            $userModel=Db::name("Admin");
            $data = $request->param();
            $clientIp=$request->ip();

           $map=array(
               "name"=>$data['name'],
               "pwd"=>md5($data['pwd']),
           );
            $result = $userModel->where($map)->find();
            if (!$result) {
                $this->checkLoginNum($data['name'],$clientIp);
            } else {

                if($result['errorNum']>=3&&$result['time']>time()-60*30&&$result['clientIp']==$clientIp){
                    $this->error("客官，请更换电脑或30分钟后再试哦！");
                }else {

                    Session::set('admin_id', $result['id']);
                    Session::set('admin_name', $result['name']);
                    Session::set('admin_role', $result['role']);
                    $userModel->update(array("errorNum" => 0,"id"=>$result['id']));
                    $this->success('登录成功！', 'index');
                }
            }
        }else{
            return  $this->fetch();
        }

    }

    public function pass(){
        $request = Request::instance();
        $this->is_logined();
        if($request->isPost()){
            $id=Session::get('admin_id');
            $model=Db::name("Admin");
            $info=$model->find($id);
            //var_dump(md5($request->param("oldPwd")));
            //var_dump($info['pwd']);die;
            if($info['pwd']==md5($request->param("oldPwd"))){
                $data=array("id"=>$id,"pwd"=>md5($request->param('pwd')));
                //var_dump($data);die;
                if($model->update($data)){
                    $this->success("密码修改成功");
                }{
                    $this->error("密码修改失败!");
                }
            }else{
                $this->error("原密码错误!");
            }

        }else{
            return $this->fetch();
        }
    }

    public function checkLoginNum($name,$clientIp){
        $userModel=Db::name("Admin");
        //var_dump($userModel->where("name='$name'")->find());die;
        if($info=$userModel->where("name='$name'")->find()){
            $data=array("clientIp"=>$clientIp,"time"=>time(),"errorNum"=>$info['errorNum']+1,"id"=>$info['id']);


            $userModel->update($data);
        }
        $this->error('登录失败');
    }

    public function logout()
    {
//        1.清除当前的session
        Session::clear();
//        2.跳转到登录页面
        $this->success('成功退出登录', 'login');

    }
}
