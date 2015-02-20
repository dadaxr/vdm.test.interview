<?php namespace App\Facades;
/**
 * Created by PhpStorm.
 * User: dadaxr
 * Date: 18/02/2015
 * Time: 00:29
 */

use Illuminate\Support\Facades\Facade;

class HtmlDom extends Facade {

    protected static function getFacadeAccessor() { return 'Yangqi\Htmldom\Htmldom'; }

}