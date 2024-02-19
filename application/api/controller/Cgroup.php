<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\model\Cgroup as CgroupModel;

class Cgroup 
{
    // 查看单个课程教研
    public function index(Request $request)
    {
        $Cid = $request->param('Cid');
        $res = (new CgroupModel())->index($Cid);
        return $res;
    }

    // 渲染成员
    public function show()
    {
        $res = (new CgroupModel())->show();
        return $res;
    }

    // 添加成员
    public function add(Request $request)
    {
        $Cid = $request->param('Cid');
        $id = $request->param('id');
        $res = (new CgroupModel())->add($Cid,$id);
        return $res;
    }

    // 加入课程教研
    public function join(Request $request)
    {
        $Cid = $request->param('Cid');
        $id = $request->param('id');
        $res = (new CgroupModel())->join($Cid,$id);
        return $res;
    }

    // 判断我在不在这个课程教研里面
    public function check(Request $request)
    {
        $Cid = $request->param('cid');
        $res = (new CgroupModel())->check($Cid);
        return $res;
    }

    // 搜索
    public function find(Request $request)
    {
        $name = $request->param('name');
        $res = (new CgroupModel())->find($name);
        return $res;
    }

    // 渲染教研组
    public function rendering()
    {
        $res = (new CgroupModel())->rendering();
        return $res;
    }

    // 协同教研组
    public function addGroup(Request $request)
    {
        $Cid = $request->param('cid');
        $nanoid = $request->param('nanoid');
        $res = (new CgroupModel())->addGroup($Cid,$nanoid);
        return $res;
    }

    // 发布通知
    public function notice(Request $request)
    {
        $Cid = $request->param('Cid');
        $extent = $request->param('extent');
        $type = $request->param('type');
        $a = $request->param('time');
        $b = $request->param('time1');
        $nanoid = $request->param('nanoid');
        $time = $a.'至'.$b;
        $res = (new CgroupModel())->notice($Cid,$extent,$type,$time,$nanoid);
        return $res;
    }

    // 渲染课程活动
    public function showNotice(Request $request)
    {
        $Cid = $request->param('Cid');
        $res = (new CgroupModel())->showNotice($Cid);
        return $res;
    }

    // 删除课程活动
    public function delNotice(Request $request)
    {
        $Cid = $request->param('Cid');
        $nanoid = $request->param('nanoid');
        $res = (new CgroupModel())->delNotice($Cid,$nanoid);
        return $res;
    }

    // 渲染研讨区
    public function showResearch(Request $request)
    {
        $Cid = $request->param('Cid');
        $res = (new CgroupModel())->showResearch($Cid);
        return $res;
    }

    // 创建研讨区
    public function createResearch(Request $request)
    {
        $Cid = $request->param('Cid');
        $nanoid = $request->param('nanoid');
        $path = $_FILES['path']['name'];
        $name = $_FILES['path']['tmp_name'];
        $arr = pathinfo($path);
        $suffix = $arr['extension'];
        if($suffix != 'pdf'){
            return;
        }
        $new_name = date('YmdHis',time()).rand(100,1000).'.'.$suffix;
        move_uploaded_file($name,'./uploads/research/'.$new_name);
        $a = 'http://8.134.186.119/uploads/research/'.$new_name;
        $res = (new CgroupModel())->createResearch($Cid,$a,$path,$nanoid);
        return $res;
    }

    // 参与教研
    public function joinResearch(Request $request)
    {
        $Cid = $request->param('Cid');
        $nanoid = $request->param('nanoid');
        $res = (new CgroupModel())->joinResearch($Cid,$nanoid);
        return $res;
    }

    // 渲染与我有关的课程教研
    public function showCourse()
    {
        $res = (new CgroupModel())->showCourse();
        return $res;
    }
    
    // 创建课程教研
    public function createCourse(Request $request)
    {
        $period = $request->param('period');      // 学段
        $subject = $request->param('subject');    // 学科
        $grade = $request->param('grade');        // 年级
        $edition = $request->param('edition');    // 版本
        $semester = $request->param('semester');  // 学期
        $res = (new CgroupModel())->createCourse($period,$subject,$edition,$semester,$grade);  
        return $res;
    }

    // 发起协同
    public function launch(Request $request)
    {
        $Cid = $request->param('Cid');
        $res = (new CgroupModel())->launch($Cid);  
        return $res;
    }

    // 我的协同搜索功能实现
    public function search(Request $request)
    {
        $subject = $request->param('subject');
        $id = $request->param('id');
        $edition = $request->param('edition');
        $grade = $request->param('grade');
        $semester = $request->param('semester');
        $res = (new CgroupModel())->search($id,$subject,$edition,$semester,$grade);  // 传入id,subject,edition,grade和semester参数
        return $res;
    }

    // 判断是否已经发起了协同
    public function judge(Request $request)
    {
        $Cid = $request->param('Cid');
        $res = (new CgroupModel())->judge($Cid);  
        return $res;
    }
}
