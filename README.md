# ProxyMan

[![Total Downloads](https://img.shields.io/packagist/dt/tregor/proxyman?style=flat-square)](https://packagist.org/packages/tregor/proxyman)
[![GitHub Version](https://img.shields.io/github/tag/tregor/proxyman.svg?style=flat-square)](https://github.com/tregor/proxyman)
[![Last Commit](https://img.shields.io/github/last-commit/tregor/proxyman.svg?style=flat-square)](https://github.com/tregor/proxyman)
[![PHP Req](https://img.shields.io/packagist/php-v/tregor/proxyman.svg?style=flat-square)](https://packagist.org/packages/tregor/proxyman)
[![License](https://img.shields.io/github/license/tregor/proxyman?style=flat-square)](LICENSE)


ProxyMan is OpenSource library for PHP, that makes work with proxies easy!

It providing useful proxy manager, that contains any count of proxies, makes automatic connection test and provides easy to use proxy server information  

---
## Navigation
- [Requirements](#requirements)
- [Installation](#installation)
- [Quick Start](#quick-start-and-usage)
- [Available Methods](#available-methods)
- [TODO](#todo)
- [Contribute](#contribute)
- [License](#license)
- [Copyright](#copyright)

---

## Requirements

This library is supported by **PHP versions 5.4** or higher.

## Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/download/).

To install **PHP ErrorHandler library**, simply:

    $ composer require tregor/proxyman

You can also **clone the complete repository** with Git:

    $ git clone https://github.com/tregor/proxyman.git

## Quick Start and Usage

You can see more in [example.php](example.php) file.
```php
<?php
use tregor\ProxyMan\Exception\ProxyException;
use tregor\ProxyMan\ProxyManager;

//Adding proxy to manager
ProxyManager::addProxyHTTP("127.0.0.1", "3128");

//Simple Curl request with proxy
$ch = curl_init("https://www.google.com");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

try{
    //Getting random proxy from Manager
    $proxy = ProxyManager::getRandomProxy();
}catch (ProxyException $e){
	echo "Error occurred: ".$e->getMessage();
}

//Setting Curl proxy type by Proxy method
curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy->getType());

//Setting Curl proxy host and port string by Proxy method
curl_setopt($ch, CURLOPT_PROXY, $proxy->getHostPort());

if ($proxy->hasAuth()){
	curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
	
	//Setting Curl proxy username and password string by Proxy method
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy->getUserPass());
}

$response = curl_exec($ch);
curl_close($ch);

echo "<pre>".$response."</pre>";
```

## Available Methods

Available methods in this library:

### - Adding proxy:

This will add proxy to your proxy list. You must to chose method that coresponds your proxy type (HTTP, HTTPS, SOCKS4, SOCKS5).
```php
ProxyManager::addProxyHTTP(string $host, string $port, string $username = "", string $password = "");
```
```php
ProxyManager::addProxyHTTPS(string $host, string $port, string $username = "", string $password = "");
```
```php
ProxyManager::addProxySOCKS4(string $host, string $port, string $username = "", string $password = "");
```
```php
ProxyManager::addProxySOCKS5(string $host, string $port, string $username = "", string $password = "");
```

### - Get random proxy

This will return one of your proxies, after it automatic test. 
```php
ProxyManager::getRandomProxy();
```

### - Get all available proxies

This will return array of your proxies, that is current available. 
```php
ProxyManager::getAllProxies();
```

### - Check proxy is alive

This will try to connect to provided URL through your proxy. 
```php
$proxy->checkConnection(string $url = "https://www.google.com/", string $method = "GET", int $timeout = 1);
```

### - Get proxy information

This will return array with proxy info. Array contains:  proxy type, host, port, username, password, ping in ms (if connection through proxy was tested).
```php
$proxy->getInfo();
```

### - Proxy auth

This will return boolean TRUE if proxy server needs auth or FALSE if doesn't.
```php
$proxy->hasAuth();
```


## TODO

- [ ] Make tests.
- [ ] Improve documentation.
- [ ] Refactor code.
- [ ] Make it better.
- [ ] Take a cup of coffee.

## Contribute

If you would like to help, please take a look at the list of
[issues](https://github.com/tregor/proxyman/issues) or the [ToDo](#-todo) checklist.

**Pull requests**

* [Fork and clone](https://help.github.com/articles/fork-a-repo).
* Run the **tests**.
* Create a **branch**, **commit**, **push** and send me a
  [pull request](https://help.github.com/articles/using-pull-requests).

## License

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

## Copyright

By tregor 2020

Please let me know, if you have feedback or suggestions.

You can contact me on [Facebook](https://www.facebook.com/tregor1997) or through my [email](mailto:tregor1997@gmail.com).