hatebu2qiitaStock
=================

qiita記事をはてブしたらqiitaでストックする（Google App Engine版）

# 使い方

`app.yml`を用意します。

``` yml:app.yml
application: your-GAE-product-id
version: 1
runtime: php55
api_version: 1

handlers:
- url: /.*
  script: hatebu-web-hook.php
```

Qiitaのアクセストークンを設定します。

``` php:Secret.php
<?php
class Secret {
    private static $qiita = 'your qiita access token';

    public static function getQiita() {
        return Secret::$qiita;
    }
}
```

GAEにデプロイしたら、はてブの設定ページでweb hookの設定を行います。

# その他

車輪の再発明な気がします。
