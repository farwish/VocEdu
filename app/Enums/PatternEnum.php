<?php

namespace App\Enums;

class PatternEnum
{
    const TYPE_SUBJECTIVE = 0;
    const TYPE_OBJECTIVE  = 1;

    const OBJECTIVE_CLASSIFY_RADIO = 0;
    const OBJECTIVE_CLASSIFY_MULTI = 1;
    const OBJECTIVE_CLASSIFY_DRIFT = 2;
    const OBJECTIVE_CLASSIFY_JUDGE = 3;
    const OBJECTIVE_CLASSIFY_CONST = 4;

    // 题型分类
    public static $patternType = [
        self::TYPE_SUBJECTIVE => '主观题',
        self::TYPE_OBJECTIVE  => '客观题',
    ];

    // 客观题-选项分类
    public static $objectiveClassify = [
        self::OBJECTIVE_CLASSIFY_RADIO => '单选',
        self::OBJECTIVE_CLASSIFY_MULTI => '多选',
        self::OBJECTIVE_CLASSIFY_DRIFT => '不定向选',
        self::OBJECTIVE_CLASSIFY_JUDGE => '判断',
        self::OBJECTIVE_CLASSIFY_CONST => '定值填空题',
    ];
}
