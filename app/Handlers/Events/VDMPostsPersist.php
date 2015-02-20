<?php namespace App\Handlers\Events;

use App;
use Log;

use App\Events\VDMPostsSniffed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class VDMPostsPersist {

    /**
     * @var \MongoDB
     */
    protected  $_vdm_db;
	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->_vdm_db = App::make('VDMMongoDB');
	}

	/**
	 * Handle the event.
	 *
	 * @param  VDMPostsSniffed  $event
	 * @return void
	 */
	public function handle(VDMPostsSniffed $event)
	{
        /**
         * @var \MongoCollection $posts_collection
         */
        $posts_collection = $this->_vdm_db->posts;

        /* erase posts_collection before inserting */
        //$posts_collection->remove(array());

        foreach($event->list_posts as $vdm_post){
            try {
                $posts_collection->insert($vdm_post);
            } catch(\MongoCursorException $e) {
                Log::warning('Error while inserting document in vdm.posts : '.$e->getMessage());
            }
        }
	}

}
