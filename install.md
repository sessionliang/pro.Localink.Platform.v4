
#### clone下来的代码需要修改权限 chown -R www 需要修改的目录 
##### 修改thinkphp/library/think/db/Connection.php
```
'params'          => [
            PDO::ATTR_CASE              => PDO::CASE_LOWER,
            PDO::ATTR_EMULATE_PREPARES  => true
],
```