<?php
namespace app\index\controller;
use think\Db;
use think\Request;
class Dept extends Base{
    public function index(){
        $DeptModel =Db::name('Dept');
        $DeptList = $DeptModel->alias("d")->join("category c","d.cid=c.id")->field("d.*,c.name as cname")->paginate(10);
        $this->assign('DeptList', $DeptList);
        return $this->fetch();

    }
    public function add(){
        $this->is_logined();
        $request=Request::instance();
        if($request->isPost()){
            $model=Db::table("Dept");
            $data=$request->param();
            if($model->insert($data)){
                $this->success("添加成功！","index");
            }else{
                $this->error("添加失败");
            }
        }else{
            $cateList=Db::table("Category")->where("pid=0")->select();
            $this->assign("cateList",$cateList);
            return $this->fetch();
        }
    }

    public function edit(){
        $this->is_logined();
        $request=Request::instance();
        if($request->isPost()){
            $model=Db::table("Dept");
            $data=$request->param();
            if($model->update($data)){
                $this->success("修改成功！","index");
            }else{
                $this->error("修改失败");
            }
        }else{
            $id=$request->param("id");
            $info=Db::table("Dept")->find($id);
            $cateList=Db::table("Category")->where("pid=0")->select();
            $this->assign("info",$info);
            $this->assign("cateList",$cateList);
            return $this->fetch();
        }
    }
    public function del(){
        $this->is_logined();
        $request=Request::instance();
        $model=Db::table("Dept");
        $id=$request->param("id");
        if($model->delete($id)){
            $this->success("删除成功！");
        }else{
            $this->error("删除失败");
        }
    }
}