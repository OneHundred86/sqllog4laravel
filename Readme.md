##### 一、功能说明

用于laravel框架，记录数据库执行语句的执行信息，包括执行时间和sql语句等。

日志记录驱动使用的是laravel配置的日志驱动。

##### 二、安装

```shell
composer require "oh86/sqllog"
```

##### 三、配置

1. 添加下面一行到 `config/app.php` 中 `providers` 部分：

   ```
   Oh86\Sqllog\SqllogServiceProvider::class,
   ```

2. 发布配置文件与资源

   ```
   php artisan vendor:publish --provider='Oh86\Sqllog\SqllogServiceProvider'
   ```

3. 配置.env

   ```
   SQLLOG_SLOW=true              # 是否开启sql慢日志记录
   SQLLOG_SLOW_TIME=0            # sql慢执行时间，毫秒
   SQLLOG_DEBUG_BACKTRACE=true   # 是否打印调用栈信息
   ```
