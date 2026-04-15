<?php

namespace App\Domains\User\ValueObjects;

class Address
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private string $label,
        private string $addressLine1,
        private ?string $addressLine2,
        private string $city,
        private string $zipCode,
        private ?float $latitude,
        private ?float $longitude,
        private bool $isDefault = false
    ) {}

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getAddressLine1(): string
    {
        return $this->addressLine1;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }
}
