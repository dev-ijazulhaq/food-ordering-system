<?php

namespace App\Domains\User\Actions;

use App\Domains\Shared\ValueObjects\Email;
use App\Domains\User\Repositories\UserRepositoryInterface;

class LoginUserAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function execute(string $email, string $password): array
    {
        $user = $this->userRepository->findByEmail(new Email($email));

        if (!$user || !$user->verifiedPassword($password)) {
            throw new \Exception("Invalid credentials", 422);
        }

        $eloquentUser = \App\Models\User::find($user->getId());
        $token = $eloquentUser->createToken('auth_token')->plainTextToken();

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
