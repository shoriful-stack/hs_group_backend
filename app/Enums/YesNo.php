<?php

namespace App\Enums;

enum YesNo: int
{
    case YES = 1;
    case NO = 0;


    public function label(): string
    {
        return match ($this) {
            self::YES => 'Yes',
            self::NO => 'No',
        };
    }

    public static function options(): array
    {
        return [
            self::YES->value => self::YES->label(),
            self::NO->value => self::NO->label(),
        ];
    }

    public function badge(): string
    {
        return match ($this) {
            self::YES => '<span class="badge bg-success">'. $this->label() .'</span>',
            self::NO => '<span class="badge bg-danger">'. $this->label() .'</span>',
        };
    }
}
