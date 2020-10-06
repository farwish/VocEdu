<?php

namespace App\Enums;

class ChapterEnum
{
    const STATUS_SHOWN  = 0;
    const STATUS_HIDDEN = 1;

    public static $statuses = [
        self::STATUS_SHOWN  => '正常',
        self::STATUS_HIDDEN => '不展示',
    ];
}
