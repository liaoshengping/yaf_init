<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think;

use think\db\Query;

/**
 * Class Db
 * @package think
 * @method Query table(string $table) static 指定数据表（含前缀）
 * @method Query name(string $name) static 指定数据表（不含前缀）
 * @method Query where(mixed $field, string $op = null, mixed $condition = null) static 查询条件
 * @method Query join(mixed $join, mixed $condition = null, string $type = 'INNER') static JOIN查询
 * @method Query union(mixed $union, boolean $all = false) static UNION查询
 * @method Query limit(mixed $offset, integer $length = null) static 查询LIMIT
 * @method Query order(mixed $field, string $order = null) static 查询ORDER
 * @method Query cache(mixed $key = null , integer $expire = null) static 设置查询缓存
 * @method mixed value(string $field) static 获取某个字段的值
 * @method array column(string $field, string $key = '') static 获取某个列的值
 * @method Query view(mixed $join, mixed $field = null, mixed $on = null, string $type = 'INNER') static 视图查询
 * @method mixed find(mixed $data = null) static 查询单个记录
 * @method mixed select(mixed $data = null) static 查询多个记录
 * @method integer insert(array $data, boolean $replace = false, boolean $getLastInsID = false, string $sequence = null) static 插入一条记录
 * @method integer insertGetId(array $data, boolean $replace = false, string $sequence = null) static 插入一条记录并返回自增ID
 * @method integer insertAll(array $dataSet) static 插入多条记录
 * @method integer update(array $data) static 更新记录
 * @method integer delete(mixed $data = null) static 删除记录
 * @method boolean chunk(integer $count, callable $callback, string $column = null) static 分块获取数据
 * @method \Generator cursor(mixed $data = null) static 使用游标查找记录
 * @method mixed query(string $sql, array $bind = [], boolean $master = false, bool $pdo = false) static SQL查询
 * @method integer execute(string $sql, array $bind = [], boolean $fetch = false, boolean $getLastInsID = false, string $sequence = null) static SQL执行
 * @method Paginator paginate(integer $listRows = 15, mixed $simple = null, array $config = []) static 分页查询
 * @method mixed transaction(callable $callback) static 执行数据库事务
 * @method void startTrans() static 启动事务
 * @method void commit() static 用于非自动提交状态下面的查询提交
 * @method void rollback() static 事务回滚
 * @method boolean batchQuery(array $sqlArray) static 批处理执行SQL语句
 * @method string getLastInsID($sequence = null) static 获取最近插入的ID
 */
class Db
{
    /**
     * 数据库配置
     * @var array
     */
    protected static $config = [];

    /**
     * 查询类名
     * @var string
     */
    protected static $query;

    /**
     * 查询类自动映射
     * @var array
     */
    protected static $queryMap = [
        'mongo' => '\\think\\db\Mongo',
    ];

    /**
     * 查询次数
     * @var integer
     */
    public static $queryTimes = 0;

    /**
     * 执行次数
     * @var integer
     */
    public static $executeTimes = 0;

    /**
     * 缓存对象
     * @var object
     */
    protected static $cacheHandler;

    public static function setConfig($config = [])
    {
        self::$config = array_merge(self::$config, $config);
    }

    public static function getConfig($name = null)
    {
        if ($name) {
            return isset(self::$config[$name]) ? self::$config[$name] : null;
        } else {
            return self::$config;
        }
    }

    public static function setQuery($query)
    {
        self::$query = $query;
    }

    /**
     * 字符串命名风格转换
     * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
     * @param string  $name 字符串
     * @param integer $type 转换类型
     * @param bool    $ucfirst 首字母是否大写（驼峰规则）
     * @return string
     */
    public static function parseName($name, $type = 0, $ucfirst = true)
    {
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);
            return $ucfirst ? ucfirst($name) : lcfirst($name);
        } else {
            return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
        }
    }

    public static function setCacheHandler($cacheHandler)
    {
        self::$cacheHandler = $cacheHandler;
    }

    public static function getCacheHandler()
    {
        return self::$cacheHandler;
    }

    public static function __callStatic($method, $args)
    {
        if (!self::$query) {
            $type = strtolower(self::getConfig('type'));

            $class = isset(self::$queryMap[$type]) ? self::$queryMap[$type] : '\\think\\db\\Query';

            self::$query = $class;
        }

        $class = self::$query;

        return call_user_func_array([new $class, $method], $args);
    }
}
