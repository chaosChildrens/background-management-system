<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-01-08
 * Time: 0:46
 */
namespace app\index\controller;
use think\Db;
use think\Request;

class Admin extends Base{
    public function index(){
        $role=array(
            "0"=>"管理员",
            "1"=>"经理",
            "2"=>"销售人员",
            "3"=>"售后人员",
        );
        $adminModel =Db::table('Admin');
        $adminList = $adminModel->alias('a')->join("dept d"," a.did=d.id")->field("a.*,d.name as dname")->paginate(10);	//分页查询
        $this->assign('role',$role);	//赋值分页输出
        $this->assign('adminList', $adminList);
        return $this->fetch();
    }

    public function add(){
        $this->is_logined();
        $request=Request::instance();
        if($request->isPost()){
            $model=Db::table("Admin");
            $data=$request->param();
            $data['pwd']=md5($data['pwd']);
            if($model->where(array("name"=>$data['name']))->count()){
                $this->error("用户名已存在！");
            }
            if($model->insert($data)){
                $this->success("添加成功！","index");
            }else{
                $this->error("添加失败");
            }
        }else{
            $deptList=Db::table("Dept")->select();
            $this->assign("deptList",$deptList);
            return $this->fetch();
        }
    }

    public function edit(){
        $this->is_logined();
        $request=Request::instance();
        $model=Db::table("Admin");
        if($request->isPost()){
            $data=$request->param();
            $data['pwd']=md5($data['pwd']);
            if($model->update($data)){
                $this->success("编辑成功！","index");
            }else{
                $this->error("编辑失败");
            }
        }else{
            $deptList=Db::table("Dept")->select();
            $admin=$model->find($request->param("id"));
            $this->assign("admin",$admin);
            $this->assign("deptList",$deptList);
            return $this->fetch();
        }
    }

    public function del(){
        $this->is_logined();
        $request=Request::instance();
        $model=Db::table("Admin");
        $id=$request->param("id");
        if($model->delete($id)){
            $this->success("删除成功！");
        }else{
            $this->error("删除失败");
        }
    }


}