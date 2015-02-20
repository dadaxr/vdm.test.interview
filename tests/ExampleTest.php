<?php

class ExampleTest extends TestCase {

	/**
	 * @var \Mockery\Mock
	 */
	protected $_vdm_db;
	/**
	 * @var \Mockery\Mock
	 */
	protected $_vdm_posts;

	protected $_post_stub;


	public function setUp()
	{
		parent::setUp();

		/*
		 * Tentative d'abstraction des appels au driver mongodb ... mais la librairie n'a pas été pensée dans une logique de testabilité.
		 * voir : http://stackoverflow.com/questions/8630595/test-mongodb-interactions-in-a-php-application-mocking
		$mongo_db_mock = \Mockery::mock('MongoDB');
		$this->_vdm_db = $this->mock('VDMMongoDB', $mongo_db_mock);
		$this->_vdm_posts = \Mockery::mock('MongoCollection');

		$this->_vdm_db->shouldReceive('posts')->once()->andReturn($this->_vdm_posts);
		*/
	}

	/**
	 * @param $id
	 */
	/*protected function initPostStub($id){
		$this->_post_stub = array(
			"content" => "Aujourd'hui, ne voulant prendre aucun risque, je montre mon billet au contrôleur sur le quai. Il m'a indiqué le mauvais train. VDM",
        	"datetime" => "2015-02-20 00:00",
        	"author" => "Seuneuceufeu"
		);

		$this->_post_stub['_id'] = new MongoId($id);
	}*/

	/**
	 * @param $class
	 * @param \Mockery\MockInterface $mock_instance
	 * @return \Mockery\MockInterface
	 */
	public function mock($class, \Mockery\MockInterface $mock_instance = null)
	{
		/*if no instance : try to mock from the class */
		if(empty($mock_instance)){
			$mock_instance = \Mockery::mock($class);
		}

		$this->app->instance($class, $mock_instance);

		return $mock_instance;
	}


	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testShowWithValidPostId()
	{
		/* Code conservé Pour info. Il s'agissait d'une tentative d'abstraction des appels à la bdd.
		$post_id = '54e6792e33b55c78130001b0';
		$this->initPostStub($post_id);
		$this->_vdm_posts->shouldReceive('findOne')->andReturn($this->_post_stub);
		*/

		$response = $this->call('GET', '/api/vdm/show/54e6792e33b55c78130001b0');
		$this->assertJson($response->getContent(),'check response is valid JSON');
        $response_decoded = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('post',$response_decoded);
        if(!empty($response_decoded['post'])){
            $this->assertArrayHasKey('_id',$response_decoded['post']);
            $this->assertArrayHasKey('content',$response_decoded['post']);
            $this->assertArrayHasKey('datetime',$response_decoded['post']);
            $this->assertArrayHasKey('author',$response_decoded['post']);
        }
	}

    public function testShowWithInvalidPostId()
    {
        $response = $this->call('GET', '/api/vdm/show/id_invalid_1234');
        $this->assertJson($response->getContent(),'check response is valid JSON');
        $response_decoded = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error',$response_decoded);
    }

}
