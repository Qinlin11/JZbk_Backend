<?php

namespace app\api\model;

use think\Model;
use Mpdf\Mpdf;

class Design extends Model
{
    
    // 展示对应课程
    public function index($cid)
    {
        $res = Design::table('lesson')->where('id',$cid)->select();
        return json($res);
    }

    // 教学设计
    public function design($cid,$uid,$analysis,$tool,$resources,$aim,$method,$difficult,$process,$saim,$sdifficult,$sresources,$explore,$link,$introduce,$sprocess,$reflect,$nanoid)
    {
        $test = Design::table('Design')->where('nanoid',$nanoid)->select();
        // $nanoid 不存在
        if($test=='[]'){
            $time =  date('YmdHis',time());
            $cat = Design::table('lesson')->where('id',$cid)->where('uid',$uid)->select();
            $file_name = $cat[0]['name'];
            $path = Design::table('path')->where('cid',$cid)->where('uid',$uid)->select();
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
            $data = ['cid'=>$cid,'id'=>$uid,'analysis'=>$analysis,'tool'=>$tool,'resources'=>$resources,'aim'=>$aim,'method'=>$method,'difficult'=>$difficult,'process'=>$process,'saim'=>$saim,'sdifficult'=>$sdifficult,'sresources'=>$sresources,'explore'=>$explore,'link'=>$link,'introduce'=>$introduce,'sprocess'=>$sprocess,'reflect'=>$reflect,'nanoid'=>$nanoid,'lpath'=>$a,'cpath'=>$b,'rpath'=>$c,'vpath'=>$d];
            $res = Design::table('Design')->insert($data);
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
            $pdf->WriteHTML($title.'<h2>教学准备</h2>'.'<p>学情分析:'.$analysis.'</p>'.'<p>教学工具:'.$tool.'</p>'.'<p>教学资源:'.$resources.'</p>'.'<h2>教学设计</h2>'.'<p>教学目的:'.$aim.'</p>'.'<p>教学方法:'.$method.'</p>'.'<p>教学重难点:'.$difficult.'</p>'.'<p>教学过程:'.$process.'</p>'.'<h2>教学准备</h2>'.'<p>学习目标:'.$saim.'</p>'.'<p>重难点预测:'.$sdifficult.'</p>'.'<p>预习资源:'.$sresources.'</p>'.'<p>互动探究:'.$explore.'</p>'.'<p>知识链接:'.$link.'</p>'.'<p>学法指导:'.$introduce.'</p>'.'<p>学习过程:'.$sprocess.'</p>'.'<p>反思:'.$reflect.'</p>'.'<p>教案资源:'.$ltext.'</p>'.'<p>课件资源:'.$ctext.'</p>'.'<p>上传的反思:'.$rtext.'</p>'.'<p>课堂实录:'.$vtext.'</p>');
            $path="./uploads/pdf/".$file_name.$time.'.pdf';
            $address = 'http://8.134.186.119/'.$path;
            $pdf->Output($path,'F');
            $aaa = Design::table('myDesign')->insert(['name'=>$file_name,'path'=>$address,'cid'=>$cid,'nanoid'=>$nanoid,'time'=>$time,'uid'=>$uid]);
            $bbb = Design::table('path')->where('cid',$cid)->where('uid',$uid)->delete();
            exit();
        }else{
            // $nanoid 存在
            $cat = Design::table('lesson')->where('id',$cid)->where('uid',$uid)->select();
            $file_name = $cat[0]['name'];
            $path = Design::table('path')->where('cid',$cid)->where('uid',$uid)->select();
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
            $data = ['cid'=>$cid,'id'=>$uid,'analysis'=>$analysis,'tool'=>$tool,'resources'=>$resources,'aim'=>$aim,'method'=>$method,'difficult'=>$difficult,'process'=>$process,'saim'=>$saim,'sdifficult'=>$sdifficult,'sresources'=>$sresources,'explore'=>$explore,'link'=>$link,'introduce'=>$introduce,'sprocess'=>$sprocess,'reflect'=>$reflect,'nanoid'=>$nanoid,'lpath'=>$a,'cpath'=>$b,'rpath'=>$c,'vpath'=>$d];
            $res = Design::table('Design')->where('nanoid',$nanoid)->update($data);
            $new =  Design::table('myDesign')->where('nanoid',$nanoid)->select();
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
            $aaa = Design::table('myDesign')->where('nanoid',$nanoid)->update(['name'=>$file_name,'path'=>$address,'cid'=>$cid,'time'=>$time,'nanoid'=>$nanoid,'uid'=>$uid]);
            $bbb = Design::table('path')->where('cid',$cid)->where('uid',$uid)->delete();
            exit();
        }
        
    }

    // 渲染我的教学设计
    public function look($cid)
    {
        $res = Design::table('myDesign')->where('cid',$cid)->select();
        return json($res);
    }

    public function lesson($cid,$uid,$a)
    {
        $data = Design::table('path')->where('cid',$cid)->where('uid',$uid)->select();
        if($data=='[]'){
            $res = Design::table('path')->insert(['lPath'=>$a,'cid'=>$cid,'uid'=>$uid]);
            return $res;
        }else{ 
            $res = Design::table('path')->where('cid',$cid)->where('uid',$uid)->update(['lPath'=>$a]);
            return $res;
        }
    }

    public function courseware($cid,$uid,$b)
    {
        $data = Design::table('path')->where('cid',$cid)->where('uid',$uid)->select();
        if($data=='[]'){
            $res = Design::table('path')->insert(['cPath'=>$b,'cid'=>$cid,'uid'=>$uid]);
            return $res;
        }else{ 
            $res = Design::table('path')->where('cid',$cid)->where('uid',$uid)->update(['cPath'=>$b]);
            return $res;
        }
    }

    public function reflect($cid,$uid,$c)
    {
        $data = Design::table('path')->where('cid',$cid)->where('uid',$uid)->select();
        if($data=='[]'){
            $res = Design::table('path')->insert(['rPath'=>$c,'cid'=>$cid,'uid'=>$uid]);
            return $res;
        }else{ 
            $res = Design::table('path')->where('cid',$cid)->where('uid',$uid)->update(['rPath'=>$c]);
            return $res;
        }
    }

    public function video($cid,$uid,$d)
    {
        $data = Design::table('path')->where('cid',$cid)->where('uid',$uid)->select();
        if($data=='[]'){
            $res = Design::table('path')->insert(['vPath'=>$d,'cid'=>$cid,'uid'=>$uid]);
            return $res;
        }else{ 
            $res = Design::table('path')->where('cid',$cid)->where('uid',$uid)->update(['vPath'=>$d]);
            return $res;
        }
    }

    // 删除教学设计
    public function del($nanoid)
    {
        $res = Design::table('Design')->where('nanoid',$nanoid)->delete();
        $a = Design::table('myDesign')->where('nanoid',$nanoid)->delete();
        return $res;
    }

    // 继续备课
    public function cont($nanoid)
    {
        $res = Design::table('Design')->where('nanoid',$nanoid)->select();
        return json($res);
    }
}
