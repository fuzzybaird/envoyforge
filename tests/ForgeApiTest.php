<?php
namespace Fuzzybaird\Envoyforge;

use GuzzleHttp\Client;
use phpmock\MockBuilder;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Fuzzybaird\Envoyforge\ForgeApi as Forge;
use Symfony\Component\Stopwatch\Stopwatch;

function sleep()
{
	 return 'pooop';
}
class ForgeApiTest extends \PHPUnit\Framework\TestCase
{
	public $key = 'alksdjkjsdlkj';

	/** 
	 * @test 
	 * @group time-sensitive
	*/
	function create_a_site()
	{
		$my_var = "{\r\n \"site\":{\r\n \"id\":2,\r\n \"name\":\"site.com\",\r\n \"directory\":\"\/test\",\r\n \"wildcards\":false,\r\n \"status\":\"done\",\r\n \"repository\":null,\r\n \"repository_provider\":null,\r\n \"repository_branch\":null,\r\n \"repository_status\":null,\r\n \"quick_deploy\":false,\r\n \"project_type\":\"php\",\r\n \"app\":null,\r\n \"app_status\":null,\r\n \"hipchat_room\":null,\r\n \"slack_channel\":null,\r\n \"created_at\":\"2016-12-16 16:38:08\"\r\n   }\r\n}";
		$mock = new MockHandler([
			new Response(200, ['X-Foo' => 'Bar'], $my_var),
			new Response(200, ['X-Foo' => 'Bar'], $my_var),
			new Response(200, ['X-Foo' => 'Bar'], $my_var)
		]);
		$handler = HandlerStack::create($mock);
		$client = new Client(['base_uri' => 'https://forge.laravel.com/api/v1/', 'handler' => $handler]);
		$forge =  new Forge($this->key, $client);
		$response = $forge->create_site('189613', 'new2-feature.dev.zrum.io', 'php', '/');

		$this->assertEquals('done',$response->site->status);
	}
}