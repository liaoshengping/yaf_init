<?php

/**
 * Created by PhpStorm.
 * Email: 1194008361@qq.com
 * User:liaosp.top
 * Date: 2019/2/14
 * Time: 21:37
 */
use sevices\Models;
class UserModel extends Models
{
    public function test(){
        $info =Yaconf::get('im');
        var_dump($info);exit;
        echo"kk";exit;
    }
}