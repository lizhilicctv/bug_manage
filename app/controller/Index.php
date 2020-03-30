<?php
namespace app\controller;

use app\model\Admin;
use think\facade\Filesystem;
use think\facade\Request;
use app\BaseController;
use think\facade\Db;
use think\facade\Session;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        if(Request::ispost()){
            $data=input('post.');

            $validate = new \app\validate\Index;
            $result = $validate->check($data);
            if(!$result){
                $this->error($validate->getError());
            }

            $info=Admin::cha($data);
            if($info == 1){
                return $this->success('信息正确，正在跳转',url('index/list'));
            }elseif ($info == 2){
                $this->error('没有改项目权限！');
            }else{
                return $this->error('用户名或密码错误');
            }
            die;
        }
       $item=Db::name('item')->field('id,name')->select();
       return View::fetch('',[
           'item'=>$item
       ]);
    }

    public function list()
    {
       if(!Session::has('username') or !Session::has('item') or !Session::has('uid')){
           Session::clear();
           $this->error('非法访问',url('index/index'));
       }
        $item_name=Db::name('item')->where('id',Session::get('item'))->value('name');
       $admin_type=Db::name('admin')->where('id',Session::get('uid'))->value('type');

       $list=Db::name('bug')->where('iswan',0)->order('id', 'desc')->paginate(15)->each(function($item, $key){
           $item['bugname'] = Db::name('admin')->where('id',$item['bug_uid'])->value('username');
           $item['resname'] = Db::name('admin')->where('id',$item['res_uid'])->value('username');
           return $item;
       });


        return View::fetch('',[
            'item_name'=>$item_name,
            'admin_type'=>$admin_type,
            'list'=>$list
        ]);
    }
	public function add()
	{
        if(Request::ispost()){
            $data=input('post.');
            //这里应该验证，但是不验证了
            $shu = [
                'title'=>$data['title'],
                'level'=>$data['level'],
                'bug_text'=>$data['bug_text'],
                'bug_time'=>time(),
                'bug_uid'=>Session::get('uid'),
                'itemid'=>Session::get('item')
            ];
            $res=Db::name('bug')->insertGetId($shu);
            if($res){
                if($res<10){
                    $num=Session::get('item').'00'.$res;
                }elseif ($res>=10 and $res<100){
                    $num=Session::get('item').'0'.$res;
                }else{
                    $num=Session::get('item').''.$res;
                }
                Db::name('bug') ->where('id', $res)->update(['on' => $num]);
                return '<script>alert("添加成功了！");parent.location.reload()</script>';
                //return $this->success('添加成功',url('index/list'));
            }else{
                return $this->error('添加失败');
            }
            die;
        }
        return View::fetch('',[
            'id'=>input('id'),
        ]);
	}
    public function edit()
    {

        if(Request::ispost()){
            $data=input('post.');
            //这里应该验证，但是不验证了
            if(isset($data['iswan'])){
                $data['iswan']=1;
            }else{
                $data['iswan']=0;
            }
            $data['ischu']=0;
            $res=Db::name('bug')->strict(false)->where('id', input('id'))->update($data);
            if($res){
                return '<script>alert("修改成功了！");parent.location.reload()</script>';
               // return $this->success('修改成功',url('index/list'));
            }else{
                return $this->error('修改失败');
            }
            die;
        }

        return View::fetch('',[
            'id'=>input('id'),
            'data'=>Db::name('bug')->find(input('id'))
        ]);
    }
    public function chu()
    {

        if(Request::ispost()){
            $data=input('post.');
            if($data['res']==0){
                return $this->error('不能选择 尚未处理');
            }
            $shu = [
                'res_time'=>time(),
                'res_uid'=>Session::get('uid'),
                'res_text'=>$data['res_text'],
                'res'=>$data['res'],
                'ischu'=>1
            ];
           $res= Db::name('bug')->where('id', input('id'))->update($shu);
            if($res){
                return '<script>alert("修改成功了！");parent.location.reload()</script>';
             //   return $this->success('更新成功',url('index/list'));
            }else{
                return $this->error('修改失败');
            }
            die;
        }

        $data=Db::name('bug')->find(input('id'));
        return View::fetch('',[
            'data'=>$data,
            'id'=>input('id'),
        ]);
    }
    public function imgupdate()
    {
        $file = request()->file('file');
        $savename = Filesystem::disk('public')->putFile( 'topic', $file);
        $li=strtr($savename," \ "," / ");
        return json([
              "code"=> 0
              ,"msg"=> "" //提示信息 //一般上传失败后返回
              ,"data"=> [
                 "src"=> '/storage/'.$li
                ,"title"=> "" //可选
              ]
        ]);

    }
    public function ajax()
    {
        $data=Request::param();
        if($data['type']=='put'){


        }


        return 0;
    }
    public function xiu()
    {

        if(\think\facade\Request::ispost()){

            $data=input('post.');

            //这里应该验证，但是不验证了
            $res=Db::name('admin')->where('id',Session::get('uid'))->update(['password'=>md5(substr(md5($data['password']),0,25).'lizhili')]);
            if($res){
                return '<script>alert("修改成功了！");parent.location.reload()</script>';
              //  return $this->success('修改成功');
            }else{
                return $this->error('修改失败');
            }
            die;
        }

        return View::fetch('',[

        ]);
    }
    public function out()
    {
        session(null);
        return $this->success('退出成功','index');
    }
}
