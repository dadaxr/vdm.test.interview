<?php

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	/*public function testBasicExample()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(200, $response->getStatusCode());
	}*/


	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testVDMPostIndex()
	{
		$response = $this->call('GET', '/api/vdm/');
		$this->assertEquals(200, $response->getStatusCode());
	}

}
