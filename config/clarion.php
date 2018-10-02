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
			'chat_id' => env('USER_HANDLE', 'user'),
		],
		'user0' => [
			'mobile' => env('USER_MOBILE', '09173011987'),
			'handle' => env('USER_HANDLE', 'Lester'),
			'driver'  => env('USER_DRIVER', 'Telegram'),
			'chat_id' => env('USER_HANDLE', 'user0'),
		],
		'user1' => [
			'mobile' => env('USER_MOBILE', '09189362340'),
			'handle' => env('USER_HANDLE', 'Retsel'),
			'driver'  => env('USER_DRIVER', 'Telegram'),
			'chat_id' => env('USER_HANDLE', 'user1'),
		],
		'user2' => [
			'mobile' => env('USER_MOBILE', '09175180722'),
			'handle' => env('USER_HANDLE', 'Apple'),
			'driver'  => env('USER_DRIVER', 'Telegram'),
			'chat_id' => env('USER_HANDLE', 'user2'),
		],
		'user3' => [
			'mobile' => env('USER_MOBILE', '09177210752'),
			'handle' => env('USER_HANDLE', 'Francesca'),
			'driver'  => env('USER_DRIVER', 'Facebook'),
			'chat_id' => env('USER_HANDLE', 'user3'),
		],
		'user4' => [
			'mobile' => env('USER_MOBILE', '09399236237'),
			'handle' => env('USER_HANDLE', 'Sofia'),
			'driver'  => env('USER_DRIVER', 'Facebook'),
			'chat_id' => env('USER_HANDLE', 'user4'),
		],
	],
];