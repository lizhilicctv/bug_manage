<?php
declare (strict_types = 1);

namespace app\model;

use think\facade\Db;
use think\Model;

/**
 * @mixin think\Model
 */
class Admin extends Model
{
    //
    public static function cha($data)
    {
        $info=Db::name('admin')->where('username',$data['username'])->find();
        if($info){
            if(md5(substr(md5($data['password']),0,25).'lizhili')==$info['password']){
                if($info['isopen']==1){
                    if(Db::name('admin_item')->where('uid',$info['id'])->where('itemid',$data['item'])->find()){
                        session('username', $info['username']);
                        session('uid', $info['id']);
                        session('item', $data['item']);
                        return 1;//信息正确
                    }else{
                        return 2; //该项目没有权限
                    }
                }else{
                    return 0; //账号已经关闭
                }
            }else{
                return 0; //密码错误
            }
        }else{
            return 0;//用户名不存在
        }
    }
    public static function manage($data)
    {
        $info=Db::name('manage')->where('username',$data['username'])->find();
        if($info){
            if(md5(substr(md5($data['password']),0,25).'lizhili')==$info['password']){
                if($info['isopen']==1){
                    session('z_name', $info['username']);
                    session('z_uid', $info['id']);
                    return 1;//信息正确
                }else{
                    return 0; //账号已经关闭
                }
            }else{
                return 0; //密码错误
            }
        }else{
            return 0;//用户名不存在
        }
    }
}
