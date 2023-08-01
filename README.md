[![Check & fix styling](https://github.com/curder/nova-demo/actions/workflows/pint.yml/badge.svg)](https://github.com/curder/nova-demo/actions/workflows/pint.yml)
[![Test Laravel Github action](https://github.com/curder/nova-demo/actions/workflows/run-test.yml/badge.svg?branch=10.x)](https://github.com/curder/nova-demo/actions/workflows/run-test.yml)

## 初始化

-   添加授权用户名，密码

```bash
composer config http-basic.nova.laravel.com ${NOVA_USERNAME} ${NOVA_LICENSE}
```

> 通过上面的命令可以设置对应的 Nova 授权，其中用户名为 https://nova.laravel.com 的登陆邮箱，密码在[Nova 设置处获取](https://nova.laravel.com/settings#password)

- 更新php依赖

```bash
composer install -vvv
```

- 修改配置

```bash
cp .env.example .env
```

> 在拷贝的 `.env` 文件中修改数据库连接。

- 执行迁移和填充

```bash
php artisan migrate:refresh --seed
```

- 登录地址

```
http://nova-demo.test
```

- 默认管理员用户名/密码：`super@example.com` / `password`

- 默认编辑用户名/密码：`example@example.com` / `password`


## 插件

-   [Laravel 权限管理 spatie/laravel-permission](https://github.com/spatie/laravel-permission)
-   [权限管理 vyuldashev/nova-permission](https://github.com/vyuldashev/nova-permission)
-   [枚举管理 bensampo/laravel-enum](https://github.com/BenSampo/laravel-enum)
