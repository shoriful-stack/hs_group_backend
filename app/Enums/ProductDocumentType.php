<?php

namespace App\Enums;

enum ProductDocumentType : int
{
    case PNG = 1;
    case JPG = 2;
    case PDF = 3;
    case DOCX = 4;
    case GIF = 5;

    public function label(): string
    {
        return match ($this) {
            self::PNG => 'PNG',
            self::JPG => 'JPG',
            self::PDF => 'PDF',
            self::DOCX => 'DOCX',
            self::GIF => 'GIF',
        };
    }

    public static function options(): array
    {
        return [
            self::PNG->value => self::PNG->label(),
            self::JPG->value => self::JPG->label(),
            self::PDF->value => self::PDF->label(),
            self::DOCX->value => self::DOCX->label(),
            self::GIF->value => self::GIF->label(),
        ];
    }
}
