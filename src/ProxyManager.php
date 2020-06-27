<?php

namespace tregor\ProxyMan;

use tregor\ProxyMan\Exception\ProxyException;

class ProxyManager
{
	private static $proxyList;
	private static $debug = FALSE;

	public static function addProxyHTTP($host, $port, $username = "", $password = "")
	{
		self::$proxyList[] = new Proxy("HTTP", $host, $port, $username, $password);

		return self::$proxyList[key(array_slice(self::$proxyList, -1))];
	}

	public static function addProxyHTTPS($host, $port, $username = "", $password = "")
	{
		self::$proxyList[] = new Proxy("HTTPS", $host, $port, $username, $password);

		return self::$proxyList[key(array_slice(self::$proxyList, -1))];
	}

	public static function addProxySOCKS4($host, $port, $username = "", $password = "")
	{
		self::$proxyList[] = new Proxy("SOCKS5", $host, $port, $username, $password);

		return self::$proxyList[key(array_slice(self::$proxyList, -1))];
	}

	public static function addProxySOCKS5($host, $port, $username = "", $password = "")
	{
		self::$proxyList[] = new Proxy("SOCKS4", $host, $port, $username, $password);

		return self::$proxyList[key(array_slice(self::$proxyList, -1))];
	}

	public static function getRandomProxy()
	{
		if (count(self::$proxyList) == 1){
			throw new ProxyException("No proxy is available", 01);
		}
		$proxyID = rand(0, count(self::$proxyList)-1);
		$proxy = self::$proxyList[$proxyID];
		if (self::$debug) echo "Checking proxy... {$proxy->getHostPort()}";

		try{
			$result = $proxy->checkConnection();
			if ($result === TRUE){
				if (self::$debug) echo "Found proxy!" . PHP_EOL;
				return $proxy;
			}else{
				if (self::$debug) echo "Something strange..." . PHP_EOL;
			}
		}catch (ProxyException $e){
			if (self::$debug) echo "Bad proxy!".$e->getMessage() . PHP_EOL;
			unset(self::$proxyList[$proxyID]);
			shuffle(self::$proxyList);
			return self::getRandomProxy();
		}
	}

	public static function checkProxy($host, $port, $timout = 1)
	{
		$errno = $errstr = $response = null;
		$fp = @fsockopen($host, $port, $errno, $errstr, $timout);

		if ($fp) {
			stream_set_timeout($fp, $timout);

			fputs($fp, "GET https://www.google.com/ HTTP/1.0\r\n\r\n");

			while (!feof($fp)) {
				$response .= fgets($fp, 64000);
			}

			fclose($fp);
			var_dump($response);
			return TRUE;
		} else {
			if (self::$debug) echo "Error while checking proxy! [{$errno}] {$errstr}" . PHP_EOL;
			return FALSE;
		}
	}

	public static function getAllProxies()
	{
		$proxies = [];
		foreach (self::$proxyList as $proxy){
			$proxies[] = $proxy->getInfo();
		}
		return $proxies;
	}
}