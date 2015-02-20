<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;

class VDMPostsSniffed extends Event {

	use SerializesModels;

    public $list_posts;
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($list_vdm_posts)
	{
		$this->list_posts = $list_vdm_posts;
	}

}
