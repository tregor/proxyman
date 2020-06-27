<?php

namespace tregor\ProxyMan\Exception;

use Throwable;
use tregor\ProxyMan\Proxy;

/**
 * Error codes:
 * 0* - Error while initializing proxy
 * 1* - Error while connecting to proxy
 * 2* - Error while connecting to host
 *
 * Class ProxyException
 * @package tregor\ProxyMan\Exception
 */
class ProxyException extends \Exception
{
	public function __construct($message = "", $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}