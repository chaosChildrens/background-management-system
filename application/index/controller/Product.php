<?php
namespace app\index\controller;
use think\Db;
use think\Request;

class Product extends Base{
    public function index(){
        $this->is_logined();
        $model=Db::table("Product");
        $list = $model->alias("p")->join("category c","p.cid=c.id")->field("p.*,c.name cname")->paginate(10);
        $this->assign("list",$list);
        return $this->fetch();
    }

   

    
    public function add(){
        $this->is_logined();
        $request=Request::instance();
        if($request->isPost()){
            $model=Db::table("Product");
            $data=$request->param();
            $file=$request->file("pic");
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'Uploads');
                if($info){
                   $data['pic']=$info->getSaveName();
                }else{
                    echo $file->getError();
                }
            }
            if($model->insert($data)){
              $this->success("添加成功！","index");
            }else{
                $this->error("添加失败");
            }
        }else{
            $cateList=Db::table("Category")->select();
            $arr=$this->unLimitedForLevel($cateList);
            $this->assign("cateList",$arr);
           return $this->fetch();
        }
    }

    public function del(){
        $this->is_logined();
        $model=Db::table("Product");
        $request=Request::instance();
        $data=$request->param();
        if($model->where($data)->delete()){
            $this->success("删除成功！","index");
        }else{

            $this->error("删除失败");
        }

    }
    public function edit(){
        $this->is_logined();
        $request=Request::instance();
        $model=Db::table("Product");
        $id=$request->param("id");
        if($request->isPost()){
            $data=$request->param();
            $file=$request->file("pic");
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'Uploads');
                if($info){
                    $data['pic']=$info->getSaveName();
                }else{
                    echo $file->getError();
                }
            }
            if($model->update($data)){
                $this->success("操作成功！","index");
            }else{
                $this->error("操作失败");
            }
        }else{
            $cateList=Db::table("Category")->select();
            $arr=$this->unLimitedForLevel($cateList);
            $this->assign("cateList",$arr);
            $this->assign("info",$model->find($id));
            return $this->fetch();
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


}