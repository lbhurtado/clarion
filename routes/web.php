<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Clarion\Domain\Models\User;
use Clarion\Domain\Contracts\UserRepository;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');

Route::get('/test', function (Clarion\Domain\Contracts\UserRepository $users) {
   \DB::listen(function ($query) {
 		var_dump($query->sql);
	});
   // factory(Clarion\Domain\Models\User::class)->create(['mobile' => '09173011987', 'handle' => 'Retsel']);

  $user = $users->findWhere(['handle' => 'Retsel'])->first();

 //  $user->messengers()->create([
 //    'driver'  => 'Facebook',
 //    'chat_id' => 'lester.hurtado'
	// ]);
  $users->pushCriteria(new Clarion\Domain\Criteria\WithMessengerCriteria());

	dd($users->all());

});

Route::get('/authy', function() {

	// $authyApp = app('rinvex.authy.app');
	// $appStats = $authyApp->stats(); // Get app stats
	// $appDetails = $authyApp->details();

	$authyUser = app('rinvex.authy.user');

	$user = $authyUser->register('lester@3rd.tel', '9173011987', '63');

	dd($user);

	// $userStatus = $authyUser->status($user->get('user')['id']); // Get user status

	$authyToken = app('rinvex.authy.token');

	// $smsTokenSent = $authyToken->send($user->get('user')['id'], 'sms');
	// $smsTokenSent = $authyToken->send(7952368, 'sms');

	// dd($smsTokenSent);
	// $tokenVerified = $authyToken->verify(210492, $user->get('user')['id']); // Verify token

	$tokenVerified = $authyToken->verify(359057, 7952368);
	
	dd($tokenVerified);
});

Route::get('/create_user', function(UserRepository $users) {

	User::create(['mobile' => '09173011987']);
});

Route::get('/verify/{otp}', function(UserRepository $users, $otp) {
	
	$user = $users->getByCriteria(\Clarion\Domain\Criteria\HasTheFollowing::mobile('09173011987'))->first();

	\Clarion\Domain\Jobs\VerifyOTP::dispatch($user, $otp);
});