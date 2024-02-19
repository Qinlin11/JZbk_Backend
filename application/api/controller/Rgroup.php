<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\model\Rgroup as RgroupModel;
class Rgroup extends Controller
{
    // 查询所有教研组
    public function index()
    {
        $res = (new RgroupModel())->index();
        return $res;
    }
    
    // 查看单个教研组
    public function click(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $res = (new RgroupModel())->click($nanoid);
        return $res;
    }
    
    // 修改成员权限
    // public function revise(Request $request)
    // {
    //     $gid = $request->param('gid');
    //     $num = $request->param('num');
    //     $name = $request->param('name');
    //     $id = $request->param('id');
    //     $res = (new RgroupModel())->revise($gid,$num,$name,$id);
    //     return $res;
    // }
    
    // 将成员移出
    public function del(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $name = $request->param('name');
        $res = (new RgroupModel())->del($nanoid,$name);
        return $res;
    }
    
    // 创建教研组
    public function add(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $name = $request->param('name');
        $introduce = $request->param('introduce');
        if(!$name){
            return;
        }else{
            $res = (new RgroupModel())->add($name,$introduce,$nanoid);
            return $res;
        }
        
    }
    

    // 判断我是不是这个教研组的创建者
    public function check(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $res = (new RgroupModel())->check($nanoid);
        return $res;
    }

    // 添加成员
    public function addNumber(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $id = $request->param('id');
        $res = (new RgroupModel())->addNumber($nanoid,$id);
        return $res;
    }

    // 搜索
    public function find(Request $request)
    {
        $name = $request->param('name');
        $res = (new RgroupModel())->find($name);
        return $res;
    }

    // 解散教研组
    public function dissolution(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $res = (new RgroupModel())->dissolution($nanoid);
        return $res;
    }

    // 发布通知
    public function notice(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $extent = $request->param('extent');
        $type = $request->param('type');
        $a = $request->param('time');
        $b = $request->param('time1');
        $nanoid1 = $request->param('nanoid1');
        $time = $a.'至'.$b;
        $res = (new RgroupModel())->notice($nanoid,$extent,$type,$time,$nanoid1);
        return $res;
    }

    // 渲染课程活动
    public function showNotice(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $res = (new RgroupModel())->showNotice($nanoid);
        return $res;
    }

    // 删除课程活动
    public function delNotice(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $nanoid1 = $request->param('nanoid1');
        $res = (new RgroupModel())->delNotice($nanoid,$nanoid1);
        return $res;
    }

    // 渲染研讨区
    public function showResearch(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $res = (new RgroupModel())->showResearch($nanoid);
        return $res;
    }

    // 创建研讨区
    public function createResearch(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $nanoid1 = $request->param('nanoid1');
        $path = $_FILES['path']['name'];
        $name = $_FILES['path']['tmp_name'];
        $arr = pathinfo($path);
        $suffix = $arr['extension'];
        if($suffix != 'pdf'){
            return;
        }
        $new_name = date('YmdHis',time()).rand(100,1000).'.'.$suffix;
        move_uploaded_file($name,'./uploads/gResearch/'.$new_name);
        $a = 'http://8.134.186.119/uploads/gResearch/'.$new_name;
        $res = (new RgroupModel())->createResearch($nanoid1,$a,$path,$nanoid);
        return $res;
    }

    // 参与教研
    public function joinResearch(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $nanoid1 = $request->param('nanoid1');
        $res = (new RgroupModel())->joinResearch($nanoid1,$nanoid);
        return $res;
    }

    // // 按照创建时间排序
    // public function createTime()
    // {
    //     $res = (new RgroupModel())->createTime();
    //     return $res;
    // }

    // // 按照名称排序
    // public function createName()
    // {
    //     $res = (new RgroupModel())->createName();
    //     return $res;
    // }

    // // 筛选出我创建的教研组
    // public function myGroup()
    // {
    //     $res = (new RgroupModel())->myGroup();
    //     return $res;
    // }

    // 教研组排序
    public function paixu(Request $request)
    {
        $identity = $request->param('identity');
        $time = $request->param('time');
        $res = (new RgroupModel())->paixu($identity,$time);
        return $res;
    }

    // 加入教研组
    public function enter(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $id = $request->param('id');
        $res = (new RgroupModel())->enter($nanoid,$id);
        return $res;
    }

    // 判断我是不是加入了别的教研组
    public function checkIdentity(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $res = (new RgroupModel())->checkIdentity($nanoid);
        return $res;
    }
}
