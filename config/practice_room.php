<?php

return [
    'credits' => [
        'new_user_credits' => (int) env('PRACTICE_ROOM_NEW_USER_CREDITS', 20),
        'practice_cost' => (int) env('PRACTICE_ROOM_PRACTICE_CREDIT_COST', 1),
        'exam_cost' => (int) env('PRACTICE_ROOM_EXAM_CREDIT_COST', 2),
    ],

    'default_course_credits' => (int) env('PRACTICE_ROOM_DEFAULT_COURSE_CREDITS', 20),
];
