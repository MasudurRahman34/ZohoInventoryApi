<?php

namespace App\Enums\V1;

enum PaymentTypeEnum: string
{
    case sent = 'sent';
    case recieved = 'recieved';

    public function sent(): bool
    {
        return $this === self::sent;
    }

    public function recieved(): bool
    {
        return $this === self::recieved;
    }
}

enum PaymentStatusEnum: string
{
    case income = 'income';
    case expense = 'expense';

    public function income(): bool
    {
        return $this === self::income;
    }

    public function expense(): bool
    {
        return $this === self::expense;
    }
}

enum PaymentPaidByEnum: string
{
    case cash = 'cash';
    case check = 'check';
    case credit_card = 'credit_card';
    case bank_transfer = 'bank_transfer';
    case bkash = 'bkash';
    case bank_remitance = 'bank_remitance';
    case account_credit = 'account_credit';
    case nagad = 'nagad';
    case surecash = 'surecash';
    case rocket = 'rocket';
    case cod = 'cod';

    public function cash(): bool
    {
        return $this === self::cash;
    }

    public function check(): bool
    {
        return $this === self::check;
    }

    public function creditCard(): bool
    {
        return $this === self::credit_card;
    }

    public function bank_transfer(): bool
    {
        return $this === self::bank_transfer;
    }
    public function bkash(): bool
    {
        return $this === self::bkash;
    }

    public function bankRemitance(): bool
    {
        return $this === self::bank_remitance;
    }
    public function nagad(): bool
    {
        return $this === self::nagad;
    }
    public function surecash(): bool
    {
        return $this === self::surecash;
    }
    public function rocket(): bool
    {
        return $this === self::rocket;
    }
    public function cod(): bool
    {
        return $this === self::cod;
    }
}

enum PaymentMethodEnum: string
{
    case bank = 'bank';
    case cash = 'cash';
    case mobile = 'mobile';
    case cod = 'cod';
    case card = 'card';

    public function bank(): bool
    {
        return $this === self::bank;
    }

    public function card(): bool
    {
        return $this === self::card;
    }
    public function mobile(): bool
    {
        return $this === self::mobile;
    }
    public function cod(): bool
    {
        return $this === self::cod;
    }

    public function cash(): bool
    {
        return $this === self::cash;
    }
}

enum PaymentThankYouEnum: string
{
    case sent = 'sent';
    case pending = 'pending';

    public function sent(): bool
    {
        return $this === self::sent;
    }

    public function pending(): bool
    {
        return $this === self::pending;
    }
}
