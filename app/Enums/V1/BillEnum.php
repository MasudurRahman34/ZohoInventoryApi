<?php


namespace App\Enums\V1;

enum BillEnum: string
{
    case draft = 'draft';
    case sent = 'sent';
    case partailly_paid = 'partailly_paid';
    case overdue = 'overdue';
    case paid = 'paid';
    case confirmed = 'confirmed';
    case cancelled = 'cancelled';


    public function draft(): bool
    {
        return $this === self::draft;
    }

    public function sent(): bool
    {
        return $this === self::sent;
    }
    public function PartiallyPaid(): bool
    {
        return $this === self::partailly_paid;
    }
    public function overdue(): bool
    {
        return $this === self::overdue;
    }
    public function paid(): bool
    {
        return $this === self::paid;
    }

    public function confirmed(): bool
    {
        return $this === self::confirmed;
    }
    public function cancelled(): bool
    {
        return $this === self::cancelled;
    }
}
