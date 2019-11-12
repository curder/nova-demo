## 初始化

-   添加授权用户名，密码

```
composer config http-basic.nova.laravel.com ${NOVA_USERNAME} ${NOVA_PASSWORD}
```

> 通过上面的命令可以设置对应的 Nova 授权，其中用户名为 https://nova.laravel.com 的登陆邮箱，密码在[这里获取](https://nova.laravel.com/settings#password)

## 插件

-   [Laravel 权限管理 spatie/laravel-permission](https://github.com/spatie/laravel-permission)
-   [权限管理 vyuldashev/nova-permission](https://github.com/vyuldashev/nova-permission)
-   [枚举管理 bensampo/laravel-enum](https://github.com/BenSampo/laravel-enum)
