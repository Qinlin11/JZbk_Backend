<?php

namespace app\api\model;

use think\Model;

class Research extends Model
{
    protected $table = 'Research';  // 研讨组表
    protected $table_one = 'Member'; // 未加入研讨组的成员表
    protected $table_two = 'Course';  // 课程表的数据
    // 研讨组全部的成员信息
    public function index()
    {
        $user = Research::table('Research')->select();
        return json($user);
    }
    
    // 删除成员
    public function del($id,$name)
    {
        $res = Research::table('Research')->where('id',$id)->where('name',$name)->delete();
        return json($res);
    }
    
    // 添加成员
    public function add()
    {
        // $user = Research::table('Member')->select(); // 查看第二张表的数据
        // return json($user);
        
        $user = Research::table('Course')->select(); // 查看第二张表的数据
        // $sum = count($user);
        // for($i=1;$i<=$sum;$i++){
        //     echo $i;
        // }

    }
}
