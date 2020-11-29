<?php

namespace App\Enums;

class ChapterEnum
{
    const STATUS_NORMAL = 0;
    const STATUS_DISABLED = 1;

    const SUB_LOCK_NORMAL  = 0;
    const SUB_LOCK_BUYING = 1;

    public static $statuses = [
        self::STATUS_NORMAL   => '正常',
        self::STATUS_DISABLED => '禁用',
    ];

    public static $subLocks = [
        self::SUB_LOCK_NORMAL => '正常展示',
        self::SUB_LOCK_BUYING => '购买后展示',
    ];
}
