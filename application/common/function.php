<?php
/**
 * @author liaoshengping@haoxiaec.com
 * @Time: 2019/2/15 -14:32
 * @Version 1.0
 * @Describe:
 * 1:
 * 2:
 * ...
 */
function yaconf($name = ''){
    $file = 'yafinit';//可修改
    return Yaconf::get($file.'.'.$name);
}