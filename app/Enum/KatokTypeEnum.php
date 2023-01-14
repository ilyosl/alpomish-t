<?php

namespace App\Enum;

enum KatokTypeEnum: string
{
    case CLik = 'Click';
    case Cash = 'Cash';
    case Payme = 'Payme';
    case Humo = 'Humo';
    case Terminal = 'Terminal';
}
