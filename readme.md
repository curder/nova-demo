## 初始化

-   添加授权用户名，密码

```
composer config http-basic.nova.laravel.com ${NOVA_USERNAME} ${NOVA_PASSWORD}
```

> 通过上面的命令可以设置对应的 Nova 授权，其中用户名为 https://nova.laravel.com 的登陆邮箱，密码在[这里获取](https://nova.laravel.com/settings#password)

- 更新php依赖

```
composer install -vvv
```

- 修改配置

```
cp .env.example .env
```

> 在拷贝的 `.env` 文件中修改数据库连接。

- 执行迁移

```
php artisan migrate
```

- 填充默认数据

```
php artisan db:seed
```

- 登录

```
http://nova-demo.test
```

默认管理员用户名/密码：`superAdminManager@example.com` / `aaaaaa`
编辑用户名/密码：`editorManager@example.com` / `aaaaaa`


## 插件

-   [Laravel 权限管理 spatie/laravel-permission](https://github.com/spatie/laravel-permission)
-   [权限管理 vyuldashev/nova-permission](https://github.com/vyuldashev/nova-permission)
-   [枚举管理 bensampo/laravel-enum](https://github.com/BenSampo/laravel-enum)
