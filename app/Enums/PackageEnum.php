<?php

namespace App\Enums;

class PackageEnum
{
    const EXPIRE_MODE_FIXED   = 0;
    const EXPIRE_MODE_DYNAMIC = 1;

    const LIST_STATUS_NORMAL   = 0;
    const LIST_STATUS_DISABLED = 1;

    public static $expireModes = [
        self::EXPIRE_MODE_FIXED   => '固定时间期限',
        self::EXPIRE_MODE_DYNAMIC => '跟随科目考试时间',
    ];

    public static $listStatuses = [
        self::LIST_STATUS_NORMAL => '已上架',
        self::LIST_STATUS_DISABLED => '未上架',
    ];
}
