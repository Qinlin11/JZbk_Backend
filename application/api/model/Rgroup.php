<?php

namespace app\api\model;

use think\Model;
use think\Db;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Rgroup extends Model
{
    protected $table = 'Research_group';
    
    // 查询所有教研组
    public function index()
    {
        $res = Rgroup::table('Research_group')->select();
        return json($res);
    }
    
    // 查看单个教研组
    public function click($nanoid)
    {
        $res = Rgroup::table("all_group")->where('nanoid',$nanoid)->select();
        return json($res);
    }
    
    // 修改成员权限
    // public function revise($gid,$num,$name,$id)
    // {
    //     if($num==2){
    //         $identity = '管理员';
    //     }else if($num==3){
    //         $identity = '成员';
    //     }
    //     $data = ['id'=>$num,'identity'=>$identity];
    //     $res = Rgroup::table("Group$gid")->where('name',$name)->where('id',$id)->setField($data);
    //     return json($res);
    // }
    
    // 将成员移出
    public function del($nanoid,$name)
    {
        $res = Rgroup::table("all_group")->where('name',$name)->where('nanoid',$nanoid)->delete();
        
        $b = Rgroup::table("all_group")->where('nanoid',$nanoid)->select();
        $a = count($b);
        $updateSum = Rgroup::table("Research_group")->where('nanoid',$nanoid)->data(['sum'=>$a])->update();
        return $a;
    }
    
    // 创建教研组
    public function add($name,$introduce,$nanoid)
    {
        
        $picArray = ['http://8.134.186.119:8888/down/yRKmyuBwhSP3.png','http://8.134.186.119:8888/down/KytD3a2u8nE4.png','http://8.134.186.119:8888/down/kAhPmWK2GA44.png','http://8.134.186.119:8888/down/NBwvBpAOktbn.png','http://8.134.186.119:8888/down/dIQ56aJwYkrW.png','http://8.134.186.119:8888/down/Lr0wMWgV6E6K.png'];
        $introduceArray = ['以立德树人为宗旨，以探究教学规律，改进教育教学方法，提升学校办学品位，提高教学效益的合作。','教育的艺术在于鼓舞和唤醒，用人格培养人格，以智慧启迪智慧。'];
        $n = rand(0,5);
        $m = rand(0,1);
        $datatime = date("Y-m-d H:i:s");
        if(!$introduce){
            $i = $introduceArray[$m];
        }else{
            $i = $introduce;
        }
        $data = ['name'=>$name,'sum'=>1,'pic'=>$picArray[$n],'introduce'=>$i,'nanoid'=>$nanoid,'datetime'=>$datatime];
        $insertData = Rgroup::table('Research_group')->insert($data);
        $a = Rgroup::table('Member')->where('id',2)->find();
        $newData = ['id'=>1,'name'=>$a['name'],'pic'=>$a['pic'],'sex'=>$a['sex'],'datatime'=>$datatime,'identity'=>'创建者','nanoid'=>$nanoid,'uid'=>$a['id'],'email'=>$a['email']];
        $insertNewData = Rgroup::table("all_group")->insert($newData);
        return json($insertNewData);
    }
    
    // 判断我是不是这个教研组的创建者
    public function check($nanoid)
    {
        $res = Cgroup::table("all_group")->where('nanoid',$nanoid)->where('id',1)->select();
        $a = $res[0]['name'];
        $b = Rgroup::table('Member')->where('id',2)->find();
        $c = $b['name'];
        if($a == $c){
            return 1;
        }else{
            return 0;
        }
        
    }

    // 添加成员
    public function addNumber($nanoid,$id)
    {
        $res = Rgroup::table('Member')->where('id',$id)->select();
        $a = $res[0]['name'];
        $new_data = Rgroup::table("all_group")->where('nanoid',$nanoid)->select();
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
        $arr = ['id'=>3,'name'=>$a,'pic'=>$b,'sex'=>$c,'datatime'=>$datetime,'identity'=>'成员','nanoid'=>$nanoid,'uid'=>$id,'email'=>$res[0]['email']];
        $data = Rgroup::table("all_group")->insert($arr);
        $result = Rgroup::table("all_group")->where('nanoid',$nanoid)->select();
        $sum = count($result);
        $d = Rgroup::table("Research_group")->where('nanoid',$nanoid)->update(['sum'=>$sum]);
        return '邀请成员成功';
    }

    // 搜索
    public function find($name)
    {
        $res = Rgroup::table("Member")->where('name','like',"%$name%")->select();
        return json($res);
    }

    // 解散教研组
    public function dissolution($nanoid)
    {
        $res = Rgroup::table("Research_group")->where('nanoid',$nanoid)->delete();
        $data = Rgroup::table("all_group")->where('nanoid',$nanoid)->delete();
        return json($res);
    }

    // 发布通知
    public function notice($nanoid,$extent,$type,$time,$nanoid1)
    {
        if(!$type||!$extent){
            return;
        }
        $result = Rgroup::table('Gnotice')->insert(['nanoid'=>$nanoid,'extent'=>$extent,'type'=>$type,'time'=>$time,'nanoid1'=>$nanoid1]);
        $res = Rgroup::table('all_group')->where('nanoid',$nanoid)->select();
        $mail = new PHPMailer(true);  
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
        //         $mail->Subject = '教研组通知';
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
    public function showNotice($nanoid)
    {
        $res = Rgroup::table("Gnotice")->where('nanoid',$nanoid)->select();
        return json($res);
    }

    // 删除课程活动
    public function delNotice($nanoid,$nanoid1)
    {
        $res = Rgroup::table("Gnotice")->where('nanoid',$nanoid)->where('nanoid1',$nanoid1)->delete();
        return json($res);
    }

    // 渲染研讨区
    public function showResearch($nanoid)
    {
        $res = Rgroup::table("gResearch")->where('nanoid',$nanoid)->select();
        return json($res);
    }

    // 创建研讨区
    public function createResearch($nanoid1,$a,$path,$nanoid)
    {
        $datetime = date("Y-m-d H:i:s");
        $result = Rgroup::table('Member')->where('id',2)->find();
        $data = ['nanoid'=>$nanoid,'name'=>$result['name'],'pic'=>$result['pic'],'fname'=>$path,'path'=>$a,'datetime'=>$datetime,'nanoid1'=>$nanoid1];
        $res = Rgroup::table('gResearch')->insert($data);
    }

    // 参与教研
    public function joinResearch($nanoid1,$nanoid)
    {
        $res = Rgroup::table("gResearch")->where('nanoid1',$nanoid1)->where('nanoid',$nanoid)->find();
        return json($res);
    }

    // 按照创建时间排序
    // public function createTime()
    // {
    //     $res = Rgroup::table('Research_group')->order('datetime')->select();
    //     return json($res);
    // }

    // // 按照名称排序
    // public function createName()
    // {
    //     $res = Rgroup::table('Research_group')->orderRaw('convert(name using gbk)')->select();
    //     return json($res);
    // }

    // // 筛选出我创建的教研组
    // public function myGroup()
    // {
    //     $arr= [];
    //     $a = Rgroup::table('Member')->where('id',2)->find();
    //     $res = Rgroup::table('all_group')->where('id',1)->select();
    //     foreach ($res as $value) {
    //        if($value['name']==$a['name']){
    //             $result = Rgroup::table('Research_group')->where('nanoid',$value['nanoid'])->find();
    //             $arr[] = $result;
    //        }
    //     }
    //     return json($arr);
    // }

    // 教研组排序
    public function paixu($identity,$time)
    {
        // 筛选出我创建的教研组
        if($identity==2&&$time==1){
            $arr= [];
            $a = Rgroup::table('Member')->where('id',2)->find();
            $res = Rgroup::table('all_group')->where('id',1)->select();
            foreach ($res as $value) {
               if($value['name']==$a['name']){
                    $result = Rgroup::table('Research_group')->where('nanoid',$value['nanoid'])->find();
                    $arr[] = $result;
               }
            }
            return json($arr);
        }else if($identity==2&&$time==2){
            $arr= [];
            $res = Rgroup::table('all_group')->where('id',1)->order('datatime')->select();
            $a = Rgroup::table('Member')->where('id',2)->find();
            foreach ($res as $value) {
               if($value['name']==$a['name']){
                    $result = Rgroup::table('Research_group')->where('nanoid',$value['nanoid'])->find();
                    $arr[] = $result;
               }
            }
            return json($arr);
        }else if($identity==2&&$time==3){
            $arr= [];
            $nanoidArr = [];
            $res = Rgroup::table('Research_group')->orderRaw('convert(name using gbk)')->select();   
            $a = Rgroup::table('Member')->where('id',2)->find();
            $b = Rgroup::table('all_group')->where('id',1)->where('name',$a['name'])->select();
            foreach($b as $c){
                $nanoidArr[] = $c['nanoid'];
            }
            foreach ($res as $value) {
                foreach ($nanoidArr as $d){
                    if($value['nanoid']==$d){
                        $result = Rgroup::table('Research_group')->where('nanoid',$d)->find();
                        $arr[] = $result;
                    }
                }
            }
            return json($arr);
        }else if($identity==1&&$time==2){
            $res = Rgroup::table('Research_group')->order('datetime')->select();
            return json($res);
        }else if($identity==1&&$time==3){
            $res = Rgroup::table('Research_group')->orderRaw('convert(name using gbk)')->select();
            return json($res);
        }else if($identity==3&&$time==1){  // 我加入的教研组
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
    

    // 加入教研组
    public function enter($nanoid,$id)
    {
        $text = true;
        $datetime = date("Y-m-d H:i:s");
        $a = Rgroup::table('Member')->where('id',$id)->find(); // 找到自己
        $res = Rgroup::table("all_group")->where('nanoid',$nanoid)->select();  // 查找当前教研组的成员
        foreach ($res as $value) {
            // 如果我在这个教研组里面，判断我是什么身份
            if($value['name']==$a['name']&&$value['id']==3){
                $text = false;
            }
        }
        // print($res);
        // 如果我已经在这里面了，就退出
        if(!$text){
            $data = ['nanoid'=>$nanoid,'uid'=>$id];
            $b = Rgroup::table("all_group")->where($data)->delete();
            $d = Rgroup::table("all_group")->where('nanoid',$nanoid)->select();
            $e = Rgroup::table("Research_group")->where('nanoid',$nanoid)->update(['sum'=>count($d)]);
            return 0;
        }else{
            // 如果我不在就加入这个团队
            $data = ['id'=>3,'name'=>$a['name'],'pic'=>$a['pic'],'sex'=>$a['sex'],'datatime'=>$datetime,'identity'=>'成员','nanoid'=>$nanoid,'uid'=>$id,'email'=>$a['email']];
            $c = Rgroup::table("all_group")->insert($data);
            $f = Rgroup::table("all_group")->where('nanoid',$nanoid)->select();
            $g = Rgroup::table("Research_group")->where('nanoid',$nanoid)->update(['sum'=>count($f)]);
            return 1;
        }
    }

    // 判断我是不是加入了别的教研组
    public function checkIdentity($nanoid)
    {
        $res = Cgroup::table("all_group")->where('nanoid',$nanoid)->where('id',3)->select();
        if($res=='[]'){
            return 0;
        }else{
            $a = Rgroup::table('Member')->where('id',2)->find();
            foreach ($res as $value) {
                if($value['name']==$a['name']){
                    return 1;
                }
            }
            return 0;
        }
        
    }
}