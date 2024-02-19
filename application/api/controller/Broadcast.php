<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\model\Broadcast as BroadcastModel;

class Broadcast 
{
    // 加入会议
    public function enter(Request $request)
    {
        $cid = $request->param('cid');
        $res = (new BroadcastModel())->enter($cid);
        return $res;
    }
    
    // 发起研讨
    public function start(Request $request)
    {
        $cid = $request->param('cid');
        $name = $request->param('name');
        $teacher = $request->param('teacher');
        if(!$name||!$teacher){
            return;
        }
        $res = (new BroadcastModel())->start($cid,$name,$teacher);
        return $res;
    }
}
