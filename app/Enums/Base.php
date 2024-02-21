<?php

namespace App\Enums;
use Illuminate\Validation\Rules\Enum;

final class Base extends Enum
{
    const ADMIN = '1';
    const STUDENT = '0';
    const PAGE = 10;
}
