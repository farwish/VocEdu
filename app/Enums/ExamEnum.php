<?php

namespace App\Enums;

class ExamEnum
{
    const STATUS_IS_NOT_OPEN = 0;
    const STATUS_IS_OPENING  = 1;
    const STATUS_IS_CLOSED   = 2;

    public static $status = [
        self::STATUS_IS_NOT_OPEN => '未开始',
        self::STATUS_IS_OPENING  => '进行中',
        self::STATUS_IS_CLOSED   => '已结束',
    ];
}

