<?php

namespace AvatarsIo;

class Client extends Avatar {

	const version = 'v1';
	
	protected $content;
	protected $browser;
	
	function __construct()
	{	
		$this->browser = new \Buzz\Browser();
	}

	function post($content, $headers, $endpoint)
	{
		$request = $this->browser->post(
			self::base_uri . '/'. self::version . '/' . $endpoint,
				$headers, 
				json_encode($content)
			);
		
		return $this->response($request);
	}
	
	function put($content, $headers, $file)
	{
		$request = $this->browser->put(
			$content->upload_url,
			$headers, 
			file_get_contents($file)
		);
		
		return $this->response($request);
	}
	
	private function response($request)
	{
		return json_decode($request->getContent());
	}
}
