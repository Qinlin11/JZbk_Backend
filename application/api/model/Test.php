<?php

namespace app\api\model;

use think\Model;
use think\db\where;
use Mpdf\Mpdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Test extends Model
{
  
    protected $table = 'Course';
    public function index($id)
    {
        $res = Course::table('Course')->where('id',$id)->select();
        return json($res);
    }
    
    public function test($id)
    {
        $res = Course::table('Course')->where('id',$id)->select();
        return json($res);
    }
    
    public function id_subject($id,$subject)
    {
        $res = Course::table('Course')->where('id',$id)->where('subject',$subject)->select();
        return json($res);
    }
    
    public function id_edition($id,$edition)
    {
        $res = Course::table('Course')->where('id',$id)->where('edition',$edition)->select();
        return json($res);
    }
    
    public function id_grade($id,$grade)
    {
        $res = Course::table('Course')->where('id',$id)->where('grade',$grade)->select();
        return json($res);
    }
    
    public function id_semester($id,$semester)
    {
        $res = Course::table('Course')->where('id',$id)->where('semester',$semester)->select();
        return json($res);
    }
    
    public function id_subject_edition($id,$subject,$edition)
    {
        $res = Course::table('Course')->where('id',$id)->where('subject',$subject)->where('edition',$edition)->select();
        return json($res);
    }
    
    public function id_subject_grade($id,$subject,$grade)
    {
        $res = Course::table('Course')->where('id',$id)->where('subject',$subject)->where('grade',$grade)->select();
        return json($res);
    }
    
    public function id_subject_semester($id,$subject,$semester)
    {
        $res = Course::table('Course')->where('id',$id)->where('subject',$subject)->where('semester',$semester)->select();
        return json($res);
    }
    
    public function id_edition_grade($id,$grade,$edition)
    {
        $res = Course::table('Course')->where('id',$id)->where('grade',$grade)->where('edition',$edition)->select();
        return json($res);
    }
    
    public function id_edition_semester($id,$edition,$semester)
    {
        $res = Course::table('Course')->where('id',$id)->where('edition',$edition)->where('semester',$semester)->select();
        return json($res);
    }
    
    public function id_grade_semester($id,$grade,$semester)
    {
        $res = Course::table('Course')->where('id',$id)->where('grade',$grade)->where('semester',$semester)->select();
        return json($res);
    }
    
    public function id_subject_edition_grade($id,$subject,$edition,$grade)
    {
        $res = Course::table('Course')->where('id',$id)->where('subject',$subject)->where('edition',$edition)->where('grade',$grade)->select();
        return json($res);
    }
    
    public function id_subject_edition_semester($id,$subject,$edition,$semester)
    {
        $res = Course::table('Course')->where('id',$id)->where('subject',$subject)->where('edition',$edition)->where('semester',$semester)->select();
        return json($res);
    }
    
    public function id_subject_grade_semester($id,$subject,$grade,$semester)
    {
        $res = Course::table('Course')->where('id',$id)->where('subject',$subject)->where('grade',$grade)->where('semester',$semester)->select();
        return json($res);
    }
    
    public function id_edition_grade_semester($id,$edition,$grade,$semester)
    {
        $res = Course::table('Course')->where('id',$id)->where('edition',$edition)->where('grade',$grade)->where('semester',$semester)->select();
        return json($res);
    }
    
    public function id_subject_edition_semester_grade($id,$subject,$edition,$semester,$grade)
    {
        $res = Course::table('Course')->where('id',$id)->where('subject',$subject)->where('edition',$edition)->where('semester',$semester)->where('grade',$grade)->select();
        return json($res);
    }
    
    
    
    // 测试
    public function obj($id,$subject,$edition,$semester,$grade)
    {

        $b = [];
        $a =['subject'=>$subject,'id'=>$id,'edition'=>$edition,'grade'=>$grade,'semester'=>$semester];
        
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
    
    
    
    // 搜索接口
    public function research($subject)
    {
        $res = Course::table('Course')->where('subject',$subject)->select();
        return json($res);
    }
    
    
    public function bbb($datatime)
    {
        // $res = Test::table("`libai_bank_record$course_id`")->select();
        // if(count($res)==0){
        //     return error;
        // }else{
        //     return json($res);
        // }
        
        //插入数据
        
        for($i=1;$i<=68;$i++){
            // $data = ['id'=>3,'name'=>'rookie','pic'=>'http://8.134.186.119:8888/down/zax5LwGVXZVx.png','sex'=>'男','identity'=>'成员','datatime'=>$datatime,'cid'=>$i];
            // $res = Course::table("Cgroup$i")->insert($data);
            $data = ['sex'=>'女'];
            $res = Course::table("Cgroup$i")->where('id',2)->setField($data);
        }
       
        return $res;
    }
    
    
    // 更新数据
    public function aaa($a)
    {
        $data = ['sum'=>$a];
        $res = Course::table('Research_group')->where('research_id',4)->setField($data);
        return $res;
    }
    
    public function kkk()
    {
        for($i=1;$i<=4;$i++){
           $res = Test::table('Research')->where('tttt',0)->setField('tttt',$i);
        }
    }
    
    public function hhhh($id,$name)
    {
        return "https://rtc.mtu.plus:4443/?roomId=$id&displayName=$name";
    }
    
    
    public function abc()
    {
        // $data = ['id'=>$id,'name'=>$filename];
        $res = Test::table('Design')->where('id',2)->select();
        // $a = $res[0]['name'];
       
        return json($res);
        
    }
        
    public function read($title,$content)
    {
        $pdf = new Mpdf(); 
        $pdf->SetTitle($title);
        $pdf->SetMargins('10', '10', '10');
        $pdf->SetAutoPageBreak(TRUE, '15');
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        $pdf->AddPage();
        $pdf->SetFont('stsongstdlight', '', 14, '', true);

        //标题
        $title = '<h1 style="text-align: center;">' . $title . '</h1>';

        $pdf->WriteHTML($title.'<h2>教学准备</h2>'.'<p>学情分析:'.$content.'</p>'.'<p>教学工具:'.$content.'</p>'.'<p>教学资源:'.$content.'</p>'.'<h2>教学设计</h2>'.'<p>教学目的:'.$content.'</p>'.'<p>教学方法:'.$content.'</p>'.'<p>教学重难点:'.$content.'</p>'.'<p>教学过程:'.$content.'</p>'.'<h2>教学准备</h2>'.'<p>学习目标:'.$content.'</p>'.'<p>重难点预测:'.$content.'</p>'.'<p>预习资源:'.$content.'</p>'.'<p>互动探究:'.$content.'</p>'.'<p>知识链接:'.$content.'</p>'.'<p>学法指导:'.$content.'</p>'.'<p>学习过程:'.$content.'</p>'.'<p>教案资源:'.$content.'</p>'.'<p>反思:'.'<p>课件资源:'.$content.'</p>'.'<p>上传的反思:'.$content.'</p>'.'<p>课堂实录:'.$content.'</p>');
        $path="./uploads/pdf/".'1111.pdf';
        // $pdf->Output($path,'F');
        $pdf->Output();
        exit();
        return $path;
    }

    public function a()
    {
        $res = Test::table('path')->select();
        $b = array('1');
        $sum = count($res);
        for($i = 0;$i<$sum;$i++){
            // print($res[$i]['datetime'].'<br>'); 
            $a = $res[$i]['datetime'];
            $b = array_unshift($b,$a);
        }
        print($b);
        // return $res;
    }

    public function b()
    {
        $res = Test::table('path')->where('cid',1)->select();
        if($res=='[]'){
            $a = '';
            $b = '';
            $c = '';
            $d = '';
        }else{
            $a = $res[0]['lPath'];
            $b = $res[0]['cPath'];
            $c = $res[0]['rPath'];
            $d = $res[0]['vPath'];  
        }
        // print('$a'.$a.'<br>');
        // print('$b'.$b.'<br>');
        // print('$c'.$c.'<br>');
        // print('$d'.$d.'<br>');
        if($a){
            $ltext = '<a href="'.$a.'">'.'教案下载'.'</a>';
        }else{
            $ltext = $res[0]['lPath'];
        }

        if($b){
            $ctext = '<a href="'.$b.'">'.'课件下载'.'</a>';
        }else{
            $ctext = $res[0]['cPath'];
        }

        if($c){
            $rtext = '<a href="'.$c.'">'.'教案下载'.'</a>';
        }else{
            $rtext = $res[0]['rPath'];
        }

        if($d){
            $vtext = '<a href="'.$d.'">'.'教案下载'.'</a>';
        }else{
            $vtext = $res[0]['vPath'];
        }

        print('$ltext'.$ltext.'<br>');
        print('$ctext'.$ctext.'<br>');
        print('$rtext'.$rtext.'<br>');
        print('$vtext'.$vtext.'<br>');
    }

    public function add()
    {
        // $datetime = date("Y-m-d H:i:s");
        // $data = Test::table('test')->select();
        // $count = count($data);
        // for($i=0;$i<$count;$i++){
        //     $name = $data[$i]['name'];
        //     $pic = $data[$i]['pic'];
        //     $sex = $data[$i]['sex'];
        //     $arr = ['id'=>3,'name'=>$name,'pic'=>$pic,'sex'=>$sex,'datatime'=>$datetime,'identity'=>'成员','cid'=>$cid];
        //     $res = Test::table("test1")->insert($arr);
        //     print($res);
        // }
        // $name = $data[0]['name'];
        // $pic = $data[0]['pic'];
        // $datetime = date("Y-m-d H:i:s");
        // $arr = ['id'=>3,'name'=>$name,'pic'=>$pic,'sex'=>'男','datatime'=>$datetime,'identity'=>'成员','cid'=>$cid];
        // $res = Test::table("Cgroup$cid")->insert($arr);
        // return $res;
        // $name = ['骆建武','梁浩文','朱时泽','陈子昊','简健超','邓家晖','李盛厚'];
        // $picArr = ['http://8.134.186.119:8888/down/Ibj6aVBZ4J8g.png','http://8.134.186.119:8888/down/s31oWSyk6YcY.png','http://8.134.186.119:8888/down/xOYjNKhUgWDE.png','http://8.134.186.119:8888/down/zM3we3qV4QmE.png','http://8.134.186.119:8888/down/SpRlXTiJd22Q.png','http://8.134.186.119:8888/down/gkTGdSsNXxMs.png'];
        // $xing = ['王','李','张','刘','陈','杨','黄','赵','吴','周','徐','孙','马','朱','胡','郭','何','林','罗','高','郑','梁','谢','宋','唐','许','韩','邓','冯','曹','彭','曾','肖','田','董','潘'];
        // $ming = ['涛','涵','航','昊','皓','恒','宏','华','家','嘉','建','景','君','俊','龙','明','铭','楠','清','然','瑞','睿','润','山','圣','媛','天','文','诗','晨','梓','玉','娜','承','峰','贤','潇','鑫','旭','彦','一','奕','毅','子','瑜','宇','雨','渊','源','云','泽'];
        // $zi = ['聚','军','兵','忠','廷','邦','福','瑞','晨','州','言','宜','星','营','琪','婷','丹','丽','云','亚','佳','倩','兰','凤','华','君','嘉','娜','娟','莉','莹','萍','蓉','锦','雅','雪','雯','霞','青','静','颖','香'];
        // $sex = ['男','女'];
        // for($i=0;$i<=99;$i++){
        //     $n = rand(0,35);
        //     $m = rand(0,50);
        //     $z = rand(0,41);
        //     $s = rand(0,5);
        //     $x = rand(0,1);
        //     $a = $xing[$n].$ming[$m].$zi[$z];
        //     $b = $picArr[$s];
        //     $data = ['id'=>$i+1,'name'=>$a,'pic'=>$b,'identity'=>'成员','sex'=>$sex[$x]];
        // //     $res = Test::table('Member')->insert($data);
        // }
        // return $res;
    }

    public function del()
    {
        // $res = Test::table('Member')->where('id',1)->select();
        // $a = $res[0]['name'];
        // $b = $res[0]['pic'];
        // $c = $res[0]['sex'];
        // $datetime = date("Y-m-d H:i:s");
        // $arr = ['id'=>3,'name'=>$a,'pic'=>$b,'sex'=>$c,'datatime'=>$datetime,'identity'=>'成员','cid'=>68];
        // $data = Test::table('Cgroup68')->insert($arr);
        // return json($data);
        // for($i = 1;$i<=32;$i++){
        //     // $a = ['id'=>5,'name'=>'卢瑶瑶','pic'=>'http://8.134.186.119:8888/down/pajeqHTkVbRB.png','sex'=>'女','datatime'=>$datetime,'identity'=>'创建者','cid'=>$i,'email'=>'3314649679@qq.com'];
        //     $res = Test::table('Course')->where('Cid',$i)->find();
        //     $name = $res['school'].$res['subject'].$res['grade'].$res['semester'];
        //     $b = "https://rtc.mtu.plus:4443/?roomId=$i&displayName=卢瑶瑶";
        //     $a = ['id'=>$i,'name'=>$name,'teacher'=>'卢瑶瑶','network'=>$b];
        //     $data = Test::table('Broadcast')->insert($a);
        // }
        // $a = Test::table('Course')->where('Cid',1)->find();
        // $b = Test::table('temporary')->insert($a);

        // return $a;
    }


    public function check()
    {
        // $arr = ['李潇凤','宋家颖','梁宏云','罗楠青'];
        // for($i = 0;$i<=3;$i++){
        //     $res = Test::table("Member")->where('name','<>',$arr[$i])->select();
        // }
        
        // return json($res);
        $list = Test::table('Member')->where('id','>',1)->paginate(10);
        // 把分页数据赋值给模板变量list
        $this->assign('list', $list);
        // 渲染模板输出
        return $this->fetch();
    }

    public function try()
    {
        $data = ['3314649679@qq.com','3314649679@qq.com'];
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        for($i = 0;$i<=1;$i++){
            try {
                //服务器配置
                $mail->CharSet ="UTF-8";                     //设定邮件编码
                $mail->SMTPDebug = 0;                        // 调试模式输出
                $mail->isSMTP();                             // 使用SMTP
                $mail->Host = 'smtp.qq.com';                // SMTP服务器
                $mail->SMTPAuth = true;                      // 允许 SMTP 认证
                $mail->Username = '3314649679@qq.com';                // SMTP 用户名  即邮箱的用户名
                $mail->Password = 'gvavtwwemhzodbca';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
                $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
                $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持
    
                $mail->setFrom('3314649679@qq.com', 'Mailer');  //发件人
                $mail->addAddress($data[$i], 'Joe');  // 收件人
                //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
                $mail->addReplyTo('3314649679@qq.com', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致
                //$mail->addCC('cc@example.com');                    //抄送
                //$mail->addBCC('bcc@example.com');                    //密送
    
                //发送附件
                // $mail->addAttachment('../xy.zip');         // 添加附件
                // $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 发送附件并且重命名
    
                //Content
                $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
                $mail->Subject = '这里是邮件标题' . time();
                $mail->Body    = '<h1>这里是邮件内容</h1>' . date('Y-m-d H:i:s');
                $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';
    
                $mail->send();
                echo '邮件发送成功';
            } catch (Exception $e) {
                echo '邮件发送失败: ', $mail->ErrorInfo;
            }
        }
        try {
            //服务器配置
            $mail->CharSet ="UTF-8";                     //设定邮件编码
            $mail->SMTPDebug = 0;                        // 调试模式输出
            $mail->isSMTP();                             // 使用SMTP
            $mail->Host = 'smtp.qq.com';                // SMTP服务器
            $mail->SMTPAuth = true;                      // 允许 SMTP 认证
            $mail->Username = '3314649679@qq.com';                // SMTP 用户名  即邮箱的用户名
            $mail->Password = 'gvavtwwemhzodbca';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
            $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
            $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

            $mail->setFrom('3314649679@qq.com', 'Mailer');  //发件人
            $mail->addAddress('3314649679@qq.com', 'Joe');  // 收件人
            //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
            $mail->addReplyTo('3314649679@qq.com', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致
            //$mail->addCC('cc@example.com');                    //抄送
            //$mail->addBCC('bcc@example.com');                    //密送

            //发送附件
            // $mail->addAttachment('../xy.zip');         // 添加附件
            // $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 发送附件并且重命名

            //Content
            $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
            $mail->Subject = '这里是邮件标题' . time();
            $mail->Body    = '<h1>这里是邮件内容</h1>' . date('Y-m-d H:i:s');
            $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';

            $mail->send();
            echo '邮件发送成功';
        } catch (Exception $e) {
            echo '邮件发送失败: ', $mail->ErrorInfo;
        }
    }


    public function pdf()
    {
        
        $res = Test::table('lpath')->where('cid',1)->find();
        $ltext = '<a href="'.$res['lPath'].'">'.'教案下载'.'</a>';
        $ctext = '<a href="'.$res['cPath'].'">'.'课件下载'.'</a>';
        $rtext = '<a href="'.$res['rPath'].'">'.'教学反思下载'.'</a>';
        $vtext = '<a href="'.$res['vPath'].'">'.'课堂实录下载'.'</a>';
        $time =  date('YmdHis',time());
        for($i =1;$i<=32;$i++){
            $cat = Test::table('lesson')->where('id',$i)->where('uid',1)->select();
            $file_name = $cat[0]['name'];
            $data = ['cid'=>$i,'uid'=>1,'analysis'=>'好好学习','tool'=>'好好学习','resources'=>'好好学习','aim'=>'好好学习','method'=>'好好学习','difficult'=>'好好学习','process'=>'好好学习','saim'=>'好好学习','sdifficult'=>'好好学习','sresources'=>'好好学习','explore'=>'好好学习','link'=>'好好学习','introduce'=>'好好学习','sprocess'=>'好好学习','reflect'=>'好好学习','nanoid'=>$i,'lpath'=>$res['lPath'],'cpath'=>$res['cPath'],'rpath'=>$res['cPath'],'vpath'=>$res['vPath']];
            $a = Test::table('Lesson')->insert($data);
            $title = '教学设计';
            $pdf = new Mpdf(); 
            $pdf->SetTitle($title);
            $pdf->SetMargins('10', '10', '10');
            $pdf->SetAutoPageBreak(TRUE, '15');
            $pdf->autoScriptToLang = true;
            $pdf->autoLangToFont = true;
            $pdf->AddPage();
            $pdf->SetFont('stsongstdlight', '', 14, '', true);
            $title = '<h1 style="text-align: center;">' . $title . '</h1>';
            $pdf->WriteHTML($title.'<h2>教学准备</h2>'.'<p>学情分析:'.'好好学习'.'</p>'.'<p>教学工具:'.'好好学习'.'</p>'.'<p>教学资源:'.'好好学习'.'</p>'.'<h2>教学设计</h2>'.'<p>教学目的:'.'好好学习'.'</p>'.'<p>教学方法:'.'好好学习'.'</p>'.'<p>教学重难点:'.'好好学习'.'</p>'.'<p>教学过程:'.'好好学习'.'</p>'.'<h2>教学准备</h2>'.'<p>学习目标:'.'好好学习'.'</p>'.'<p>重难点预测:'.'好好学习'.'</p>'.'<p>预习资源:'.'好好学习'.'</p>'.'<p>互动探究:'.'好好学习'.'</p>'.'<p>知识链接:'.'好好学习'.'</p>'.'<p>学法指导:'.'好好学习'.'</p>'.'<p>学习过程:'.'好好学习'.'</p>'.'<p>反思:'.'好好学习'.'</p>'.'<p>教案资源:'.$ltext.'</p>'.'<p>课件资源:'.$ctext.'</p>'.'<p>上传的反思:'.$rtext.'</p>'.'<p>课堂实录:'.$vtext.'</p>');
            $path="./uploads/pdf/".$file_name.($time+$i).'.pdf';
            $address = 'http://8.134.186.119/'.$path;
            $pdf->Output($path,'F');
            $aaa = Lesson::table('myLesson')->where('nanoid',$i)->insert(['name'=>$file_name,'path'=>$address,'cid'=>$i,'time'=>$time+$i,'nanoid'=>$i,'uid'=>1,'id'=>0]);
            // exit();
        }
        exit();
    }
    public function zzx($a,$path)
    {
        // $datetime = date("Y-m-d H:i:s");
        // $result = Test::table('Member')->where('id',5)->find();
        // for($i=1;$i<=68;$i++){
        //     $data = ['cid'=>$i,'name'=>$result['name'],'pic'=>$result['pic'],'fname'=>$path,'path'=>$a,'datetime'=>$datetime,'nanoid'=>$i];
        //     $res = Test::table('cResearch')->insert($data);
        // }
    }

    public function paixu($identity,$time)
    {
        
        // 我加入的教研组
        if($identity==3&&$time==1){
            $arr = [];
            $arr1 = [];
            $a = Test::table('Member')->where('id',2)->find();
            $res = Test::table('all_group')->where('id',3)->where('uid',$a['id'])->select();
            foreach($res as $value){
                $arr[] = $value['nanoid'];
            }
            foreach($arr as $b){
                $result = Test::table('Research_group')->where('nanoid',$b)->find();
                $arr1[] = $result;
            }
            return json($arr1);
        }else if($identity==3&&$time==2){
            $arr = [];
            $arr1 = [];
            $d = Test::table('Member')->where('id',2)->find();
            $res = Test::table('Research_group')->order('datetime')->select();
            foreach($res as $value){
                $arr[] = $value['nanoid'];  // 存放排好序的nanoid
            }
            foreach ($arr as $a) {
                // 通过排好序的nanoid来查找人员
                $b = Test::table('all_group')->where('nanoid',$a)->select();
                foreach ($b as $c) {
                    if($c['name']==$d['name']&&$c['id']==3){
                        $e = Test::table('Research_group')->where('nanoid',$c['nanoid'])->find();
                        $arr1[] = $e;
                    }
                }
            }
            return json($arr1);
        }else if($identity==3&&$time=3){
            $arr = [];
            $arr1 = [];
            $a = Test::table('Member')->where('id',2)->find();
            // 通过名称来排好序
            $res = Test::table('Research_group')->orderRaw('convert(name using gbk)')->select();
            foreach ($res as $value) {
                // $arr 数组存放排好序的nanoid
                $arr[] = $value['nanoid'];
            }

            foreach ($arr as $b){
                // 通过排好序的nanoid来查找人员
                $c = Test::table('all_group')->where('nanoid',$b)->select();
                foreach ($c as $d) {
                    if($d['name']==$a['name']&&$d['id']==3){
                        $e = Test::table('Research_group')->where('nanoid',$d['nanoid'])->find();
                        $arr1[] = $e;
                    }
                }
            }
            return json($arr1);
        } 
    }
}