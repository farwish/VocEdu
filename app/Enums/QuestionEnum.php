<?php

namespace App\Enums;

class QuestionEnum
{
    const PATTERN_RADIO_CHOICE = 1;
    const PATTERN_MULTI_CHOICE = 2;
    const PATTERN_JUDGE_CHOICE = 3;
    const PATTERN_GAP_FILLING  = 4;
    const PATTERN_SHORT_ANSWER = 5;

    const DIFFICULTY_EASY   = 0;
    const DIFFICULTY_MIDDLE = 1;
    const DIFFICULTY_HARD   = 2;

    const ANSWER_RIGHT = 1;
    const ANSWER_WRONG = 0;

    public static $pattern = [
        self::PATTERN_RADIO_CHOICE => '单选题',
        self::PATTERN_MULTI_CHOICE => '多选题',
        self::PATTERN_JUDGE_CHOICE => '判断题',
        self::PATTERN_GAP_FILLING  => '填空题',
        self::PATTERN_SHORT_ANSWER => '问答题',
    ];

    public static $difficulty = [
        self::DIFFICULTY_EASY   => '低',
        self::DIFFICULTY_MIDDLE => '中',
        self::DIFFICULTY_HARD   => '高',
    ];

    public static $rightAnswer = [
        self::ANSWER_RIGHT => '正确',
        self::ANSWER_WRONG => '错误',
    ];
}
