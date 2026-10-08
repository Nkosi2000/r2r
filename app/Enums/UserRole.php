<?php

namespace App\Enums;

/**
 * Staff access to the CMS. Editors manage website content; admins can also manage staff accounts and site settings.
 */
enum UserRole: string
{
    case Admin = 'admin';
    case Editor = 'editor';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Editor => 'Editor',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Admin => 'Manages all content, site settings and staff accounts.',
            self::Editor => 'Manages website content.',
        };
    }
}
