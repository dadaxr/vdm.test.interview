<?php namespace App\Commands;

use App\Commands\Command;
use App\Events\VDMPostsSniffed;
use HtmlDom;
use Illuminate\Contracts\Bus\SelfHandling;

class VDMSniffer extends Command implements SelfHandling {

    protected $_base_url;
    protected $_posts_count;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($posts_count = 10, $base_url = 'http://www.viedemerde.fr')
	{
        $this->_posts_count = $posts_count;
        $this->_base_url = $base_url;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        $list_vdm_posts = array();

        $current_page = 0;
        $keep_computing = true;
        while($keep_computing){
            HtmlDom::load_file($this->_base_url.'?page='.$current_page++);
            $vdm_page_posts = HtmlDom::find('div[class="post article"]');

            if(empty($vdm_page_posts)){
                break;
            }

            $post_data = array(
                "content" => '',
                "datetime" => '0000-00-00 00:00:00',
                "author" => null,
            );

            $posts_counter = count($list_vdm_posts);
            $w_dt = new \DateTime();
            foreach($vdm_page_posts as $vdm_post){
                if($posts_counter >= $this->_posts_count){
                    $keep_computing = false;
                    break;
                }

                $post_data['content'] = $vdm_post->find('p',0)->plaintext;

                $raw_info = $vdm_post->find('.date p',1)->plaintext;
                $infos_parts = explode(' ',$raw_info,10);

                if(isset($infos_parts[1]) && $infos_parts[2]){
                    //format date de vdm : jj/mm/aaaa hh:mm
                    $w_dt->createFromFormat('d/m/Y H:i', $infos_parts[1].' '.$infos_parts[2]);
                    //format pour le test : aaaa-mm-jj hh:mm
                    $post_data['datetime'] = $w_dt->format('Y-m-d H:i');
                }


                if(isset($infos_parts[8])){
                    $post_data['author'] = $infos_parts[8];
                }


                $list_vdm_posts[] = $post_data;
                $posts_counter++;
            }
        }

        event(new VDMPostsSniffed($list_vdm_posts));
	}

}
