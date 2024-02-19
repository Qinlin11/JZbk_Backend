<?php

namespace app\api\model;

use think\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use think\Db;

class Cgroup extends Model
{
    // 查看单个课程教研
    public function index($Cid)
    {
        $res = Cgroup::table("Cgroup")->where('cid',$Cid)->select();
        return json($res);
    } 

    // 渲染成员
    public function show()
    {
        $res = Cgroup::table("Member")->select();
        return json($res);
    }

    // 添加成员
    public function add($Cid,$id)
    {
        $res = Cgroup::table('Member')->where('id',$id)->select();
        $a = $res[0]['name'];
        $new_data = Cgroup::table("Cgroup")->where('cid',$Cid)->select();
        $count = count($new_data);
        for($i = 0;$i < $count;$i++){
            $name = $new_data[$i]['name'];
            if($a==$name){
                return '该成员已经加入该团队';
            }
        }
        $b = $res[0]['pic'];
        $c = $res[0]['sex'];
        $datetime = date("Y-m-d H:i:s");
        $arr = ['id'=>$id,'name'=>$a,'pic'=>$b,'sex'=>$c,'datatime'=>$datetime,'identity'=>'成员','cid'=>$Cid,'email'=>$res[0]['email']];
        $data = Cgroup::table("Cgroup")->insert($arr);
        return '邀请成员成功';
    }

    // 加入课程教研
    public function join($Cid,$id)
    {
        $res = Cgroup::table('Member')->where('id',$id)->select();
        $a = $res[0]['name'];
        $new_data = Cgroup::table("Cgroup")->where('cid',$Cid)->select();
        $count = count($new_data);
        for($i = 0;$i < $count;$i++){
            $name = $new_data[$i]['name'];
            if($a==$name){
                $aaa = ['name'=>$a,'cid'=>$Cid];
                $d = Cgroup::table("Cgroup")->where($aaa)->delete();
                $h = Cgroup::table("myCourse")->where('Cid',$Cid)->delete();
                return 111;
            }
        }
        $b = $res[0]['pic'];
        $c = $res[0]['sex'];
        $datetime = date("Y-m-d H:i:s");
        $arr = ['id'=>$id,'name'=>$a,'pic'=>$b,'sex'=>$c,'datatime'=>$datetime,'identity'=>'成员','cid'=>$Cid,'email'=>$res[0]['email']];
        $data = Test::table("Cgroup")->insert($arr);
        $d = Test::table("Course")->where('Cid',$Cid)->find();
        $f = ['school'=>$d['school'],'subject'=>$d['subject'],'edition'=>$d['edition'],'grade'=>$d['grade'],'semester'=>$d['semester'],'id'=>$d['id'],'img'=>$d['img'],'Cid'=>$d['Cid']];
        $e = Test::table("myCourse")->insert($f);
        return json($res);
    }

    // 判断我在不在这个课程教研里面
    public function check($Cid)
    {
        $res = Cgroup::table("Cgroup")->where('Cid',$Cid)->select();
        $count = count($res);
        // print($count);
        for($i=0;$i<$count;$i++){
            $name = $res[$i]['name'];
            if($name=='李盛厚'){
                return 1;
            }
        }
        return 0;
    }

    // 搜索
    public function find($name)
    {
        $res = Cgroup::table("Member")->where('name','like',"%$name%")->select();
        return json($res);
    }

    // 渲染教研组
    public function rendering()
    {
        $arr = [];
        $data = Cgroup::table("Member")->where('id',2)->find();
        $res = Cgroup::table("Research_group")->select();
        foreach($res as $value){
           $a = Cgroup::table("all_group")->where('nanoid',$value['nanoid'])->where('id',1)->find();
           if($data['name'] == $a['name']){
                $c = Cgroup::table("Research_group")->where('nanoid',$value['nanoid'])->find();
                $arr[] = $c;
           }
        }
        return json($arr);
    }

    // 协同教研组
    public function addGroup($Cid,$nanoid)
    {
        $datetime = date("Y-m-d H:i:s");
        $res = Cgroup::table("all_group")->where('nanoid',$nanoid)->select();  // 查找教研组的成员
        $result = Cgroup::table('Cgroup')->where('cid',$Cid)->select(); // 查找课程的成员
        for($i = 0;$i<count($res);$i++){
            $text = true;
            for($j = 0;$j<count($result);$j++){
                if($res[$i]['name']==$result[$j]['name']&&$res[$i]['uid']==$result[$j]['id']){
                    $text = false;
                }
            }
            if($text == true){
                $b = ['id'=>$res[$i]['uid'],'name'=>$res[$i]['name'],'pic'=>$res[$i]['pic'],'identity'=>'成员','cid'=>$Cid,'datatime'=>$datetime,'email'=>$res[$i]['email'],'sex'=>$res[$i]['sex']];
                $a = Cgroup::table('Cgroup')->insert($b);
                // break;
            }
            
        }
        // foreach($res as $value){
        //     $text = true;
            
        //     foreach($result as $data){
        //         if($value['name'] == $data['name']){
        //             $text = false;
        //         }
        //         if($text==true){
        //             $b = ['id'=>$value['uid'],'name'=>$value['name'],'pic'=>$value['pic'],'identity'=>'成员','cid'=>$Cid,'datatime'=>$datetime];
        //             $a = Cgroup::table('Cgroup')->insert($b);
        //             break;
        //         }
        //     }
        // }
        // return $res;
    }

    // 发布通知
    public function notice($Cid,$extent,$type,$time,$nanoid)
    {
        if(!$type||!$extent){
            return;
        }
        $result = Cgroup::table('Cnotice')->insert(['Cid'=>$Cid,'extent'=>$extent,'type'=>$type,'time'=>$time,'nanoid'=>$nanoid]);
        $res = Cgroup::table('Cgroup')->where('cid',$Cid)->select();
        // $mail = new PHPMailer(true);  
        // for($i=0;$i<count($res);$i++){
        //     try {
        //         //服务器配置
        //         $mail->CharSet ="UTF-8";                     //设定邮件编码
        //         $mail->SMTPDebug = 0;                        // 调试模式输出
        //         $mail->isSMTP();                             // 使用SMTP
        //         $mail->Host = 'smtp.qq.com';                // SMTP服务器
        //         $mail->SMTPAuth = true;                      // 允许 SMTP 认证
        //         $mail->Username = '3314649679@qq.com';                // SMTP 用户名  即邮箱的用户名
        //         $mail->Password = 'nhxzalanihjvcibg';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
        //         $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
        //         $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持
    
        //         $mail->setFrom('3314649679@qq.com', '李盛厚');  //发件人
        //         $mail->addAddress($res[$i]['email'], 'Joe');  // 收件人
        //         //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
        //         $mail->addReplyTo('3314649679@qq.com', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致
        //         //$mail->addCC('cc@example.com');                    //抄送
        //         //$mail->addBCC('bcc@example.com');                    //密送
    
        //         //发送附件
        //         // $mail->addAttachment('../xy.zip');         // 添加附件
        //         // $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 发送附件并且重命名
    
        //         //Content
        //         $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
        //         $mail->Subject = '课程教研通知';
        //         $mail->Body    = '<p>活动范围:'.$extent.'</p>' .'<p>活动类型:'.$type.'</p>'.'<p>活动时间:'.$time.'</p>';
        //         $mail->AltBody = '如果邮件客户端不支持HTML则显示此内容';
    
        //         $mail->send();
        //         echo '邮件发送成功';
        //     } catch (Exception $e) {
        //         echo '邮件发送失败: ', $mail->ErrorInfo;
        //     }
        // }
    }

    // 渲染课程活动
    public function showNotice($Cid)
    {
        $res = Cgroup::table("Cnotice")->where('Cid',$Cid)->select();
        return json($res);
    }

    // 删除课程活动
    public function delNotice($Cid,$nanoid)
    {
        $res = Cgroup::table("Cnotice")->where('Cid',$Cid)->where('nanoid',$nanoid)->delete();
        return json($res);
    }

    // 渲染研讨区
    public function showResearch($Cid)
    {
        $res = Cgroup::table("cResearch")->where('cid',$Cid)->select();
        return json($res);
    }

    // 创建研讨区
    public function createResearch($Cid,$a,$path,$nanoid)
    {
        $datetime = date("Y-m-d H:i:s");
        $result = Cgroup::table('Member')->where('id',2)->find();
        $data = ['cid'=>$Cid,'name'=>$result['name'],'pic'=>$result['pic'],'fname'=>$path,'path'=>$a,'datetime'=>$datetime,'nanoid'=>$nanoid];
        $res = Cgroup::table('cResearch')->insert($data);
    }

    // 参与教研
    public function joinResearch($Cid,$nanoid)
    {
        $res = Cgroup::table("cResearch")->where('Cid',$Cid)->where('nanoid',$nanoid)->find();
        return json($res);
    }

    // 渲染与我有关的课程教研
    public function showCourse()
    {
        // $arr = [];
        // $result = [];
        // $res = Cgroup::table("")->where('id',2)->select();
        // foreach ($res as $value){
        //     $arr[] = $value['cid'];
        // }
        // foreach ($arr as $a) {
        //    $b = Cgroup::table("Course")->where('Cid',$a)->find();
        //    $result[] = $b;
        // }
        // return json($result);
        $res = Cgroup::table("myCourse")->select();
        return json($res);
    }

    // 创建课程教研
    public function createCourse($period,$subject,$edition,$semester,$grade)
    {
        $res = Cgroup::table("Course")->where('id','<>',2)->select();
        $shabi = Cgroup::table("myCourse")->where('id',2)->select();
        // 判断这门课是否已经存在
        foreach ($res as $value) {
            if($period==$value['school']&&$subject==$value['subject']&&$edition==$value['edition']&&$grade==$value['grade']&&$semester==$value['semester']){
                header('HTTP/1.1 404 Not Found');exit('404');
            }
        }
        foreach ($shabi as $value) {
            if($period==$value['school']&&$subject==$value['subject']&&$edition==$value['edition']&&$grade==$value['grade']&&$semester==$value['semester']){
                header('HTTP/1.1 404 Not Found');exit('404');
            }
        }

        // print($period.$subject.$edition.$semester.$grade);
        // 所有教材图片
        if($subject == '语文'){
            $picArr = [ '一年级上学期'=>'http://8.134.186.119:8888/down/tW0qkidjeJwD.png',
                        '一年级下学期'=>'http://8.134.186.119:8888/down/VSs3I1YzFRxh.png',
                        '二年级上学期'=>'http://8.134.186.119:8888/down/joUBbep68nlE.png',
                        '二年级下学期'=>'http://8.134.186.119:8888/down/uGoX25v3mRpc.png',
                        '三年级上学期'=>'http://8.134.186.119:8888/down/pA4RH1eu54ud.png',
                        '三年级下学期'=>'http://8.134.186.119:8888/down/2hsqPUAwjRBv.png',
                        '四年级上学期'=>'http://8.134.186.119:8888/down/7xdRBZnU5Tdj.png',
                        '四年级下学期'=>'http://8.134.186.119:8888/down/g8uFX8qhefME.png',
                        '五年级上学期'=>'http://8.134.186.119:8888/down/xnMZZ4CIvfwY.png',
                        '五年级下学期'=>'http://8.134.186.119:8888/down/ZInS7PL3ZMft.png',
                        '六年级上学期'=>'http://8.134.186.119:8888/down/mtqqevnh3xsy.png',
                        '六年级下学期'=>'http://8.134.186.119:8888/down/morvvzj5UaHp.png',
                        '七年级上学期'=>'http://8.134.186.119:8888/down/x0y2SkGAMN47.png',
                        '七年级下学期'=>'http://8.134.186.119:8888/down/XsGDYqvdd3KF.png',
                        '八年级上学期'=>'http://8.134.186.119:8888/down/slunMLPEPCjz.png',
                        '八年级下学期'=>'http://8.134.186.119:8888/down/hsASukHWO0wd.png',
                        '九年级上学期'=>'http://8.134.186.119:8888/down/zrB9AipCowJb.png',
                        '九年级下学期'=>'http://8.134.186.119:8888/down/1P3fzzXbSaaS.png',
                        '高一上学期'=>'http://8.134.186.119:8888/down/8TGXVyibObah.png',
                        '高一下学期'=>'http://8.134.186.119:8888/down/U4Vx7AZ4dPu7.png',
                        '高二上学期'=>'http://8.134.186.119:8888/down/HhV8gA5HmEYF.png',
                        '高二下学期'=>'http://8.134.186.119:8888/down/Mz29kZz3kNg7.png',
                        '高三上学期'=>'http://8.134.186.119:8888/down/W2jC1I8s0ipd.png',
                        '高三下学期'=>'http://8.134.186.119:8888/down/D5f83mh41Gb1.png'
                        ];
        }else if($subject == '数学'){
            $picArr = [ '一年级上学期'=>'http://8.134.186.119:8888/down/evHzBAGqAne7.png',
                        '一年级下学期'=>'http://8.134.186.119:8888/down/FP4HUk9X3KOI.png',
                        '二年级上学期'=>'http://8.134.186.119:8888/down/c0AEtodZW0Em.png',
                        '二年级下学期'=>'http://8.134.186.119:8888/down/2LtTAq6C3QSC.png',
                        '三年级上学期'=>'http://8.134.186.119:8888/down/5fxG15vDG3y2.png',
                        '三年级下学期'=>'http://8.134.186.119:8888/down/IP1qqLGqYpkJ.png',
                        '四年级上学期'=>'http://8.134.186.119:8888/down/tjg5YOdO7yLS.png',
                        '四年级下学期'=>'http://8.134.186.119:8888/down/U8QhTWJODzBq.png',
                        '五年级上学期'=>'http://8.134.186.119:8888/down/SDSRez2P1I42.png',
                        '五年级下学期'=>'http://8.134.186.119:8888/down/y4FDP0jTAgVv.png',
                        '六年级上学期'=>'http://8.134.186.119:8888/down/2KDmZHXtfvNS.png',
                        '六年级下学期'=>'http://8.134.186.119:8888/down/oZ6Dj77PB4Yt.png',
                        '七年级上学期'=>'http://8.134.186.119:8888/down/JcchyfnMGjpD.png',
                        '七年级下学期'=>'http://8.134.186.119:8888/down/nAcUmqDHL7lW.png',
                        '八年级上学期'=>'http://8.134.186.119:8888/down/wizqFdZYhDnI.png',
                        '八年级下学期'=>'http://8.134.186.119:8888/down/2ZNqvUWo04Bc.png',
                        '九年级上学期'=>'http://8.134.186.119:8888/down/bNDqkjt7ApC0.png',
                        '九年级下学期'=>'http://8.134.186.119:8888/down/ghhT84vhBW2E.png',
                        '高一上学期'=>'http://8.134.186.119:8888/down/263Dvk9Chu07.png',
                        '高一下学期'=>'http://8.134.186.119:8888/down/2B5s4jT4dYKP.png',
                        '高二上学期'=>'http://8.134.186.119:8888/down/etwD7kpqfHs7.png',
                        '高二下学期'=>'http://8.134.186.119:8888/down/3smAFpZXEXfQ.png',
                        '高三上学期'=>'http://8.134.186.119:8888/down/dJyTHFZGXW5b.png',
                        '高三下学期'=>'http://8.134.186.119:8888/down/dJyTHFZGXW5b.png'
                        ];
        }else if($subject=='英语'){
            $picArr = [ 
                        '一年级上学期'=>'http://8.134.186.119:8888/down/9mWmKl3CY5eT.png',
                        '一年级下学期'=>'http://8.134.186.119:8888/down/4jCbfaGgrvjk.png',
                        '二年级上学期'=>'http://8.134.186.119:8888/down/syEchayXWvXZ.png',
                        '二年级下学期'=>'http://8.134.186.119:8888/down/0W9OP94E0tum.png',
                        '三年级上学期'=>'http://8.134.186.119:8888/down/sjADdmqrX9u2.png',
                        '三年级下学期'=>'http://8.134.186.119:8888/down/6Y8IVZhV9lob.png',
                        '四年级上学期'=>'http://8.134.186.119:8888/down/MdAEBmFBjPN9.png',
                        '四年级下学期'=>'http://8.134.186.119:8888/down/rxjsMuCo7wey.png',
                        '五年级上学期'=>'http://8.134.186.119:8888/down/FD5UWzBt030T.png',
                        '五年级下学期'=>'http://8.134.186.119:8888/down/FZb0y6Glxrtw.png',
                        '六年级上学期'=>'http://8.134.186.119:8888/down/QA3JGAlXN7CB.png',
                        '六年级下学期'=>'http://8.134.186.119:8888/down/njdtqmvRrKrt.png',
                        '七年级上学期'=>'http://8.134.186.119:8888/down/lvEmkbr3y8Xo.png',
                        '七年级下学期'=>'http://8.134.186.119:8888/down/Z5EcGi8caeJp.png',
                        '八年级上学期'=>'http://8.134.186.119:8888/down/bkDGa9cLtjkv.png',
                        '八年级下学期'=>'http://8.134.186.119:8888/down/qFbcxkuXa25V.png',
                        '九年级上学期'=>'http://8.134.186.119:8888/down/He5hJMlkTjse.png',
                        '九年级下学期'=>'http://8.134.186.119:8888/down/He5hJMlkTjse.png',
                        '高一上学期'=>'http://8.134.186.119:8888/down/vQxTU8gXHqcr.png',
                        '高一下学期'=>'http://8.134.186.119:8888/down/f6eK5m2VARPG.png',
                        '高二上学期'=>'http://8.134.186.119:8888/down/MdbiwY95uKry.png',
                        '高二下学期'=>'http://8.134.186.119:8888/down/UHZU6F6WHPy6.png',
                        '高三上学期'=>'http://8.134.186.119:8888/down/rXAfnMdonp3d.png',
                        '高三下学期'=>'http://8.134.186.119:8888/down/rXAfnMdonp3d.png'
                        ];
        }
        // return json($picArr);
        $sum = count($res)+1 + count($shabi);
        $text = $grade.$semester;
        // return $picArr['一年级上学期'];
        $data = ['school'=>$period,'subject'=>$subject,'edition'=>$edition,'grade'=>$grade,'semester'=>$semester,'id'=>2,'img'=>$picArr[$text],'Cid'=>$sum];
        $result = Cgroup::table("myCourse")->insert($data);
        // 创建一门课的时候默认生成一个会议号
        $res1 = Cgroup::table("Broadcast")->select();
        $aaa = count($res1)+1;
        $res2 = Cgroup::table("Broadcast")->insert(['id'=>$sum,'name'=>$period.$subject.$text,'teacher'=>'李盛厚','network'=>"https://rtc.mtu.plus:4443/?roomId=$aaa&displayName=李盛厚"]);
        // 创建一门课的时候生成六个单元
        $arr = ['一','二','三','四','五','六'];
        for($i = 0;$i<6;$i++){
            $a = $arr[$i];
            $name = $subject.'人教版'.$grade.$semester.'第'.$a.'单元';
            $data1 = ['id'=>$sum,'name'=>$name,'pic'=>$picArr[$text],'uid'=>$i+1];
            $res3 = Cgroup::table("lesson")->insert($data1);
        }
        $datetime = date("Y-m-d H:i:s");
        $data2 = ['id'=>2,'name'=>'李盛厚','pic'=>'http://8.134.186.119:8888/down/qURXpI8ZSZSv.jpg','sex'=>'男','datatime'=>$datetime,'identity'=>'创建者','cid'=>$sum,'email'=>'3314649679@qq.com'];
        $res4 = Cgroup::table("Cgroup")->insert($data2);
        // return 111;
    }

    // 发起协同
    public function launch($Cid)
    {
        $res = Cgroup::table("myCourse")->where('Cid',$Cid)->find();
        if($res == '[]'){
             return;
        }else{
            $data = ['school'=>$res['school'],'subject'=>$res['subject'],'edition'=>$res['edition'],'grade'=>$res['grade'],'semester'=>$res['semester'],'id'=>$res['id'],
            'img'=>$res['img'],'Cid'=>$res['Cid']];
            $result = Cgroup::table("Course")->insert($data);
        }
        
    }

    // 我的协同搜索功能实现
    public function search($id,$subject,$edition,$semester,$grade)
    {
        // $sql="DROP TABLE `temporary`";
        // $result = Db::execute($sql);
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

        // $sql="CREATE TABLE IF NOT EXISTS `temporary`(
        //     `school` VARCHAR(10) NOT NULL,
        //     `subject` VARCHAR(10) NOT NULL,
        //     `edition` VARCHAR(10) NOT NULL,
        //     `grade` VARCHAR(18) NOT NULL,
        //     `semester` VARCHAR(18) NOT NULL,
        //     `id` int(4) NOT NULL,
        //     `img` text not NULL,
        //     `Cid` int(4) not NULL
            
        // )ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;";
        // $d = Db::execute($sql);
        $b = [];
        $a =['subject'=>$subject,'school'=>$school,'edition'=>$edition,'grade'=>$grade,'semester'=>$semester];
        foreach ($a as $x=>$value){
            if($value==null){
                continue;
            }else{
                $b[$x] = $value;
            } 
        }
        // $arr = [];
        // $res = Cgroup::table("Cgroup")->where('id',2)->select();
        // foreach ($res as $value){
        //     $arr[] = $value['cid'];
        // }
        // // var_dump($b);
        // foreach ($arr as $a) {
        //     $c = Cgroup::table("Course")->where('Cid',$a)->find();
        //     $data = ['school'=>$c['school'],'subject'=>$c['subject'],'edition'=>$c['edition'],'grade'=>$c['grade'],
        //             'semester'=>$c['semester'],'id'=>$c['id'],'img'=>$c['img'],'Cid'=>$c['Cid']];
        //     $result = Cgroup::table("temporary")->insert($data);
        // }        
        $e = Cgroup::table("myCourse")->where($b)->select();
        return json($e);
    }

    // 判断是否已经发起了协同
    public function judge($Cid)
    {
        $res = Cgroup::table("Course")->where('Cid',$Cid)->find();
        if(!$res){
            return 1;
        }
        return 0;
    }
}
