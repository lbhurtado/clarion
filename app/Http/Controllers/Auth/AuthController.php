<?php

namespace Clarion\Http\Controllers\Auth;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Clarion\Domain\Models\User;
use Clarion\Http\Controllers\Controller;
use Clarion\Domain\Contracts\UserRepository;
use Tymon\JWTAuth\Exceptions\{JWTException};
use Clarion\Http\Requests\LoginRequest;

class AuthController extends Controller
{
	protected $auth;

	protected $users;

    public function __construct(JWTAuth $auth, UserRepository $users)
    {
    	$this->auth = $auth;
    	$this->users = $users;
    }


    public function login(Request $request)
    {
    	try {
    		// check Clarion\Infrastructure\Auth\Illuminate
    		$credentials = $request->only(['mobile']);

    		if (!$token = $this->auth->attempt($credentials))
    			return response()->json([
    				'errors' => [
    					'root' => 'Could not sign you in with thouse details.'
    				]
    			], 401);
    	} catch (JWTException $e) {
    		return response()->json([
    				'errors' => [
    					'root' => 'Failed.'
    				]
    			], 401);
    	}

    	return response()->json([
    		'data' => $request->user(),
    		'meta' => [
    			'token' => $token
    		]
    	], 200);
    }

    public function register(Request $request)
    {
    	$user = $this->users->create($request->only(['mobile', 'handle']));

    	$token = $this->auth->fromUser($user);

    	return response()->json([
    		'data' => $user,
    		'meta' => [
    			'token' => $token
    		]
    	], 200);
    }

   public function logout()
    {
        $this->auth->invalidate($this->auth->getToken());

        return response(null, 200);
    }

    public function user(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }
}
