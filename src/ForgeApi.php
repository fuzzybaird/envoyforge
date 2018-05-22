<?php
namespace Fuzzybaird\Envoyforge;


/**
* All of the rest API calls made out to forge to provision and lets incript
*/
class ForgeApi
{
	public $client;
	public $options;

	function __construct($key, $client) {
		// Create a client with a base URI
		$this->client = $client;
		$this->options = ['headers' => [
			'Authorization' => 'Bearer '.$key, 
			"Accept" => "application/json", 
			"Content-Type" => "application/json"]
		];
	}

	function list_servers()
	{
		$response = (string) $this->client
			->request('GET', 'servers', $this->options)
			->getBody();
		return json_decode($response);
	}

	function create_site($server_id, $domain, $project_type, $directory)
	{
		$submit = compact("domain", "project_type", "directory");
		$this->options['body'] = json_encode($submit);
		$response = (string) $this->client
			->request('POST', "servers/{$server_id}/sites", $this->options)
			->getBody();
		$create_response = json_decode($response);
		$status = 'installing';
		while ($status === 'installing') {
			sleep(4);
			$result = $this->show_site('189613', $create_response->site->id);
			$status = $result->site->status;
		}
		return $result;
	}

	function lets_encrypt($server_id, $site_id, $domain)
	{
		$this->options['body'] = json_encode(["domains"=>[$domain]]);
		$response = (string) $this->client
			->request('POST', "servers/{$server_id}/sites/{$site_id}/certificates/letsencrypt", $this->options)
			->getBody();
		$create_response = json_decode($response);
		$status = 'installing';
		while ($status === 'installing') {
			sleep(4);
			$result = $this->show_cert($server_id, $site_id, $create_response->certificate->id);
			$status = $result->certificate->status;
		}
		return $result;
	}

	function show_cert($server_id, $site_id, $cert_id)
	{
		$response = (string) $this->client
			->request('GET', "servers/{$server_id}/sites/{$site_id}/certificates/{$cert_id}", $this->options)
			->getBody();
		return json_decode($response);
	}

	function delete_site($server_id, $site_id)
	{
		$response = (string) $this->client
			->request('DELETE', "servers/{$server_id}/sites/{$site_id}", $this->options)
			->getBody();
		return json_decode($response);
	}

	function show_site($server_id, $site_id)
	{
		$response = (string) $this->client
			->request('GET', "servers/{$server_id}/sites/{$site_id}", $this->options)
			->getBody();
		return json_decode($response);
	}

	function debugout($value, $autodump = false)
	{
		if ($autodump || (empty($value) && $value !== 0 && $value !== "0") || $value === true) {
			var_dump($value); 
		} else {
			print_r($value); 
		}
		die();
	}
}