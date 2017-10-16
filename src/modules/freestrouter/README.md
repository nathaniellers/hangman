# freestrouter v0.1-alpha

First simple version of freestRouter

## Install

include in your PHP like so:
```
$router = new Router();       
$router->route('',          '0');
$router->route('index.php', '0');
$router->route('articles',  '1');
$router->route('article',   '1');
$router->route('fbadmin',   '2');
        
if ($router->get() == '1') {
  // index.php
}
```
