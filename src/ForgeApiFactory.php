<?php
namespace Fuzzybaird\Envoyforge;

use GuzzleHttp\Client;
use Fuzzybaird\Envoyforge\ForgeApi;

class ForgeApiFactory
{
	public static function init($key) {
		$client = new Client(['base_uri' => 'https://forge.laravel.com/api/v1/']);
		return new ForgeApi($key, $client);
	}
}
