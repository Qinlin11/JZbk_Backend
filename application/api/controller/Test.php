<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\model\Test as TestModel;
use think\Db;
use Mpdf\Mpdf;
// use think\facade\Request;

$GLOBALS['a'] = [];
class Test 
{
     public function index(Request $request)
    {
        $id = $request->param('id');
        $res = (new TestModel())->school(1);
        return $res;
    }
    
    
    // 简易版
    public function test(Request $request)
    {
        $subject = $request->param('subject');
        $id = $request->param('id');
        $edition = $request->param('edition');
        $grade = $request->param('grade');
        $semester = $request->param('semester');
        
        if (!$subject && !$edition && !$grade && !$semester) {
            $res = (new TestModel())->test($id=1); // 只传入一个id参数
            return $res;
        }else if(!$edition && !$grade && !$semester){
            $res = (new TestModel())->id_subject($id,$subject);  // 传入id和subject参数
            return $res;
        }else if(!$subject && !$grade && !$semester){
            $res = (new TestModel())->id_edition($id,$edition);  // 传入id和edition参数
            return $res;
        }else if(!$subject && !$edition && !$semester){
            $res = (new TestModel())->id_grade($id,$grade);  // 传入id和grade参数
            return $res;
        }else if(!$subject && !$edition && !$grade){
            $res = (new TestModel())->id_semester($id,$semester);  // 传入id和semester参数
            return $res;
        }else if(!$grade && !$semester){
            $res = (new TestModel())->id_subject_edition($id,$subject,$edition);  // 传入id,subject和edition参数
            return $res;
        }else if(!$edition && !$semester){
            $res = (new TestModel())->id_subject_grade($id,$subject,$grade);  // 传入id,subject和grade参数
            return $res;
        }else if(!$grade && !$edition){
            $res = (new TestModel())->id_subject_semester($id,$subject,$semester);  // 传入id,subject和semester参数
            return $res;
        }else if(!$subject && !$semester){
            $res = (new TestModel())->id_edition_grade($id,$grade,$edition);  // 传入id,grade和edition参数
            return $res;
        }else if(!$subject && !$grade){
            $res = (new TestModel())->id_edition_semester($id,$edition,$semester);  // 传入id,edition和semester参数
            return $res;
        }else if(!$subject && !$edition){
            $res = (new TestModel())->id_grade_semester($id,$grade,$semester);  // 传入id,grade和semester参数
            return $res;
        }else if(!$semester){
            $res = (new TestModel())->id_subject_edition_grade($id,$subject,$edition,$grade);  // 传入id,subject,edition和grade参数
            return $res;
        }else if(!$grade){
            $res = (new TestModel())->id_subject_edition_semester($id,$subject,$edition,$semester);  // 传入id,subject,edition和semester参数
            return $res;
        }else if(!$edition){
            $res = (new TestModel())->id_subject_grade_semester($id,$subject,$grade,$semester);  // 传入id,subject,grade和semester参数
            return $res;
        }else if(!$subject){
            $res = (new TestModel())->id_edition_grade_semester($id,$edition,$grade,$semester);  // 传入id,edition,grade和semester参数
            return $res;
        }else{
            $res = (new TestModel())->id_subject_edition_semester_grade($id,$subject,$edition,$semester,$grade);  // 传入id,subject,edition,grade和semester参数
            return $res;
        }
        
    }
    
    
    // 进阶版
    public function obj(Request $request)
    {
        $subject = $request->param('subject');
        $id = $request->param('id');
        $edition = $request->param('edition');
        $grade = $request->param('grade');
        $semester = $request->param('semester');
        
        $res = (new TestModel())->obj($id,$subject,$edition,$semester,$grade);  // 传入id,subject,edition,grade和semester参数
        return $res;
       
    }
    
    
    public function aaa(Request $request)
    {
        $subject = $request->param('subject');
        $res = (new TestModel())->research($subject); 
        return $res;
        
    }
    
    public function bbb(Request $request)
    {
    // $course_id = $request->param('course_id');
    // $res = (new TestModel())->bbb($course_id);
    // return $res;
    // 建表
    // for($i=1;$i<=68;$i++){
        $sql="CREATE TABLE IF NOT EXISTS `Group3`(
        `id` INT NOT NULL,
        `name` VARCHAR(10) NOT NULL,
        `pic` text NOT NULL,
        `sex` VARCHAR(5) NOT NULL,
        `datatime` date NOT NULL,
        `identity` VARCHAR(10) NOT NULL,
        `gid` int not NULL
        
     )ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
    $result = Db::execute($sql);
        // }
    
    // $a = $request->param('id');
    // $b = $request->param('name');
    // $c = $request->param('pic');
    // $d = $request->param('sex');
    // $e = $request->param('identity');
    $datatime = date("Y-m-d H:i:s");
    // $res = (new TestModel())->bbb($a,$b,$c,$d,$e,$datatime); 
    $res = (new TestModel())->bbb($datatime);
    return $res;
    }
       
    // 更新数据
    public function ccc(Request $request)
    {
        $a = $request->param('sum');
        $res = (new TestModel())->aaa($a);
        return $res;
    }
   
   
    public function hhhh(Request $request)
    {
        $id = $request->param('id');
        $name = $request->param('name');
        $res = (new TestModel())->hhhh($id,$name);
        return $res;
    }
    
    

    // 上传文件
    public function upFile(Request $request)
    {
        // file
        $filename = $_FILES['file']['name'];
        $temp_name = $_FILES['file']['tmp_name'];
        $arr = pathinfo($filename);
        $ext_suffix = $arr['extension'];
        $new_filename = date('YmdHis',time()).rand(100,1000).'.'.$ext_suffix;
        $a = move_uploaded_file($temp_name,'./uploads/'.$new_filename);
        // png
        // $pngname = $_FILES['png']['name'];
        // if(!$pngname){
        //     $pngname = null;
        // }else{
        //     $png_name = $_FILES['png']['tmp_name'];
        //     $pngArr = pathinfo($pngname);
        //     $png_suffix = $pngArr['extension'];
        //     // $new_filename = date('YmdHis',time()).rand(100,1000).'.'.$ext_suffix;
        //     $b = move_uploaded_file($png_name,'./uploads/lesson/'.$pngname);
        // }
        
        return $new_filename;
    }
    
    public function connect(Request $request)
    {
        // $filename = $_FILES['file']['name'];
        // // $filename = $_FILES['file']['name'];
        // if(!$filename){
        //     return 1111;
        // }else{
        //     $temp_name = $_FILES['file']['tmp_name'];
        //     $arr = pathinfo($filename);
        //     $ext_suffix = $arr['extension'];
        //     $new_filename = date('YmdHis',time()).rand(100,1000).'.'.$ext_suffix;
            move_uploaded_file($temp_name,'./uploads/'.$new_filename);
            $a = 'http://8.134.186.119/uploads/'.$new_filename;
            return $a;
        // }
        
    }
    
    public function read()
    {
        $title='教学设计';
        $content = '<a href="http://8.134.186.119/uploads/202212071025381000.png">'.'导学案'.'</a>';
        $res = (new TestModel())->read($title,$content);
        // return $res;
    }

    public function abc(Request $request)
    {
        // $id = $request->param('id');
        // $ftp_server="8.134.186.119";
        // $ftp_user_name="www_jsj202_com";
        // $ftp_user_pass="123456";
        // $filename = $_FILES['file']['name'];
        // $temp_name = $_FILES['file']['tmp_name'];
        // $arr = pathinfo($filename);
        // $ext_suffix = $arr['extension'];
        // $new_filename = date('YmdHis',time()).rand(100,1000).'.'.$ext_suffix;
        // $a = move_uploaded_file($temp_name,'./uploads/'.$new_filename);
        // // return json(['id'=>$id,'filename'=>$filename]);
        $res = (new TestModel())->abc();
        return $res;
        
    }

    public function b(Request $request)
    {
        
        $res = (new TestModel())->b();
        return $res;
    }

    public function add(Request $request)
    {
        // $cid = $request->param('cid');
        $res = (new TestModel())->add();
        return $res;
    }


    public function del()
    {
        $res = (new TestModel())->del();
        return $res;
        // for($i =1;$i<=10;$i++){
            // $sql="DROP TABLE `temporary`;";
            // $result = Db::execute($sql);
        // }
        // $time =  date('YmdHis',time());
        // for($i=1;$i<=68;$i++){
        //     print($time+$i.'<br>');
        // }
        
    }
    
    public function check()
    {
        $res = (new TestModel())->check();
        return $res;
    }

    public function try()
    {
        $res = (new TestModel())->try();
        return $res;
    }

    public function pdf()
    {
        $res = (new TestModel())->pdf();
        return $res;
    }

    public function lsh()
    {
        $time =  date('Y-m-d H:i:s');
        return $time;
    }
    public function zzx(Request $request)
    {
        // $Cid = $request->param('Cid');
        // $nanoid = $request->param('nanoid');
        $path = $_FILES['path']['name'];
        $name = $_FILES['path']['tmp_name'];
        $arr = pathinfo($path);
        $suffix = $arr['extension'];
        if($suffix != 'png'){
            return 1111;
        }
        // $new_name = date('YmdHis',time()).rand(100,1000).'.'.$suffix;
        // move_uploaded_file($name,'./uploads/research/'.$new_name);
        // $a = 'http://8.134.186.119/uploads/research/'.$new_name;
        // $res = (new TestModel())->zzx($a,$path);
        return $suffix;
    }

    public function paixu(Request $request)
    {
        $identity = $request->param('identity');
        $time = $request->param('time');
        $res = (new TestModel())->paixu($identity,$time);
        return $res;
    }
}
