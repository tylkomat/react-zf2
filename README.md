Zend Framework 2 and React PHP
==============================

[![Build Status](https://travis-ci.org/ftdebugger/react-zf2.png?branch=master)](https://travis-ci.org/ftdebugger/react-zf2)[![Dependency Status](https://www.versioneye.com/user/projects/51960dd0296d61000200f905/badge.png)](https://www.versioneye.com/user/projects/51960dd0296d61000200f905)

Integration of [zend framework 2](https://github.com/zendframework/zf2) and [react php](https://github.com/reactphp/react)

Install
-------

The recommended way to install is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "ftdebugger/react-zf2": "dev-master"
    }
}
```

Usage
-----

Append ReactZF module to `config/application.config.php`, then type in console

```BASH
# start default server at http://localhost:1337/
php -f public/index.php react start
```

Open [http://localhost:1337/](http://localhost:1337/).

Configuration
-------------

Add configuration to your `config/autoload/*`

```PHP
return array(
    'ReactZF' => array(
        'servers' => array(
            // You can rewrite default server options
            'default' => array(
                'port' => 1337,
                'host' => '127.0.0.1'
            )

            // Or specify your own
            'some-server-name-you-like' => array(
                'port' => 1338,

                // optional, react use 127.0.0.1 as default
                'host' => '192.168.0.117'
            ),
            ..
        )
    )
);
```