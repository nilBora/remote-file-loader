<?php
include_once "ServerSocket.php";
include_once "db.php";
//$soct = new ServerSocket();
$instance = ServerSocket::getInstance();

print_r($instance->getSock());
print_r($instance->getConn());
//var_dump($instance::getSocket());
//var_dump($instance::getConnection());
//exit;
class HttpRules
{
	private $_request;
	private $_url;
	
	public $api = array(
		'api/get/download/links'
	);
	
	public $links = array(
		'http://www.google.com/images/srpr/logo3w.png',
		'http://goodimg.ru/img/kotiki-kartinki5.jpg'
	);
	
	public function __construct()
	{
		$this->_request = $_REQUEST;
		
		$this->_parseUrl();
		
		$this->_doDownloadLinks();
	}
	
	public function _doDownloadLinks()
	{
		foreach ($this->api as $link) {
			
			if (preg_match('#'.$link.'#Umis', $this->_url)) {
				if ($this->links) {
					foreach ($this->links as $url) {
						$data = array(
							'url' 	   => $url,
							'filename' => basename($url)
						);
						
						
						//$this->sendJson($data);
					}
				}
			}
		}
	}
	
	public function sendData($data, $connect)
	{
		fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nПривет");
        fclose($connect);
		
		return true;
	}
	
	
	public function sendJson($data)
	{
		$json = json_encode($data);
		echo $json;
		exit;
	}
	
	private function _parseUrl()
	{
		if ($this->_isUrlInRequest()) {
			$this->_url = $this->_request['url'];
		}
	}
	
	private function _isUrlInRequest()
	{
		return array_key_exists('url', $this->_request);
	}
}

//$new = new HttpRules();