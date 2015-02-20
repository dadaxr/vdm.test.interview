<?php namespace App\Http\Controllers;

use App\Events\VDMPostsSniffed;
use App\Http\Controllers\Controller;
use Event;
use Bus;
use Illuminate\Http\Request;
use URL;
use App;


class VDMPostsController extends Controller {

    /**
     * @var \MongoDB
     */
    protected  $_vdm_db;
    /**
     * @var \MongoCollection
     */
    protected  $_vdm_posts;

    /**
     * @var Request
     */
    protected $_request;

    function __construct(Request $request)
    {
        $this->_request = $request;
        try{
            $this->_vdm_db = App::make('VDMMongoDB');
            $this->_vdm_posts = $this->_vdm_db->posts;
        }catch (\MongoException $e){
            return $e->getMessage();
        }

    }


    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        URL::setRootControllerNamespace('App\Http\Controllers');
        $show_url = action('VDMPostsController@getShow');
        $posts_url = action('VDMPostsController@getPosts');
        $filldb_url = action('VDMPostsController@getFilldb');

        echo 'try these actions : <br/>';
        echo 'show/id : '.$show_url.'<br/>';
        echo 'posts : '.$posts_url.'<br/>';
        echo 'filldb : '.$filldb_url.'<br/>';

    }


    public function getFilldb(){
        $result = null;
        Event::listen('App\Events\VDMPostsSniffed', function(VDMPostsSniffed $event) use(&$result)
        {
            $result = $event->list_posts;
        });

        Bus::dispatch(
            new \App\Commands\VDMSniffer(200)
        );

        dd($result);
    }


    public function getPosts($id = null){
        if(!empty($id)){
            return $this->getShow($id);
        }else{

            $from = $this->_request->get('from');
            $to = $this->_request->get('to');
            $author = $this->_request->get('author');

            $query = array();

            /*@TODO : sanitizer les inputs */

            if(!empty($from) || !empty($to)){
                $query['datetime'] = array();
                if(!empty($from)){
                    $query['datetime']['$gt'] = $from;
                }
                if(!empty($to)){
                    $query['datetime']['$lt'] = $to;
                }
            }

            if(!empty($author)){
                $query['author'] = $author;
            }

            /**
             * @var \MongoCursor $results_cursor;
             */
            $results_cursor = $this->_vdm_posts->find($query);
            $response_result = array(
                'posts' => array(),
                'count' => 0
            );
            $response_result['posts'] = iterator_to_array($results_cursor, false);
            $response_result['count'] = count($response_result['posts']);


            return $this->formatResponse($response_result);

        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getShow($id)
    {
        $query = array();

        $object_id = new \MongoId($id);
        $query['_id'] = $object_id;

        $result = $this->_vdm_posts->findOne($query);
        $response_result = array('post' => $result);
        return $this->formatResponse($response_result);
    }

    protected function formatResponse($result){
        $dd = $this->_request->get('dd',false);

        if($dd){
            dd($result);
        }else{
            $result = (object) $result;
            return response()->json($result);
        }
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	/*public function create()
	{
		//
	}*/

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	/*public function store()
	{
		//
	}*/

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	/*public function edit($id)
	{
		//
	}*/

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	/*public function update($id)
	{
		//
	}*/

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	/*public function destroy($id)
	{
		//
	}*/

}
