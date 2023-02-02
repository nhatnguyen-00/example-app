<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Base\Repository;

class UserRepository extends Repository
{
    public function model(): string
    {
        return User::class;
    }

    public function show(Request $request, int $id): ?User
    {
        $user = $this->model->findOrFail($id);

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        $user = $this->model->where('email', $email)->firstOrFail();

        return $user;
    }
}
