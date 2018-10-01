<?php

return [
	'default' => [
		'admin' => [
			'mobile' => env('ADMIN_MOBILE', '09173011987'),
			'handle' => env('ADMIN_HANDLE', 'admin')
		],
		'pin' => 1234
	],
	'test' => [
		'user' => [
			'mobile'  => env('USER_MOBILE', '09189362340'),
			'handle'  => env('USER_HANDLE', 'user'),
			'driver'  => env('USER_DRIVER', 'Telegram'),
			'chat_id' => env('USER_HANDLE', '123456'),
		],
		'user1' => [
			'mobile' => env('USER_MOBILE', '09173011987'),
			'handle' => env('USER_HANDLE', 'Lester'),
		],
		'user2' => [
			'mobile' => env('USER_MOBILE', '09189362340'),
			'handle' => env('USER_HANDLE', 'Retsel'),
		],
	],
];