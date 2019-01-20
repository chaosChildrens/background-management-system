<?php
namespace app\index\controller;
use think\Db;
use think\Request;

class Repair extends Base{
    public function index(){
        $this->is_logined();
        $model=Db::table("Repair");
        $list = $model->order("isVIP,time desc")->paginate(10);
        $this->assign("status",array("待处理","处理中","已完成"));
        $this->assign("list",$list);
        return $this->fetch();
    }

    public function add(){
        $this->is_logined();
        $request=Request::instance();
        if($request->isPost()){
            $model=Db::table("Repair");
            $data=$request->param();
            $data["time"]=time();
            if($model->insert($data)){
              $this->success("添加成功！","index");
            }else{
                $this->error("添加失败");
            }
        }else{
           return $this->fetch();
        }
    }

    public function del(){
        $this->is_logined();
        $model=Db::table("Repair");
        $request=Request::instance();
        $data=$request->param();
        var_dump($data);
        if($model->where($data)->delete()){
            $this->success("删除成功！","index");
        }else{
            $this->error("删除失败");
        }

    }
    public function status(){
        $this->is_logined();
        $request=Request::instance();
        $model=Db::table("Repair");
        $id=$request->param("id");
        if($request->isPost()){
            $data=$request->param();
            if($model->update($data)){
                $this->success("操作成功！","index");
            }else{
                $this->error("操作失败");
            }
        }else{
            $this->assign("info",$model->find($id));
            return $this->fetch();
        }
    }


}