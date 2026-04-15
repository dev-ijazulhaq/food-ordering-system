<?php

namespace App\Domains\User\Actions;

use App\Domains\Shared\ValueObjects\Email;
use App\Domains\User\Entities\User;
use App\Domains\User\Repositories\UserRepositoryInterface;
use App\Domains\User\ValueObjects\Role;

class RegisterUserAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(
        string $name,
        string $email,
        string $password,
        string $role,
        string $phoneNumber = null
    ) {
        $existing = $this->userRepository->findByEmail(new Email($email));
        if ($existing) {
            throw new \Exception("Email already registered", 422);
        }

        if (!in_array($role, ['customer', 'restaurant_owner', 'driver'])) {
            throw new \Exception("Invalid role", 422);
        }

        $user = new User(
            $name,
            new Email($email),
            $password,
            Role::from($role),
            $phoneNumber
        );

        $this->userRepository->save($user);
        return $user;
    }
}
