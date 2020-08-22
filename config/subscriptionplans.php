<?php

return [
    1 => [
        'id' => 1,
        'name' => 'default',
        'price' => 5.00, // US dollars
        'frequency' => 'monthly',
        'trial_period' => 7, // days
        'free_user_quota' => 1,
        'free_chat_app_quota' => 1,
        'price_per_additional_user' => 10.00,
        'price_per_additional_chat_app' => 2.00,
        'unlimited_chats' => true,
        'lack_of_agent_response_timeout' => 15, // minutes
        'stripe_price_id' => env('STRIPE_PRICE_ID_DEFAULT', ''),
        'stripe_price_id_user' => env('STRIPE_PRICE_ID_USER_DEFAULT', ''),
        'stripe_price_id_chat_app' => env('STRIPE_PRICE_ID_CHAT_APP_DEFAULT', '')
    ]
];