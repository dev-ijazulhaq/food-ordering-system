<?php

namespace App\Domains\User\Repositories\Eloquent;

use App\Domains\Shared\ValueObjects\Email;
use App\Domains\User\Entities\User;
use App\Domains\User\Repositories\UserRepositoryInterface;
use App\Models\User as ModelsUser;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        $eloquent = ModelsUser::updateOrCreate(
            ['id' => $user->getId()],
            [
                'name' => $user->getName(),
                'email' => $user->getEmail()->getValue(),
                'password' => $user->getPasswordHash(),
                'role' => $user->getRole()->value,
                'phone_number' => $user->getPhoneNumber(),
                'email_verified_at' => $user->isEmailVerified() ? now() : null,
                'remember_token' => $user->getRememberToken(),
                'created_at' => $user->getCreatedAt(),
                'update_at' => now(),
            ]
        );

        if (!$user->getId()) {
            $user->setId($eloquent->id);
        }
    }

    public function findById(int $id): ?User
    {
        $eloquent = ModelsUser::find($id);
        if (!$eloquent) return null;
        return $this->toDomain($eloquent);
    }

    public function findByEmail(Email $email): ?User
    {
        $eloquent = ModelsUser::where('email', $email->getValue())->first();
        if (!$eloquent) return null;
        return $this->toDomain($eloquent);
    }

    public function delete(User $user): void
    {
        ModelsUser::destroy($user->getId());
    }

    private function toDomain(ModelsUser $eloquent): User
    {
        $user = new User(
            $eloquent->name,
            new Email($eloquent->email),
            'dummy',
            \App\Domains\User\ValueObjects\Role::from($eloquent->role),
            $eloquent->phone_number
        );

        $user->setId($eloquent->id);
        $user->setPasswordHash($eloquent->password);
        $user->setRememberToken($eloquent->remember_token);
        $user->setCreatedAt(new \DateTimeImmutable($eloquent->created_at));
        $user->setUpdatedAt($eloquent->updated_at ? new \DateTimeImmutable($eloquent->updated_at) : null);
        if ($eloquent->email_verified_at) {
            $user->makeEmailVerified();
        }
        return $user;
    }
}
