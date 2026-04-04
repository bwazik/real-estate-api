<?php

namespace App\Enums;

enum PropertyStatus: int
{
    case Available = 0;
    case Reserved = 1;
    case Sold = 2;
    case Rented = 3;
    case Unavailable = 4;

    /**
     * Get the label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Available => 'available',
            self::Reserved => 'reserved',
            self::Sold => 'sold',
            self::Rented => 'rented',
            self::Unavailable => 'unavailable',
        };
    }

    /**
     * Get the status from label.
     */
    public static function fromLabel(string $label): ?self
    {
        return match ($label) {
            'available' => self::Available,
            'reserved' => self::Reserved,
            'sold' => self::Sold,
            'rented' => self::Rented,
            'unavailable' => self::Unavailable,
            default => null,
        };
    }
}
