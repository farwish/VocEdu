<?php

namespace App\Enums;

class AppMenuEnum
{
    const NEXT_FORMAT_LIST = 'list';
    const NEXT_FORMAT_CARD = 'card';

    const STATUS_NORMAL   = 0;
    const STATUS_DISABLED = 1;

    public static $nextFormats = [
        self::NEXT_FORMAT_LIST => '列表',
        self::NEXT_FORMAT_CARD => '卡片',
    ];

    public static $statuses = [
        self::STATUS_NORMAL   => '展示',
        self::STATUS_DISABLED => '不展示',
    ];
}
