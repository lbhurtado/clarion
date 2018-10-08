<?php

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Middleware\ApiAi;
use Clarion\Http\Middleware\{ManagesUsersMiddleware, AddTypingIndicator};
use BotMan\BotMan\Middleware\Dialogflow;
use Clarion\Domain\Conversations\{Registration, Login, Authentication, Onboarding};
use Clarion\Http\Controllers\BotManController;
use Clarion\Domain\Contracts\UserRepository;
use Tymon\JWTAuth\JWTAuth;

$botman = resolve('botman');


$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});

$botman->hears('test', function ($bot) {
    $bot->reply('Yes, it works!');
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');

// $botman->middleware->matching($usersMiddleware);

// $dialogflow = Dialogflow::create('b9490b2473084fc8b15a3940580f2acc')->listenForAction();

// $botman->middleware->received($dialogflow);

// $botman->fallback(function (BotMan $bot){
//     return $bot->reply($bot->getMessage()->getExtras('apiReply'));
// });

$usersMiddleware = new ManagesUsersMiddleware;
$botman->middleware->received($usersMiddleware);

$middleware = new AddTypingIndicator(); 
$botman->middleware->sending($middleware);

$botman->hears('/register', function (BotMan $bot) {
    $bot->startConversation(new Registration());
})->stopsConversation();

// $botman->group(['middleware' => $usersMiddleware], function (BotMan $bot) {

// });

$botman->hears('/login', function (BotMan $bot) {
	if ($bot->getMessage()->getExtras('token'))
    	return $bot->startConversation(new Login());
	
})->stopsConversation();


// $botman->hears('/authenticate', function (BotMan $bot) {
//     $bot->startConversation(new Authentication());
// })->stopsConversation();

// $botman->hears('/start|GET_STARTED', function (BotMan $bot) {
//     $bot->startConversation(new Onboarding());
// })->stopsConversation();