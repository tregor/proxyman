<?php

namespace tregor\ProxyMan\Exception;

use tregor\ProxyMan\Proxy;

class ProxyUnreachable extends ProxyException
{
	public function __construct(Proxy $proxy, $host)
	{
		if (!empty($proxy->getUsername())){
			$proxyInfo = $proxy->getUsername().":".$proxy->getPassword()."@".$proxy->getHost().":".$proxy->getPort();
		}else{
			$proxyInfo = $proxy->getHost().":".$proxy->getPort();
		}
		parent::__construct("Error with proxy [{$proxyInfo}]: "."Requested host \"{$host}\" can't be reached.", 21);
	}
}