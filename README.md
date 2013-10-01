AuthYTHT
========

An authentication plugin to integrate MediaWiki with YTHT-liked Bulletin Board System.

Installation
------------

1. 安装 [BMYBBS](https://github.com/bmybbs/bmybbs) 并注册创建用户。
2. 安装 [MediaWiki](https://www.mediawiki.org/wiki/MediaWiki)
3. 下载本插件到 `extensions/` 路径下

```
git clone https://github.com/bmybbs/AuthYTHT.git
```

修改 MediaWiki 的 `LocalSettings.php` 文件，并在文件结尾加上如下两行：

```php
require_once('includes/AuthPlugin.php');
require_once('extensions/AuthYTHT/AuthYTHT.php');
$wgAuth = new AuthYTHT();
```
