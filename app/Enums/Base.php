<?php

namespace App\Enums;
use Illuminate\Validation\Rules\Enum;

final class Base extends Enum
{
    const Admin = '1';
    const Student = '0';
    const Page = 10;
}
