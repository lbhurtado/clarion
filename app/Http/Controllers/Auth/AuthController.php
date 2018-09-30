<?php

namespace Clarion\Http\Controllers\Auth;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Clarion\Domain\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Clarion\Http\Controllers\Controller;
use Clarion\Http\Resources\UserResource;
use Clarion\Domain\Contracts\UserRepository;
use Tymon\JWTAuth\Exceptions\{JWTException};
use Clarion\Http\Requests\LoginRequest;

class AuthController extends Controller
{
	protected $auth;

	protected $users;

	protected $request;
	/**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $auth, UserRepository $users, Request $request)
    {
    	$this->auth = $auth;
    	$this->users = $users;
    	$this->request = $request;

        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Register a user with mobile
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
    	$user = $this->users->create($this->request->only(['mobile', 'handle']));

    	$token = $this->auth->fromUser($user);

    	return $this->respondWithToken($token, $user);
    }

    /**
     * Get a JWT token via given credentials.
     * Check Clarion\Infrastructure\Auth\Illuminate.
     *
     * @return \Illuminate\Http\JsonResponse
     */
   	public function login()
    {
    	try {
    		$credentials = $this->request->only(['mobile']);

    		if (!$token = $this->guard()->attempt($credentials))
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


		return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response(null, 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function user()
    {
        return response()->json([
            'data' => $this->request->user(),
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user = null)
    {
    	$user = $user ?? $this->request->user();

    	return (new UserResource($user))->additional(
    		[
    			'meta' => [
			    	'token' => $token,
    				'token_type' => 'bearer',
    				'expires_in' => $this->guard()->factory()->getTTL() * 60
    			],
    		]);
    }

    /**
     * Get the guard to be used during authentication.
     * 
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
    	return $this->auth;
    }
}
