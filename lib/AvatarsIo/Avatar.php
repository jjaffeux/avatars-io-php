<?php

namespace AvatarsIo;

include('Exception.php');
include('Client.php');

class Avatar {

	const base_uri = 'http://avatars.io';

	protected $response;
	protected $file;
	protected $identifier;
	protected $client_id = FALSE;
	protected $access_token = FALSE;
	protected $client;

	function __construct($client_id, $access_token)
	{
		if ( ! $client_id OR ! $access_token) {
            throw new Undefined_credentials();
        }

		$this->client_id = $client_id;
		$this->access_token = $access_token;
		$this->client = new Client();
	}

	function upload($file, $identifier = '')
	{
		if ( ! file_exists($file) OR ! is_readable($file)) {
            throw new Cant_access_file();
        }

		$this->file = $file;
		$this->identifier = $identifier;

		$this->send_file();
		
		if(empty($this->response->data->upload_info)) {
			return $this->response->data->url;
		}
 
		$this->set_aws_acl();
		$this->get_file_path();
	}

	public function send_file()
	{
		$content = array(
			'data' => array(
				'filename' => $this->file,
				'md5' => md5_file($this->file),
				'size' => filesize($this->file),
				'path' => $this->identifier
			)
		);

		$this->response = $this->client->post(
			$content,
			array(
				'Content-Type: application/json; charset=utf-8',
				'x-client_id: ' . $this->client_id,
				'Authorization: OAuth ' . $this->access_token
			),
			'token'
		);
	}
	
	public function set_aws_acl()
	{
		$this->client->put(
			$this->response->data->upload_info,
			array(
				'Authorization: ' . $this->response->data->upload_info->signature,
				'Date: ' . $this->response->data->upload_info->date,
				'Content-Type: ' . $this->response->data->upload_info->content_type,
				'x-amz-acl: public-read'
			),
			$this->file
		);
	}
	
	public function get_file_path()
	{
		$response = $this->client->post(
			'',
			array(
				'x-client_id: ' . $this->client_id,
				'Authorization: OAuth ' . $this->access_token
			),
			'token/' . $this->response->data->id . '/complete'
		);

		return $response->data;
	}	
	
	function url($service = 'twitter', $key, $size = 'default')
	{
		return self::base_uri . '/' . $service . '/' . $key . '?size=' . $size;
	}

}