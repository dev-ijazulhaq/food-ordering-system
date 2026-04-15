<?php

namespace App\Domains\Shared\ValueObjects;

use InvalidArgumentException;

class PhoneNumber
{
    private string $value;
    /**
     * Create a new class instance.
     */
    public function __construct(string $value)
    {
        $cleaned = preg_replace('/[^0-9+]/', '', $value);
        if (strlen($cleaned) < 10) {
            throw new InvalidArgumentException('Invalid phone number.');
        }
        $this->value = $cleaned;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
