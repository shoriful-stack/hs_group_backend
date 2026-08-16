<?php

namespace App\Enums;

enum BlogStatus : int
{
    case DRAFT = 1;
    case PUBLISHED = 2;
    case ARCHIVED = 3;

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::ARCHIVED => 'Archived',
        };
    }

    public static function options(): array
    {
        return [
            self::DRAFT->value => self::DRAFT->label(),
            self::PUBLISHED->value => self::PUBLISHED->label(),
            self::ARCHIVED->value => self::ARCHIVED->label(),
        ];
    }

    public function badge(): string
    {
        return match ($this) {
            self::DRAFT => '<span class="badge bg-warning">'. $this->label() .'</span>',
            self::PUBLISHED => '<span class="badge bg-success">'. $this->label() .'</span>',
            self::ARCHIVED => '<span class="badge bg-danger">'. $this->label() .'</span>',
        };
    }
}
