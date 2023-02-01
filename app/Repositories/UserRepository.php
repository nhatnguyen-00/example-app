<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    protected Model $model;

    public function model(): string
    {
        return User::class;
    }

    public function __construct()
    {
        $this->makeModel();
    }

    public function makeModel(): void
    {
        $this->model = app($this->model());
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
