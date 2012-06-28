AVATARS IO PHP
==============

THIS IS A VERY EARLY STAGE WRAPPER FOR AVATARS.IO. However, the API will remain stable you can use it and nothing will break in the future.

Won't work on it before next week, the current version is only a fast code to learn the avatars.io API, however it works, coming next :
- tests
- injectable httpclient
- more features (better handling of url generation for example)
- refactoring


[![Build Status](https://secure.travis-ci.org/jjaffeux/avatars-io-php.png?branch=master)](http://travis-ci.org/jjaffeux/avatars-io-php)


Setup
-----
composer.json :
``` json
{
    "require": {
        "jjaffeux/avatars-io-php": ">=1.0.0"
    }
}
```
``` php
$avatar = new \AvatarsIo\Avatar(CLIENT ID, SECRET KEY);
``` 

General Usage
-------------

``` php
$avatar->upload('filepath', 'identifier'); //identifier is optionnal
$avatar->url('twitter', 'twitter username', 'size') //size is optionnal, can be small, medium, large
``` 


Bug tracker
-----------

Have a bug? Please create an issue here on GitHub!


Contributions
-------------

* Fork
* Write tests (phpunit in the directory to run the tests)
* Write Code
* Pull request

Thanks for your help.


Authors
-------

**Joffrey Jaffeux**

+ http://twitter.com/joffreyjaffeux
+ http://github.com/jjaffeux

License
---------------------

MIT License