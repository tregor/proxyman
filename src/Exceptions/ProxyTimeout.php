<?php

namespace tregor\ProxyMan\Exception;

use tregor\ProxyMan\Proxy;

class ProxyTimeout extends ProxyException
{
	public function __construct(Proxy $proxy)
	{
		if (!empty($proxy->getUsername())){
			$proxyInfo = $proxy->getUsername().":".$proxy->getPassword()."@".$proxy->getHost().":".$proxy->getPort();
		}else{
			$proxyInfo = $proxy->getHost().":".$proxy->getPort();
		}
		parent::__construct("Error with proxy [{$proxyInfo}]: "."Proxy connection was timed out.", 11);
	}
}