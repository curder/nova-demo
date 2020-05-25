<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class RolesEnum extends Enum implements LocalizedEnum
{
    public const SUPER_ADMIN_MANAGER = 'super';

    public const EDITOR_MANAGER = 'editor';
}
