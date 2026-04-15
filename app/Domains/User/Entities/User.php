<?php

namespace App\Domains\User\Entities;

use App\Domains\Shared\ValueObjects\Email;
use App\Domains\User\ValueObjects\Role;

class User
{
    private ?int $id;
    private string $name;
    private Email $email;
    private string $passwordHash;
    private Role $role;
    private ?string $phoneNumber;
    private ?bool $isEmailVerified;
    private ?string $rememberToken;
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $updatedAt;
    /**
     * Create a new class instance.
     */
    public function __construct(
        string $name,
        Email $email,
        string $plainPassword,
        Role $role,
        ?string $phoneNumber = null
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->setPassword($plainPassword);
        $this->role = $role;
        $this->phoneNumber = $phoneNumber;
        $this->isEmailVerified = false;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getRememberToken(): string
    {
        return $this->passwordHash;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function isEmailVerified(): bool
    {
        return $this->isEmailVerified;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setPasswordHash(string $hash): void
    {
        $this->passwordHash = $hash;
    }

    public function setRememberToken(?string $token): void
    {
        $this->rememberToken = $token;
    }

    public function setCreatedAt(\DateTimeImmutable $date): void
    {
        $this->createdAt = $date;
    }

    public function setUpdatedAt(?\DateTimeImmutable $data): void
    {
        $this->updatedAt = $data;
    }

    public function makeEmailVerified(): void
    {
        $this->isEmailVerified = true;
    }

    public function setPassword(string $plainPassword): void
    {
        $this->passwordHash = bcrypt($plainPassword);
    }

    public function verifiedPassword(string $plainPassword): bool
    {
        return \Hash::check($plainPassword, $this->passwordHash);
    }

    public function updateProfile(string $name, string $phoneNumber): void
    {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
    }
}
