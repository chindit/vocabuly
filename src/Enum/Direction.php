<?php

namespace App\Enum;

enum Direction: int {
    case TranslateInbound = 0;
    case TranslateOutbound = 1;
    case TranslateBoth = 2;
}