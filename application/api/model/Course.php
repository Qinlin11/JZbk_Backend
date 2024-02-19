<?php

namespace app\api\model;

use think\Model;

class Course extends Model
{
    protected $table = 'Course';
    
    // 渲染所有课程
    public function course()
    {
        $course = Course::table('Course')->select();
        return json($course);
    }
    
    // 用户选择
    public function select_course($id,$subject,$edition,$semester,$grade)
    {
        if($subject==1){
            $subject='语文';
        }else if($subject==2){
            $subject='数学';
        }else if($subject==3){
            $subject='英语';
        }
        
        if($edition==1){
            $edition='人教部编版';
        }else if($edition==2){
            $edition='人师大编版';
        }
        
        if($grade==1){
            $grade='一年级';
        }else if($grade==2){
            $grade='二年级';
        }else if($grade==3){
            $grade='三年级';
        }else if($grade==4){
            $grade='四年级';
        }else if($grade==5){
            $grade='五年级';
        }else if($grade==6){
            $grade='六年级';
        }else if($grade==7){
            $grade='七年级';
        }else if($grade==8){
            $grade='八年级';
        }else if($grade==9){
            $grade='九年级';
        }else if($grade==10){
            $grade='高一';
        }else if($grade==11){
            $grade='高二';
        }else if($grade==12){
            $grade='高三';
        }
        
        if($semester==1){
            $semester='上学期';
        }else if($semester==2){
            $semester='下学期';
        }
        

        if($id ==1){
            $school = '小学';
        }else if($id ==2){
            $school = '初中';
        }else if($id ==3){
            $school = '高中';
        }
        $b = [];
        $a =['subject'=>$subject,'school'=>$school,'edition'=>$edition,'grade'=>$grade,'semester'=>$semester];
        foreach ($a as $x=>$value){
            if($value==null){
                continue;
            }else{
                $b[$x] = $value;
            } 
        }
        $res = Course::table('Course')->where($b)->select();
        return json($res);
    }
    
    // 搜索框的功能
    public function research($subject)
    {
        $res = Course::table('Course')->where('subject',$subject)->select();
        return json($res);
    }
}
