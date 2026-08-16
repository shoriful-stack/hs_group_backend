<?php

namespace App\Enums;

enum Status: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;


    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }

    public static function options(): array
    {
        return [
            self::ACTIVE->value => self::ACTIVE->label(),
            self::INACTIVE->value => self::INACTIVE->label(),
        ];
    }

    public function badge(): string
    {
        return match ($this) {
            self::ACTIVE => '<span class="badge bg-success">'. $this->label() .'</span>',
            self::INACTIVE => '<span class="badge bg-danger">'. $this->label() .'</span>',
        };
    }
}
