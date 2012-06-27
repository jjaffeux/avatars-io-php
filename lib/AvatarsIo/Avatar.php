<?php

namespace AvatarsIo;

include('Exception.php');
include('Client.php');

class Avatar {

	const base_uri = 'http://avatars.io';

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

		$response = $this->send_file($file, $identifier);

		if(empty($response->data->upload_info)) {
			return $response->data->url;
		}
 
		$this->set_aws_s3_acl($response->data->upload_info, $file);
		return $this->get_file_url($response->data->id);
	}

	function send_file($file, $identifier)
	{
		$content = array(
			'data' => array(
				'filename' => $file,
				'md5' => md5_file($file),
				'size' => filesize($file),
				'path' => $identifier
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
	
  function set_aws_s3_acl($upload_info, $file)
	{
		$this->client->put(
			$upload_info,
			array(
				'Authorization: ' . $upload_info->signature,
				'Date: ' . $upload_info->date,
				'Content-Type: ' . $upload_info->content_type,
				'x-amz-acl: public-read'
			),
			$file
		);
	}
	
	function get_file_url($image_id)
	{
		$response = $this->client->post(
			'',
			array(
				'x-client_id: ' . $this->client_id,
				'Authorization: OAuth ' . $this->access_token
			),
			'token/' . $image_id . '/complete'
		);

		return $response->data;
	}	
	
	function url($service = 'twitter', $key, $size = 'default')
	{
		return self::base_uri . '/' . $service . '/' . $key . '?size=' . $size;
	}

}