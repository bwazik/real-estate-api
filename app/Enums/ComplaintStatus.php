<?php

namespace App\Enums;

enum ComplaintStatus: int
{
    case Pending = 0;
    case Reviewed = 1;
    case Resolved = 2;

    /**
     * Get the label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'pending',
            self::Reviewed => 'reviewed',
            self::Resolved => 'resolved',
        };
    }
}
