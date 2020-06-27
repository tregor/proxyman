<?php


namespace tregor\ProxyMan;


use tregor\ProxyMan\Exception\ProxyException;
use tregor\ProxyMan\Exception\ProxyTimeout;
use tregor\ProxyMan\Exception\ProxyUnreachable;

class Proxy
{
	private $type = CURLPROXY_HTTP;
	private $host = "";
	private $port = "";
	private $username = "";
	private $password = "";
	private $info = [];

	/**
	 * Proxy constructor.
	 * @param string $type Type of proxy, "http", "https", "socks4" or "socks5"
	 * @param string $host Host of proxy
	 * @param string $port Port of proxy
	 * @param string|NULL $username Username for proxy auth, default empty
	 * @param string|NULL $password Password for proxy auth, default empty
	 */
	public function __construct($type, $host, $port, $username = "", $password = "")
	{
		switch (strtoupper(trim($type))) {
			case "HTTP":
				$this->type = CURLPROXY_HTTP;
				break;
			case "HTTPS":
				$this->type = CURLPROXY_HTTPS;
				break;
			case "SOCKS4":
				$this->type = CURLPROXY_SOCKS4;
				break;
			case "SOCKS5":
				$this->type = CURLPROXY_SOCKS5;
				break;
		}
		$this->host = $host;
		$this->port = $port;
		$this->username = $username;
		$this->password = $password;

		$this->info = [
			"type" => strtoupper(trim($type)),
			"host" => $host,
			"port" => $port,
			"username" => $username,
			"password" => $password,
		];
	}

	public function checkConnection($url = "https://www.google.com/", $method = "GET", $timeout = 1)
	{
		$refer = parse_url($url)["host"];

		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_TIMEOUT_MS => $timeout*1000,
			CURLOPT_CONNECTTIMEOUT => $timeout,
			CURLOPT_FOLLOWLOCATION => TRUE,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HEADER => TRUE,
			CURLOPT_USERAGENT => "Mozila/4.0",
			CURLOPT_REFERER => $refer,
			CURLOPT_COOKIE => "test=cookie",
			CURLOPT_PROXYTYPE => $this->type,
			CURLOPT_PROXY => $this->host . ":" . $this->port,
		]);

		if ($method == "GET"){
			curl_setopt($ch, CURLOPT_URL, $url."?q=test");
		}elseif ($method == "POST"){
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, ["q"=>"test"]);
		}

		if (!empty($this->username)) {
			curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->username . ":" . $this->password);
		}

		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
		if ($response === FALSE){
			if (curl_errno($ch) == 28){
				throw new ProxyTimeout($this);
			}elseif (curl_errno($ch) == 56){
				throw new ProxyUnreachable($this, $refer);
			}else{
				throw new ProxyException(curl_error($ch));
			}
		}else{
			$this->info["ping"] = $info["connect_time"]*1000;
		}
		curl_close($ch);

		return TRUE;
	}

	/**
	 * @return array
	 */
	public function getInfo()
	{
		return $this->info;
	}

	/**
	 * @return string
	 */
	public function getHostPort()
	{
		return $this->host.":".$this->port;
	}

	/**
	 * @return string
	 */
	public function getHost()
	{
		return $this->host;
	}

	/**
	 * @return string
	 */
	public function getPort()
	{
		return $this->port;
	}

	public function hasAuth()
	{
		return (!empty($this->username));
	}

	/**
	 * @return string
	 */
	public function getUserPass()
	{
		return $this->host.":".$this->port;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

}