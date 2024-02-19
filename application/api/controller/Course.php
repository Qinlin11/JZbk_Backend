<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\model\Course as CourseModel; 

class Course 
{
    // 渲染所有课程
    public function index()
    {
         $res = (new CourseModel())->course();
         return $res;
    }
    
    // 用户选择
    public function select_course(Request $request)
    {
        $subject = $request->param('subject');
        $id = $request->param('id');
        $edition = $request->param('edition');
        $grade = $request->param('grade');
        $semester = $request->param('semester');
        $res = (new CourseModel())->select_course($id,$subject,$edition,$semester,$grade);  // 传入id,subject,edition,grade和semester参数
        return $res;
       
    }
    // 搜索框的功能
    public function research(Request $request)
    {
        $subject = $request->param('subject');
        $res = (new CourseModel())->research($subject); 
        return $res;
    }
}
