<?php

namespace Clarion\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;

class ClarionController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    public function infoByKeyword($bot, $keyword)
    {
    	$bot->reply($keyword);
    }

    protected function getUser()
    {
    	return app()->make(JWTAuth::class)->user();
    }
}
