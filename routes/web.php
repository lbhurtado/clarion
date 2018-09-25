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

	$user = $authyUser->register('lester@3rd.tel', '9173011876', '63');
	
	dd($user);
});