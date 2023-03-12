<?php

namespace App\Enums\V1;

enum TransactionHeadEnum: int
{
    case Debit = 1;
    case Credit = 2;

    public function debit(): bool
    {
        return $this === self::Debit;
    }

    public function credit(): bool
    {
        return $this === self::Credit;
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::Debit => 'Debit',
            self::Credit => 'Credit',
        };
    }
}
