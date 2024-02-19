<?php

namespace app\api\model;

use think\Model;

class Broadcast extends Model
{
    // 加入会议
    public function enter($cid)
    {
        $res = Broadcast::table('Broadcast')->where('id',$cid)->select();
        return json($res);
    }
    
    // 发起研讨
    public function start($cid,$name,$teacher)
    {
        $a = Broadcast::table('Broadcast')->select();
        $sum = count($a);
        $count = $sum+1;
        $data = ['id'=>$cid,'name'=>$name,'teacher'=>$teacher,'network'=>"https://rtc.mtu.plus:4443/?roomId=$count&displayName=$teacher"];
        $res = Broadcast::table('Broadcast')->insert($data);
        return json($res);
    }
}
