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
	public $key = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjM5NWViMTkwOWM3MGYyODkwZTQyYWU2MzUzYWJhZDNhODhhZWRhYzkyNmFiNmQ4ZDEyZTgzNzY1OTZiYjdkYTk3NjUxODQ3YjIzMTUzZGMwIn0.eyJhdWQiOiIxIiwianRpIjoiMzk1ZWIxOTA5YzcwZjI4OTBlNDJhZTYzNTNhYmFkM2E4OGFlZGFjOTI2YWI2ZDhkMTJlODM3NjU5NmJiN2RhOTc2NTE4NDdiMjMxNTNkYzAiLCJpYXQiOjE1MjQ2MTA3MDgsIm5iZiI6MTUyNDYxMDcwOCwiZXhwIjoxNTU2MTQ2NzA4LCJzdWIiOiIxMTYwMSIsInNjb3BlcyI6W119.qMTOS6CbUuURbLjMWB_P4JBomMjb2eQO7LR0jozSBfuKpZxicI7z3dc87LCivthSod-faOxVxE2byuvu8lT7MxZx_NlfRy_W-L9XXNfjxOZKpfwFBdcW2Cbd6w3gbUvY258yY9r5NmNqUFFCAukDFdfiUSAXb3WHr_7l2nXjjvLwKomlyMBoJdPvGx10h4r6l1YC5xah93oyYGf75bGLpD65t1-TB0hTMvvsscGoBluZxotYSX-WnQXjRWpnKG7HLuop4kFb7mdWia1PPCEleeAeKBbTepiIznTFNaWUM6n-1O2-nitqF6FJER5PcYqbWG-Q1TvfSMdzmxDSi8kCiWYobpdKTlnYfUkHdHWyNm5JFJRcZI5Sh2FjsmbY7E27-vF_PLeIRapYG4VFPIOuE1dzEhJVlRZLQkwsmCnFad4kJUEXm48_Dc0PiH82FYYbbv2abYBUrTsIsLWqaQiT_x9YULGAi96GSxy0OL0q_C5CYT9A7CBKb005-_071nYWNykNdac24drMKm4OVdmKQ1_1soiItJRqxfickMPexg0udEyqshrtyJG6BwwU71m8IG0brnmnLZgOm4sVrSuT51MvM18oglCrfjZJ5uj6tqakRBsiVQU8sq2pioDkQx6N1snwzJIPDslUyntD30NF311flvrB8norXpmHww6Jpew';

	// function setUp()
	// {


	// }

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