<?php
namespace app\index\controller;

use think\Db;
use think\Request;

class Category extends Base{
    public function index(){
        $cateModel=Db::table("Category");
        $cateList=$cateModel->select();
        $cateList=$this->unLimitedForLevel($cateList,"--");//Cate::unLimitedForLevel($cateList,"--");
        $this->assign("cateList",$cateList);
        return $this->fetch();
    }
    public function add(){
        $this->is_logined();
        $request=Request::instance();
        if($request->isPost()){
            $model=Db::table("Category");
            $data=$request->param();
            if($model->insert($data)){
                $this->success("添加成功！","index");
            }else{
                $this->error("添加失败");
            }
        }else{
            $pid=$request->param('pid',0,"intval");
            $this->assign("pid",$pid);
            return $this->fetch();
        }
    }

    public function edit(){
        $this->is_logined();
        $request=Request::instance();
        $model=Db::table("Category");
        if($request->isPost()){
            $data=$request->param();
            if($model->update($data)){
                $this->success("编辑成功！","index");
            }else{
                $this->error("编辑失败");
            }
        }else{
            $Category=$model->find($request->param("id"));
            $this->assign("info",$Category);
            return $this->fetch();
        }
    }

    public function del(){
        $this->is_logined();
        $request=Request::instance();
        $model=Db::table("Category");
        $id=$request->param("id");
        if($model->delete($id)){
            $this->success("删除成功！");
        }else{
            $this->error("删除失败");
        }
    }

    static public function unLimitedForLevel($array,$str='--',$pid=0,$lv=0){
        $arr = array();

        foreach($array as $v){
            if($v['pid']==$pid){
                $v['level']=$lv+1;
                $v['str'] = str_repeat("&nbsp;&nbsp;&nbsp;",$lv).str_repeat($str,$lv);
                $arr[] = $v;
                $arr = array_merge($arr,self::unLimitedForLevel($array,$str,$v['id'],$lv+1));
            }
        }
        return $arr;

    }
    //无限分类列表 组合二维或多维数组。
    static public function unlimitedForLayer($cate,$name='child',$pid=0){
        $arr=array();
        foreach($cate as $v){
            if($v['pid']==$pid){
                $v[$name]=self::unlimitedForLayer($cate,$name,$v['id']);
                $arr[]=$v;
            }
        }
        return $arr;
    }

    //通过子分类id或取全部祖先
    static  public function  getParents($cate,$id){
        $arr=array();
        foreach ($cate as $v){
            if($v['id']==$id){
                $arr[]=$v;
                $arr=array_merge(self::getParents($cate,$v['pid']),$arr);
            }
        }
        return $arr;
    }
    //通过父ID，返回所有子分类。
    static  public function getChilds($cate,$pid){
        $arr=array();
        foreach($cate as $v){
            if($v['pid']==$pid){
                $arr[]=$v;
                $arr=array_merge($arr,self::getChilds($cate,$v['id']));
            }
        }
        return $arr;
    }
    //通过父ID，返回所有子分类ID。
    static  public function getChildsId($cate,$pid){
        $arr=array();
        foreach($cate as $v){
            if($v['pid']==$pid){
                $arr[]=$v['id'];
                $arr=array_merge($arr,self::getChildsId($cate,$v['id']));
            }
        }
        return $arr;
    }
}
