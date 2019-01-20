<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Loader;
use think\PHPExcel_IOFactory;
use think\PHPExcel;
//use PHPExcel_Cell;
class Order extends Controller {
    public function test() {
        return $this->fetch();
    }
    //测试专用方法，
    public function newhtml(){        
    }
    public function index() {
//SQL查询
//            $res=Db::query("select * from think_sales");
//            dump($res);
        $orders = Db::query('select * from product');
       
//        $page= Db::name('sales')->where('pid', '>', 0)->paginate(10, 20);
//        $this->assign('page', $page);
//        dump($orders);
//        $mod = new \app\index\model\Blogmsg();
//        $mo = $mod->paginate(2, 10);
//        $this->assign('list', $mo);
			
			$det = input('post.delete');
			if(!is_null($det)){
				Db::table('product')->where('pid',$det)->delete();

				$orders = Db::query('select * from product');
				
			}

		$this->assign('orders', $orders);
        return $this->fetch();
		
		
    }
    public function import() {
//        import('vendor.PHPExcel.PHPExcel');
        vendor("PHPExcel.PHPExcel.PHPExcel");
        vendor("PHPExcel.PHPExcel.IOFactory");
        $phpexcel = new \PHPExcel();
        $objWriter = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
//        Loader::import('PHPExcel.Classes.PHPExcel');
//        Loader::import('PHPExcel.Classes.PHPExcel.IOFactory.PHPExcel_IOFactory');
//        Loader::import('PHPExcel.Classes.PHPExcel.Reader.Excel5');
        //获取表单上传文件
        $file = request()->file('excel');
        $info = $file->validate(['ext' => 'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            if (empty($info)) {
                return $this->error('导入失败!');
            }
            $exclePath = $info->getSaveName();  //获取文件名
            //上传文件的地址
            $filename = ROOT_PATH . 'public' . DS . 'uploads' . DS . $exclePath;
            //判断版本
            //Warning: ZipArchive::getFromName() [ziparchive.getfromname]: Invalid or unitialized ，这里加上这个判断就可以了
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if ($extension == 'xlsx') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
                //加载文件内容,编码utf-8
                $objPHPExcel = $objReader->load($filename, $encode = 'utf-8');
            } else if ($extension == 'xls') {
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
                $objPHPExcel = $objReader->load($filename, $encode = 'utf-8');
            } else {
                return error('请上传excel格式的文件!');
            }
            $excel_array = $objPHPExcel->getsheet(0)->toArray();   //转换为数组格式
            array_shift($excel_array);  //删除第一个数组(标题);
            $data = [];
            foreach ($excel_array as $k => $v) {
                //data数组根据你表字段自行修改，这里Excel文件里的字段要跟表一致
                $data[$k]['id'] = $v[0];
                $data[$k]['cid'] = $v[1];
                $data[$k]['name'] = $v[2];
                $data[$k]['pic'] = $v[3];
                $data[$k]['barcode'] = $v[4];
                $data[$k]['price'] = $v[5];
                $data[$k]['sale'] = $v[6];
            }
            if (Db::table('product')->insertAll($data)) {//批量插入数据
                return $this->success('导入成功');
            } else {
                return error('导入数据失败!');
            }
        } else {
            return error('导入失败!');
        }
    }

//    public function News() {
//        return $this->fetch();
//    }
    public function News() {
        $id = input('param.id');
        $cid = input('param.cid');
        $name = input('param.name');
        $pic = input('param.pic');
        $number = input('param.number');
        $barcode = input('param.barcode');
        $sale = input('param.sale');
        if ($pid <> '') {
            $res = Db::table('think_sales')
                    ->insert(['id' => $id, 'cid' => $cid, 'name' => $name, 'pic' => $pic, 'barcode' => barcode, 'price' => $price,
                'sale' => $sale,]);
//            dump($result);
            if ($res) {
                return $this->success('更新成功^_^');
            } else {
                return $this->error('更新失败');
            }
        }
        return $this->fetch();
    }

    public function update2() {
        $data['account'] = Request::instance()->param('account');
        $data['password'] = Request::instance()->param('password');
//存储提交上来的数据
        $res = db('product')->insert($data);
        if ($res) {
            return "订单添加成功";
        } else {
            return "添加失败";
        }
        return $this->fetch();
    }

//    public function delete() {
//        $res = Db::execute('delete from orderinfo where sID = "' . $_GET['id'] . '" ');
//        $data = Db::table('product')->select();
//        $this->assign('res', $data);
//        return $this->fetch('pd');
//    }

//导入
}

