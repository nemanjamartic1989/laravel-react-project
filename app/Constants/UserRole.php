<?php

declare(strict_types=1);

namespace App\Constants;

final class UserRole extends BaseEnum
{
    public const SUPERADMIN = 'SUPERADMIN';
    public const ADMIN = 'ADMIN';
    public const CUSTOM = 'CUSTOM';
}
