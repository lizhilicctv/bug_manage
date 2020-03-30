<?php
declare (strict_types = 1);

namespace app\controller;

use app\BaseController;
use app\model\Admin;
use app\model\AdminItem;
use app\model\Item;
use think\facade\Db;
use think\facade\Session;
use think\facade\View;
use think\Request;

class Manage extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        if(\think\facade\Request::ispost()){
            $data=input('post.');

            $validate = new \app\validate\Manage;
            $result = $validate->check($data);
            if(!$result){
                $this->error($validate->getError());
            }

            $info=Admin::manage($data);
            if($info == 1){
                return $this->success('信息正确，正在跳转','list');
            }else{
                return $this->error('用户名或密码错误');
            }
            die;
        }
        return View::fetch('',[

        ]);
    }
    public function list(){
        $item=Db::name('item')->order('id', 'desc')->paginate(15);

        return View::fetch('',[
                'item'=>$item
        ]);
    }
    public function member(){
        $item=Db::name('admin')->order('id', 'desc')->paginate(15)->each(function($item, $key){
            $itemid=Db::name('admin_item')->where('uid',$item['id'])->column('itemid');
            $name=Db::name('item')->where('id','in',$itemid)->column('name');
            $item['xiang'] =implode(",", $name);
            return $item;
        });

        return View::fetch('',[
            'item'=>$item
        ]);
    }
    public function madd()
    {

        if(\think\facade\Request::ispost()){

            $data=input('post.');
            $data['password']=md5(substr(md5($data['password']),0,25).'lizhili');
            if(isset($data['isopen'])){
                $data['isopen']=1;
            }else{
                $data['isopen']=0;
            }


            //这里应该验证，但是不验证了
            $user = new \app\model\Admin;
            $res=$user->save($data);
            if($res){
                //批量添加
                foreach ($data['item'] as $k=>$v){
                    $list[] =  ['uid'=>$user->id,'itemid'=>$v];
                }
                $admin_item = new AdminItem;
                $admin_item->saveAll($list);
                return '<script>alert("添加成功了！");parent.location.reload()</script>';
               // return $this->success('添加成功','member');
            }else{
                return $this->error('添加失败');
            }
            die;
        }

        return View::fetch('',[
            'item'=>Db::name('item')->select()
        ]);
    }
    public function medit()
    {

        if(\think\facade\Request::ispost()){

            $data=input('post.');
            if($data['password']!=''){
                $data['password']=md5(substr(md5($data['password']),0,25).'lizhili');
            }else{
                unset($data['password']);
            }
            if(isset($data['isopen'])){
                $data['isopen']=1;
            }else{
                $data['isopen']=0;
            }
            //这里应该验证，但是不验证了
            $user = new \app\model\Admin;
            $res=$user->update($data,['id'=>input('id')]);
            if($res){
                //批量添加
                Db::name('admin_item')->where('uid',input('id'))->delete();
                foreach ($data['item'] as $k=>$v){
                    $list[] =  ['uid'=>input('id'),'itemid'=>$v];
                }
                $admin_item = new AdminItem;
                $admin_item->saveAll($list);
                return '<script>alert("修改成功了！");parent.location.reload()</script>';
               // return $this->success('修改成功','member');
            }else{
                return $this->error('修改失败');
            }
            die;
        }
        return View::fetch('',[
            'data'=>Db::name('admin')->find(input('id')),
            'item'=>Db::name('item')->select(),
            'admin_item'=>Db::name('admin_item')->where('uid',input('id'))->column('itemid')
        ]);
    }
    public function add()
    {

        if(\think\facade\Request::ispost()){

            $data=input('post.');

            //这里应该验证，但是不验证了
            $user = new \app\model\item;
            $res=$user->save($data);
            if($res){
                return '<script>alert("添加成功了！");parent.location.reload()</script>';
               // return $this->success('添加成功','list');
            }else{
                return $this->error('添加失败');
            }
            die;
        }

        return View::fetch('',[

        ]);
    }
    public function edit()
    {

        if(\think\facade\Request::ispost()){

            $data=input('post.');

            //这里应该验证，但是不验证了
            $user = new \app\model\item;
            $res=$user->update($data,['id'=>input('id')]);
            if($res){
                return '<script>alert("修改成功了！");parent.location.reload()</script>';
               // return $this->success('修改成功','list');
            }else{
                return $this->error('修改失败');
            }
            die;
        }
        return View::fetch('',[
            'data'=>Db::name('item')->find(input('id'))
        ]);
    }
    public function ajax()
    {
        $data= \think\facade\Request::param();
        if($data['type']=='del'){
            if(Item::destroy($data['id'])){
                return 1;
            }else{
                return 0;
            }
        }


        return 0;
    }
    public function xiu()
    {

        if(\think\facade\Request::ispost()){

            $data=input('post.');

            //这里应该验证，但是不验证了
            $res=Db::name('manage')->where('id',1)->update(['password'=>md5(substr(md5($data['password']),0,25).'lizhili')]);
            if($res){
                return '<script>alert("修改成功了！");parent.location.reload()</script>';
                //return $this->success('修改成功');
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
