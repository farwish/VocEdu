<?php

namespace App\Enums;

class QuestionEnum
{
    const DIFFICULTY_EASY   = 0;
    const DIFFICULTY_MIDDLE = 1;
    const DIFFICULTY_HARD   = 2;

    const ANSWER_RIGHT = 0;
    const ANSWER_WRONG = 1;

    public static $difficulty = [
        self::DIFFICULTY_EASY   => '易',
        self::DIFFICULTY_MIDDLE => '中',
        self::DIFFICULTY_HARD   => '难',
    ];

    public static $rightAnswer = [
        self::ANSWER_RIGHT => '正确',
        self::ANSWER_WRONG => '错误',
    ];
}
