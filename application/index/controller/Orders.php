<?php
namespace app\index\controller;
use think\Db;
use think\Request;

class Orders extends Base{
    public function index(){
        $this->is_logined();
        $model=Db::table("Orders");
        $list = $model->order("time desc")->paginate(10);
        $this->assign("list",$list);
        return $this->fetch();
    }

    public function add(){
        $this->is_logined();
        $request=Request::instance();
        if($request->isPost()){
            $model=Db::table("Orders");
            $data=$request->param();
            $ginfo=Db::table("Product")->find($data['gid']);
            $cinfo=Db::table("Customer")->find($data['cid']);
            $data['cname']=$cinfo['name'];
            $data['gname']=$ginfo['name'];
            $data['price']=$ginfo['price'];
            $data['money']=$data['price']*$data['num'];
            $data["time"]=date("Y-m-d H:i:s",time());
            if($model->insert($data)){
              $this->success("添加成功！","index");
            }else{
                $this->error("添加失败");
            }
        }else{
            $product=Db::table("Product")->select();
            $customer=Db::table("Customer")->select();
            $this->assign("product",$product);
            $this->assign("customer",$customer);
           return $this->fetch();
        }
    }

    public function del(){
        $this->is_logined();
        $model=Db::table("Orders");
        $request=Request::instance();
        $data=$request->param();
        if($model->where($data)->delete()){
            $this->success("删除成功！","index");
        }else{
            $this->error("删除失败");
        }

    }



}