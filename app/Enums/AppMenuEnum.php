<?php

namespace App\Enums;

class AppMenuEnum
{
    const NEXT_FORMAT_LIST = 'list';
    const NEXT_FORMAT_CARD = 'card';

    const STATUS_NORMAL   = 0;
    const STATUS_DISABLED = 1;

    const SUB_LOCK_NORMAL = 0;
    const SUB_LOCK_BUYING = 1;

    public static $nextFormats = [
        self::NEXT_FORMAT_LIST => '列表',
        self::NEXT_FORMAT_CARD => '卡片',
    ];

    public static $statuses = [
        self::STATUS_NORMAL   => '展示',
        self::STATUS_DISABLED => '不展示',
    ];

    public static $subLocks = [
        self::SUB_LOCK_NORMAL => '开放',
        self::SUB_LOCK_BUYING => '购买后开放',
    ];
}
