<?php

namespace app\api\model;

use think\Model;
use Mpdf\Mpdf;

class Lesson extends Model
{

    // 展示对应课程
    public function index($cid)
    {
        $res = Lesson::table('lesson')->where('id',$cid)->select();
        return json($res);
    }

    // 协同备课
    public function design($cid,$uid,$analysis,$tool,$resources,$aim,$method,$difficult,$process,$saim,$sdifficult,$sresources,$explore,$link,$introduce,$sprocess,$reflect,$nanoid)
    {
        $test = Lesson::table('Lesson')->where('nanoid',$nanoid)->select();
        // $nanoid 不存在
        if($test=='[]'){
            $time =  date('YmdHis',time());
            $cat = Lesson::table('lesson')->where('id',$cid)->where('uid',$uid)->select();
            $file_name = $cat[0]['name'];
            $path = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->select();
            if($path=='[]'){
                $a = '';
                $b = '';
                $c = '';
                $d = '';
            }else{
                $a = $path[0]['lPath'];
                $b = $path[0]['cPath'];
                $c = $path[0]['rPath'];
                $d = $path[0]['vPath'];  
            }
            
            if($a){
                $ltext = '<a href="'.$a.'">'.'教案下载'.'</a>';
            }else{
                $ltext = '';
            }

            if($b){
                $ctext = '<a href="'.$b.'">'.'课件下载'.'</a>';
            }else{
                $ctext = '';
            }

            if($c){
                $rtext = '<a href="'.$c.'">'.'教案下载'.'</a>';
            }else{
                $rtext = '';
            }

            if($d){
                $vtext = '<a href="'.$d.'">'.'教案下载'.'</a>';
            }else{
                $vtext = '';
            }
            $data = ['cid'=>$cid,'uid'=>$uid,'analysis'=>$analysis,'tool'=>$tool,'resources'=>$resources,'aim'=>$aim,'method'=>$method,'difficult'=>$difficult,'process'=>$process,'saim'=>$saim,'sdifficult'=>$sdifficult,'sresources'=>$sresources,'explore'=>$explore,'link'=>$link,'introduce'=>$introduce,'sprocess'=>$sprocess,'reflect'=>$reflect,'nanoid'=>$nanoid,'lpath'=>$a,'cpath'=>$b,'rpath'=>$c,'vpath'=>$d];
            $res = Lesson::table('Lesson')->insert($data);
            // 保存生成pdf
            $title = '协同备课';
            $pdf = new Mpdf(); 
            $pdf->SetTitle($title);
            $pdf->SetMargins('10', '10', '10');
            $pdf->SetAutoPageBreak(TRUE, '15');
            $pdf->autoScriptToLang = true;
            $pdf->autoLangToFont = true;
            $pdf->AddPage();
            $pdf->SetFont('stsongstdlight', '', 14, '', true);
            $title = '<h1 style="text-align: center;">' . $title . '</h1>';
            $pdf->WriteHTML($title.'<h2>教学准备</h2>'.'<p>学情分析:'.$analysis.'</p>'.'<p>教学工具:'.$tool.'</p>'.'<p>教学资源:'.$resources.'</p>'.'<h2>教学设计</h2>'.'<p>教学目的:'.$aim.'</p>'.'<p>教学方法:'.$method.'</p>'.'<p>教学重难点:'.$difficult.'</p>'.'<p>教学过程:'.$process.'</p>'.'<h2>教学准备</h2>'.'<p>学习目标:'.$saim.'</p>'.'<p>重难点预测:'.$sdifficult.'</p>'.'<p>预习资源:'.$sresources.'</p>'.'<p>互动探究:'.$explore.'</p>'.'<p>知识链接:'.$link.'</p>'.'<p>学法指导:'.$introduce.'</p>'.'<p>学习过程:'.$sprocess.'</p>'.'<p>反思:'.$reflect.'</p>'.'<p>教案资源:'.$ltext.'</p>'.'<p>课件资源:'.$ctext.'</p>'.'<p>上传的反思:'.$rtext.'</p>'.'<p>课堂实录:'.$vtext.'</p>');
            $path="./uploads/pdf/".$file_name.$time.'.pdf';
            $address = 'http://8.134.186.119/'.$path;
            $pdf->Output($path,'F');
            $aaa = Lesson::table('myLesson')->insert(['name'=>$file_name,'path'=>$address,'cid'=>$cid,'nanoid'=>$nanoid,'time'=>$time,'uid'=>$uid,'id'=>1]);
            $bbb = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->delete();
            exit();
        }else{
            // $nanoid 存在
            $cat = Lesson::table('lesson')->where('id',$cid)->where('uid',$uid)->select();
            $file_name = $cat[0]['name'];
            $path = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->select();
            if($path=='[]'){
                $a = '';
                $b = '';
                $c = '';
                $d = '';
            }else{
                $a = $path[0]['lPath'];
                $b = $path[0]['cPath'];
                $c = $path[0]['rPath'];
                $d = $path[0]['vPath'];
            }

            if($a){
                $ltext = '<a href="'.$a.'">'.'教案下载'.'</a>';
            }else{
                $ltext = '';
            }

            if($b){
                $ctext = '<a href="'.$b.'">'.'课件下载'.'</a>';
            }else{
                $ctext = '';
            }

            if($c){
                $rtext = '<a href="'.$c.'">'.'教学反思下载'.'</a>';
            }else{
                $rtext = '';
            }

            if($d){
                $vtext = '<a href="'.$d.'">'.'课堂实录下载'.'</a>';
            }else{
                $vtext = '';
            }
            $data = ['cid'=>$cid,'uid'=>$uid,'analysis'=>$analysis,'tool'=>$tool,'resources'=>$resources,'aim'=>$aim,'method'=>$method,'difficult'=>$difficult,'process'=>$process,'saim'=>$saim,'sdifficult'=>$sdifficult,'sresources'=>$sresources,'explore'=>$explore,'link'=>$link,'introduce'=>$introduce,'sprocess'=>$sprocess,'reflect'=>$reflect,'nanoid'=>$nanoid,'lpath'=>$a,'cpath'=>$b,'rpath'=>$c,'vpath'=>$d];
            $res = Lesson::table('Lesson')->where('nanoid',$nanoid)->update($data);
            $new =  Lesson::table('myLesson')->where('nanoid',$nanoid)->select();
            $time = $new[0]['time'];
            // 保存生成pdf
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
            $pdf->WriteHTML($title.'<h2>教学准备</h2>'.'<p>学情分析:'.$analysis.'</p>'.'<p>教学工具:'.$tool.'</p>'.'<p>教学资源:'.$resources.'</p>'.'<h2>教学设计</h2>'.'<p>教学目的:'.$aim.'</p>'.'<p>教学方法:'.$method.'</p>'.'<p>教学重难点:'.$difficult.'</p>'.'<p>教学过程:'.$process.'</p>'.'<h2>教学准备</h2>'.'<p>学习目标:'.$saim.'</p>'.'<p>重难点预测:'.$sdifficult.'</p>'.'<p>预习资源:'.$sresources.'</p>'.'<p>互动探究:'.$explore.'</p>'.'<p>知识链接:'.$link.'</p>'.'<p>学法指导:'.$introduce.'</p>'.'<p>学习过程:'.$sprocess.'</p>'.'<p>反思:'.$reflect.'</p>'.'<p>教案资源:'.$ltext.'</p>'.'<p>课件资源:'.$ctext.'</p>'.'<p>上传的反思:'.$rtext.'</p>'.'<p>课堂实录:'.$rtext.'</p>');
            $path="./uploads/pdf/".$file_name.$time.'.pdf';
            $address = 'http://8.134.186.119/'.$path;
            $pdf->Output($path,'F');
            $aaa = Lesson::table('myLesson')->where('nanoid',$nanoid)->update(['name'=>$file_name,'path'=>$address,'cid'=>$cid,'time'=>$time,'nanoid'=>$nanoid,'uid'=>$uid,'id'=>1]);
            $bbb = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->delete();
            exit();
        }
       
    }

    // 渲染协同备课
    public function look($cid)
    {
        $res = Lesson::table('myLesson')->where('cid',$cid)->select();
        return json($res);
    }

    // 上传教案
    public function lesson($cid,$uid,$a)
    {
        $data = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->select();
        if($data=='[]'){
            $res = Lesson::table('lpath')->insert(['lPath'=>$a,'cid'=>$cid,'uid'=>$uid]);
            return $res;
        }else{ 
            $res = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->update(['lPath'=>$a]);
            return $res;
        }
    }

    // 上传课件
    public function courseware($cid,$uid,$b)
    {
        $data = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->select();
        if($data=='[]'){
            $res = Lesson::table('lpath')->insert(['cPath'=>$b,'cid'=>$cid,'uid'=>$uid]);
            return $res;
        }else{ 
            $res = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->update(['cPath'=>$b]);
            return $res;
        }
    }

    // 上传教学反思
    public function reflect($cid,$uid,$c)
    {
        $data = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->select();
        if($data=='[]'){
            $res = Lesson::table('lpath')->insert(['rPath'=>$c,'cid'=>$cid,'uid'=>$uid]);
            return $res;
        }else{ 
            $res = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->update(['rPath'=>$c]);
            return $res;
        }
    }

    // 上传课堂实录
    public function video($cid,$uid,$d)
    {
        $data = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->select();
        if($data=='[]'){
            $res = Lesson::table('lpath')->insert(['vPath'=>$d,'cid'=>$cid,'uid'=>$uid]);
            return $res;
        }else{ 
            $res = Lesson::table('lpath')->where('cid',$cid)->where('uid',$uid)->update(['vPath'=>$d]);
            return $res;
        }
    }

    // 删除备课
    public function del($nanoid)
     {
         $res = Lesson::table('Lesson')->where('nanoid',$nanoid)->delete();
         $a = Lesson::table('myLesson')->where('nanoid',$nanoid)->delete();
         return $res;
     }

    // 继续备课
    public function cont($nanoid)
    {
        $res = Lesson::table('Lesson')->where('nanoid',$nanoid)->select();
        return json($res);
    }

    // 探讨功能
    public function discuss($nanoid,$text)
    {
        $datatime = date('Y-m-d H:i:s');
        $result = Lesson::table('Member')->where('id',2)->find();
        $data = ['nanoid'=>$nanoid,'name'=>$result['name'],'text'=>$text,'datatime'=>$datatime];
        $res = Lesson::table('discuss')->insert($data);
        return $res;
    }

    // 渲染评论
    public function show($nanoid)
    {
        $res = Lesson::table('discuss')->where('nanoid',$nanoid)->select();
        return json($res);
    }

    // 回传课件
    public function echo($nanoid,$a,$path)
    {
        $datetime = date('Y-m-d H:i:s');
        $b = Lesson::table('Member')->where('id',2)->find();
        $data = ['name'=>$b['name'],'fname'=>$path,'datetime'=>$datetime,'path'=>$a,'nanoid'=>$nanoid];
        $res = Lesson::table('Echo')->insert($data);
        return $res;
    }

    // 渲染回传课件
    public function showEcho($nanoid)
    {
        $res = Lesson::table('Echo')->where('nanoid',$nanoid)->select();
        return json($res);
    }

}
