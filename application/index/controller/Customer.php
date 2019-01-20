<?php
/**
 * Created by PhpStorm.
 * User: Customeristrator
 * Date: 2019-01-08
 * Time: 0:46
 */
namespace app\index\controller;
use think\Db;
use think\Request;

class Customer extends Base{
    public function index(){

        $CustomerModel =Db::table('Customer');
        $CustomerList = $CustomerModel->paginate(10);	//分页查询
        $this->assign('CustomerList', $CustomerList);
        return $this->fetch();
    }

    public function add(){
        $this->is_logined();
        $request=Request::instance();
        if($request->isPost()){
            $model=Db::table("Customer");
            $data=$request->param();
            if($model->insert($data)){
                $this->success("添加成功！","index");
            }else{
                $this->error("添加失败");
            }
        }else{
            return $this->fetch();
        }
    }

    public function edit(){
        $this->is_logined();
        $request=Request::instance();
        $model=Db::table("Customer");
        if($request->isPost()){
            $data=$request->param();
            if($model->update($data)){
                $this->success("编辑成功！","index");
            }else{
                $this->error("编辑失败");
            }
        }else{

            $Customer=$model->find($request->param("id"));
            $this->assign("info",$Customer);
            return $this->fetch();
        }
    }

    public function del(){
        $this->is_logined();
        $request=Request::instance();
        $model=Db::table("Customer");
        $id=$request->param("id");
        if($model->delete($id)){
            $this->success("删除成功！");
        }else{
            $this->error("删除失败");
        }
    }


}