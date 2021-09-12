<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 *
 */
final class ResponseCode extends Enum
{
    // 成功
    const Success = 1;

    //系統相關100000

    //身分相關200000
    const UnAuthenticatedError = 200000;

}
