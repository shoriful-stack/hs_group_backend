<?php

namespace App\Enums;

enum AboutUsType : int
{
    case PERSPECTIVE = 1;
    case OUR_VALUE = 2;
    case CONTINUES_IMPROVEMENT = 3;

    public function label(): string
    {
        return match ($this) {
            self::PERSPECTIVE => 'Perspective',
            self::OUR_VALUE => 'Our Values',
            self::CONTINUES_IMPROVEMENT => 'Continuous Improvement',
        };
    }

    public static function options(): array
    {
        return [
            self::PERSPECTIVE->value => self::PERSPECTIVE->label(),
            self::OUR_VALUE->value => self::OUR_VALUE->label(),
            self::CONTINUES_IMPROVEMENT->value => self::CONTINUES_IMPROVEMENT->label(),
        ];
    }
}
