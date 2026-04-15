<?php

namespace App\Domains\User\Repositories;

use App\Domains\Shared\ValueObjects\Email;
use App\Domains\User\Entities\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findById(int $id): ?User;
    public function findByEmail(Email $email): ?User;
    public function delete(User $user): void;
}
