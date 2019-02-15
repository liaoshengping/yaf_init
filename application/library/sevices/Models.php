<?php
namespace sevices;
/**
 * Created by PhpStorm.
 * Email: 1194008361@qq.com
 * User:liaosp.top
 * Date: 2019/2/14
 * Time: 21:35
 */
use think\Db;
use think\Model;
class Models extends Model
{
    public function __construct($data = [])
    {
        /*
        兼容Orm 链接
        */
        $name       = str_replace('\\', '/', static::class);
        $exp = explode('Model',$name);
        if(empty($exp[0])){
            throw new \Exception('缺少Model');
        }
        $name = strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $exp[0]));
        //赋值数据库名
        $this->name = $name;

        $info =yaconf('dbinfo');
        parent::__construct($data);
        Db::setConfig([
            // 数据库类型
            'type'            =>  $info['type'],
            // 服务器地址
            'hostname'        => $info['hostname'],
            // 数据库名
            'database'        => $info['database'],
            // 用户名
            'username'        => $info['username'],
            // 密码
            'password'        => $info['password'],
            // 端口
            'hostport'        => $info['hostport'],
            // 连接dsn
            'dsn'             => '',
            // 数据库连接参数
            'params'          => [],
            // 数据库编码默认采用utf8
            'charset'         => 'utf8',
            // 数据库表前缀
            'prefix'          => $info['prefix'],
            // 数据库调试模式
            'debug'           => false,
            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'          => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'     => false,
            // 读写分离后 主服务器数量
            'master_num'      => 1,
            // 指定从服务器序号
            'slave_no'        => '',
            // 是否严格检查字段是否存在
            'fields_strict'   => true,
            // 数据集返回类型
            'resultset_type'  => '',
            // 自动写入时间戳字段
            'auto_timestamp'  => false,
            // 时间字段取出后的默认时间格式
            'datetime_format' => 'Y-m-d H:i:s',
            // 是否需要进行SQL性能分析
            'sql_explain'     => false,
            // Builder类
            'builder'         => '',
            // Query类
            'query'           => '\\think\\db\\Query',
            // 是否需要断线重连
            'break_reconnect' => false,
            // 默认分页设置
            'paginate' => [
                'type'     => 'bootstrap',
                'var_page'  => 'page',
                'list_rows' => 15,
            ]
        ]);

    }

}