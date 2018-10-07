<?php

return [
	'default' => [
		'admin' => [
			'mobile'  => env('ADMIN_MOBILE',  '09173011987'),
			'handle'  => env('ADMIN_HANDLE',  'admin'),
			'driver'  => env('ADMIN_DRIVER',  'Telegram'),
			'chat_id' => env('ADMIN_CHAT_ID', '537537'),
		],
		'pin' => 1234
	],
	'types' => [
		'staff' => 'Clarion\Domain\Models\Staff',
		'admin' => 'Clarion\Domain\Models\Admin',
		'worker' => 'Clarion\Domain\Models\Worker',
		'operator' => 'Clarion\Domain\Models\Operator',
		'subscriber' => 'Clarion\Domain\Models\Subscriber',
	],
	'test' => [
		'user' => [
			'mobile'  => env('USER_MOBILE',  '09189362340'),
			'handle'  => env('USER_HANDLE',  'user'),
			'driver'  => env('USER_DRIVER',  'Telegram'),
			'chat_id' => env('USER_CHAT_ID', '072294'),
		],
		'user0' => [
			'mobile'  => env('USER0_MOBILE',  '09173011987'),
			'handle'  => env('USER0_HANDLE',  'Lester'),
			'driver'  => env('USER0_DRIVER',  'Facebook'),
			'chat_id' => env('USER0_CHAT_ID', '000000'),
		],
		'user1' => [
			'mobile'  => env('USER1_MOBILE',  '09189362340'),
			'handle'  => env('USER1_HANDLE',  'Retsel'),
			'driver'  => env('USER1_DRIVER',  'Telegram'),
			'chat_id' => env('USER1_CHAT_ID', '111111'),
		],
		'user2' => [
			'mobile'  => env('USER2_MOBILE',  '09175180722'),
			'handle'  => env('USER2_HANDLE',  'Apple'),
			'driver'  => env('USER2_DRIVER',  'Telegram'),
			'chat_id' => env('USER2_CHAT_ID', '222222'),
		],
		'user3' => [
			'mobile'  => env('USER3_MOBILE',  '09177210752'),
			'handle'  => env('USER3_HANDLE',  'Francesca'),
			'driver'  => env('USER3_DRIVER',  'Facebook'),
			'chat_id' => env('USER3_CHAT_ID', '333333'),
		],
		'user4' => [
			'mobile'  => env('USER4_MOBILE',  '09399236237'),
			'handle'  => env('USER4_HANDLE',  'Sofia'),
			'driver'  => env('USER4_DRIVER',  'Facebook'),
			'chat_id' => env('USER4_CHAT_ID', '444444'),
		],
	],
	'seed' => [
		'users' => [
			[
				'mobile' => '09173011987',
				'handle' => 'admin',
				'type' => 'Clarion\Domain\Models\Admin'
			],
		],
		'flashes' => [
			[
				'code' => '537537', 
				'type' => 'admin',
				'handle' => null,
			],
			[
				'code' => '111111', 
				'type' => 'staff',
				'handle' => 'admin',
			],
			[
				'code' => '222222', 
				'type' => 'operator',
				'handle' => 'admin',
			],
		],
		'permissions' => [
			[
				'name' => 'check in others',
			],
			[
				'name' => 'broadcast',
			],
		],
		'roles' => [
			[
				'name' => 'admin',
				'permissions' => [
					'check in others',
					'broadcast',
				],
			],
			[
				'name' => 'staff',
				'permissions' => [
					'check in others',
					'broadcast',
				],
			],
			[
				'name' => 'operator',
				'permissions' => [
					'check in others',
				],
			],
			[
				'name' => 'worker',
				'permissions' => [
					'check in others',
				],
			],
			[
				'name' => 'subscriber',
				// 'permissions' => [
				// ],
			],
		],
	],
];