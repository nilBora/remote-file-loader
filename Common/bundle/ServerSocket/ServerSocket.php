<?php

class ServerSocket
{
	const ACCESS_TOKEN_NAME = 'Access-token';
	public $host = '0.0.0.0';
	public $port = '8000';
	public $protocol = 'tcp://';
	
	public static $staticSocket = null;
	public $socket = null;
	
	public static $connectClient = null;
	
	private static $_instance = null;
	
	public $connect = null;
	
	public static $connects = array();
	
	public $accessToken = null;
	
	private function __construct()
	{
		$this->socket = stream_socket_server($this->protocol.$this->host.":".$this->port, $errno, $errstr);
		if (!$this->socket) {
			die("$errstr ($errno)");
		}

		self::$staticSocket = $this->socket;
		
		$this->_getDownloadsInstance();
	}
	
	static public function getInstance() {
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	private function _getDownloadsInstance()
	{
		$this->_downloads = new Downloads();
	}
	
	public static function getConnection()
	{
		return self::$connectClient;
	}
	
	public static function getSocket()
	{
		return self::$staticSocket;
	}
	
	public function getSock()
	{
		return $this->socket;
	}
	
	public function getConn()
	{
		return static::$connects;
	}
	
	public function start()
	{
		//print_r($this->socket);
		//$connects = array();
		while (true) {
			$connect = stream_socket_accept($this->socket, -1);
			static::$connects[] = $connect;
			
			$response = fread($connect, 1024);
			if (!$response) {
				continue;
			}
			$posTokenName = stripos($response, static::ACCESS_TOKEN_NAME);
			if ($posTokenName !== false) {
				$this->accessToken = trim(substr($response, $posTokenName+strlen(static::ACCESS_TOKEN_NAME)+1));
			}
			if(!$this->accessToken) {
				continue;
			}
			$url = $this->_downloads->getLinksByToken($this->accessToken);
			if ($url) {
				$data = $this->_getPrepareData($url);
				$this->doSendDataInClientByConnect($connect, $data);
			}
			//print_r($this->accessToken);
			
			//var_dump(static::$connects);
		}
		
	}

	private function _getPrepareData($url)
	{
		$data = array(
			'url' 	   => $url,
			'filename' => basename($url)
		);

		$json = json_encode($data);

		return $json;
	}
	
	public function doSendDataInClientByConnect($connect, $data)
	{
		fwrite($connect, $data);
		
		return true;
	}
}

//ServerSocket::getInstance();
//var_dump(ServerSocket::getSocket());
//$socketServer = new ServerSocket();
