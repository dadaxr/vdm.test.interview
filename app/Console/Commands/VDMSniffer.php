<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Commands;
use Bus;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class VDMSniffer extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'vdm:sniffer';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sniff and parse the last X VDM posts';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $posts_count = $this->option('posts-count');
        $base_url = $this->option('base-url');

        $this->info('You\'re going to sniff vdm last '.$posts_count.' posts from '.$base_url);

        if (!$this->confirm('Do you wish to continue? [yes|no]'))
        {
            $this->info('Ok. See you');
            return;
        }

        /*@TODO on pourrait améliorer le feedback ici en précisant le nb de lignes correctement ajoutés,
         * il faudrait utiliser un enventuel event de success
         * */

        Bus::dispatch(
            new \App\Commands\VDMSniffer($posts_count, $base_url)
        );

        $this->info('command executed !');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
            ['posts-count', null, InputOption::VALUE_REQUIRED, 'The number of posts to sniff (10 by default).', 10],
            ['base-url', null, InputOption::VALUE_OPTIONAL, 'The Vdm Base Url with trailing slash ("http://www.viedemerde.fr/" by default)', 'http://www.viedemerde.fr/' ],
			//['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
