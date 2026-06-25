<?php

return [
    'credits' => [
        'new_user_credits' => (int) env('PRACTICE_ROOM_NEW_USER_CREDITS', 20),
        'practice_cost' => (int) env('PRACTICE_ROOM_PRACTICE_CREDIT_COST', 1),
        'exam_cost' => (int) env('PRACTICE_ROOM_EXAM_CREDIT_COST', 2),
    ],

    'default_course_credits' => (int) env('PRACTICE_ROOM_DEFAULT_COURSE_CREDITS', 20),

    'subscription' => [
        'included_credit_amount' => (float) env('PRACTICE_ROOM_SUBSCRIPTION_INCLUDED_CREDIT_AMOUNT', 4),
        'included_minutes' => (int) env('PRACTICE_ROOM_SUBSCRIPTION_INCLUDED_MINUTES', 15),
        'credit_value_per_minute' => (float) env('PRACTICE_ROOM_CREDIT_VALUE_PER_MINUTE', 4 / 15),
    ],
];
