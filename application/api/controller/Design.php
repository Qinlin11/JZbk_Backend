<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\model\Design as DesignModel;

class Design extends Controller
{
    // 展示对应课程
    public function index(Request $request)
    {
        $cid = $request->param('cid');
        $res = (new DesignModel())->index($cid);
        return $res;
    }

    // 教学设计
    public function design(Request $request)
    {
        $cid = $request->param('cid');
        $uid = $request->param('uid');
        $analysis = $request->param('analysis');
        $tool = $request->param('tool');
        $resources = $request->param('resource');
        $aim = $request->param('aim');
        $method = $request->param('method');
        $difficult = $request->param('difficult');
        $process = $request->param('process');
        $saim = $request->param('saim');
        $sdifficult = $request->param('sdifficult');
        $sresources = $request->param('sresources');
        $explore = $request->param('explore');
        $link = $request->param('link');
        $introduce = $request->param('introduce');
        $sprocess = $request->param('sprocess');
        $reflect = $request->param('reflect');
        $nanoid = $request->param('nanoid');
        $res = (new DesignModel())->design($cid,$uid,$analysis,$tool,$resources,$aim,$method,$difficult,$process,$saim,$sdifficult,$sresources,$explore,$link,$introduce,$sprocess,$reflect,$nanoid);
        return $res;
    }

    // 渲染我的教学设计
    public function look(Request $request)
    {
        $cid = $request->param('cid');
        $res = (new DesignModel())->look($cid);
        return $res;
    }


    public function lesson(Request $request)
    {
        $cid = $request->param('cid');
        $uid = $request->param('uid');
        $lPath = $_FILES['lPath']['name'];
        $lName = $_FILES['lPath']['tmp_name'];
        $lArr = pathinfo($lPath);
        $lSuffix = $lArr['extension'];
        $new_lname = date('YmdHis',time()).rand(100,1000).'.'.$lSuffix;
        move_uploaded_file($lName,'./uploads/lesson/'.$new_lname);
        $a = 'http://8.134.186.119/uploads/lesson/'.$new_lname; 
        $res = (new DesignModel())->lesson($cid,$uid,$a);
        return $res;
    }

    public function courseware(Request $request)
    {
        $cid = $request->param('cid');
        $uid = $request->param('uid');
        $cPath = $_FILES['cPath']['name'];
        $cName = $_FILES['cPath']['tmp_name'];
        $cArr = pathinfo($cPath);
        $cSuffix = $cArr['extension'];
        $new_cname = date('YmdHis',time()).rand(100,1000).'.'.$cSuffix;
        move_uploaded_file($cName,'./uploads/courseware/'.$new_cname);
        $b = 'http://8.134.186.119/uploads/courseware/'.$new_cname;
        $res = (new DesignModel())->courseware($cid,$uid,$b);
        return $res;
    }

    public function reflect(Request $request)
    {
        $cid = $request->param('cid');
        $uid = $request->param('uid');
        $rPath = $_FILES['rPath']['name'];
        $rName = $_FILES['rPath']['tmp_name'];
        $rArr = pathinfo($rPath);
        $rSuffix = $rArr['extension'];
        $new_rname = date('YmdHis',time()).rand(100,1000).'.'.$rSuffix;
        move_uploaded_file($rName,'./uploads/reflect/'.$new_rname);
        $c = 'http://8.134.186.119/uploads/reflect/'.$new_rname;
        $res = (new DesignModel())->reflect($cid,$uid,$c);
        return $res;
    }

    public function video(Request $request)
    {
        $cid = $request->param('cid');
        $uid = $request->param('uid');
        $vPath = $_FILES['vPath']['name'];
        $vName = $_FILES['vPath']['tmp_name'];
        $vArr = pathinfo($vPath);
        $vSuffix = $vArr['extension'];
        $new_vname = date('YmdHis',time()).rand(100,1000).'.'.$vSuffix;
        move_uploaded_file($vName,'./uploads/video/'.$new_vname);
        $d = 'http://8.134.186.119/uploads/video/'.$new_vname;
        $res = (new DesignModel())->video($cid,$uid,$d);
        return $res;
    }
    
    // 删除教学设计
    public function del(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $res = (new DesignModel())->del($nanoid);
        return $res;
    }

    // 继续备课
    public function cont(Request $request)
    {
        $nanoid = $request->param('nanoid');
        $res = (new DesignModel())->cont($nanoid);
        return $res;
    }
}
