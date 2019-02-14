# GuzzleTool
多资源网络请求，用于微服务请求，Oauth2.0 请求，Composer包

安装依赖

>composer require guzzlehttp/guzzle

>composer require liaosp/guzzle-tool

使用方法：继承这个类。

配置资源地址：

比如在yaconf 中配置：
```
[resources]
goods='http://devzuul.22.com/api/php/product'
order='http://devzuul.22.com/api/php/order'
oauth='http://devoauth.22.com'
personal='http://devzuul.22.com/api/authorize'
```


```php
class Resources extends ResourcesTool
{
    private $resources;
    /*
     * 微服务url 资源。
     *
     */
    public function __construct($resources = 'goods')
    {
        //配置服务信息。
        $this->ServicesUrl = yaconf('resources');
        parent::__construct($resources);
    }


}
```
使用方法：
(new Resources('personal'))->json()->get('/users/WARE/add');

更新日志：

1.0 测试环境

2.0 生产环境


