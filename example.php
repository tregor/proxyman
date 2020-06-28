<?php
include_once "src/ProxyManager.php";
include_once "src/Proxy.php";
include_once "src/Exception/ProxyException.php";
include_once "src/Exception/ProxyTimeout.php";
include_once "src/Exception/ProxyUnreachable.php";

use tregor\ProxyMan\Exception\ProxyException;
use tregor\ProxyMan\ProxyManager;

$proxies = [
	["host" => "1.0.0.130", "port" => "80",],
	["host" => "1.0.0.144", "port" => "80",],
	["host" => "1.0.0.123", "port" => "80",],
	["host" => "1.0.0.141", "port" => "80",],
	["host" => "1.0.0.190", "port" => "80",],
	["host" => "1.0.0.23", "port" => "80",],
	["host" => "1.0.0.204", "port" => "80",],
	["host" => "1.0.0.93", "port" => "80",],
	["host" => "1.0.0.105", "port" => "80",],
	["host" => "1.0.0.203", "port" => "80",],
	["host" => "1.1.1.24", "port" => "80",],
	["host" => "1.1.1.35", "port" => "80",],
	["host" => "1.1.1.56", "port" => "80",],
	["host" => "1.1.1.78", "port" => "80",],
	["host" => "1.1.1.80", "port" => "80",],
	["host" => "1.1.1.215", "port" => "80",],
	["host" => "1.1.1.234", "port" => "80",],
	["host" => "1.0.0.178", "port" => "80",],
	["host" => "1.0.0.92", "port" => "80",],
	["host" => "1.0.0.29", "port" => "80",],
	["host" => "1.0.0.197", "port" => "80",],
	["host" => "1.0.0.117", "port" => "80",],
	["host" => "1.0.0.94", "port" => "80",],
	["host" => "1.0.0.206", "port" => "80",],
	["host" => "1.0.0.34", "port" => "80",],
	["host" => "1.0.0.56", "port" => "80",],
	["host" => "1.0.0.80", "port" => "80",],
	["host" => "1.0.0.227", "port" => "80",],
	["host" => "1.0.0.228", "port" => "80",],
	["host" => "1.0.0.236", "port" => "80",],
	["host" => "1.1.1.9", "port" => "80",],
	["host" => "1.1.1.61", "port" => "80",],
	["host" => "1.1.1.66", "port" => "80",],
	["host" => "1.1.1.84", "port" => "80",],
	["host" => "1.1.1.86", "port" => "80",],
	["host" => "1.1.1.184", "port" => "80",],
	["host" => "1.1.1.102", "port" => "80",],
	["host" => "52.179.231.206", "port" => "80",],
	["host" => "34.195.158.33", "port" => "8080",],
	["host" => "52.179.18.244", "port" => "8080",],
	["host" => "35.192.37.211", "port" => "3128",],
	["host" => "167.71.91.204", "port" => "8080",],
	["host" => "173.212.202.65", "port" => "80",],
	["host" => "51.77.162.148", "port" => "3128",],
	["host" => "207.154.231.213", "port" => "8080",],
	["host" => "144.76.174.21", "port" => "33472",],
	["host" => "203.202.245.62", "port" => "80",],
	["host" => "46.4.96.137", "port" => "3128",],
	["host" => "154.16.202.22", "port" => "3128",],
	["host" => "89.175.132.78", "port" => "33857",],
	["host" => "46.23.148.147", "port" => "49868",],
	["host" => "85.192.165.16", "port" => "45597",],
	["host" => "77.93.31.99", "port" => "15131",],
	["host" => "195.88.126.54", "port" => "48846",],
	["host" => "193.107.192.115", "port" => "28582",],
	["host" => "77.75.0.214", "port" => "38723",],
	["host" => "195.19.30.207", "port" => "10274",],
	["host" => "176.117.204.251", "port" => "43427",],
	["host" => "176.37.117.103", "port" => "46439",],
	["host" => "176.62.179.15", "port" => "34649",],
	["host" => "40.65.136.31", "port" => "8080",],
	["host" => "198.98.50.164", "port" => "8080",],
	["host" => "66.222.126.102", "port" => "80",],
	["host" => "46.218.155.194", "port" => "3128",],
];

foreach ($proxies as $proxy) {
	ProxyManager::addProxyHTTP($proxy["host"], $proxy["port"]);
}

$proxy = ProxyManager::getRandomProxy();
var_dump($proxy->getInfo());