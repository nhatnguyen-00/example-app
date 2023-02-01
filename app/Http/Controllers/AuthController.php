<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Exception;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $email = $request->get('email');
            $password = $request->get('password');
            $checkAuth = $this->authService->checkAccount($email, $password);

            if (!$checkAuth) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorized'
                ]);
            }

            /** @var UserRepository $userRepository */
            $userRepository = app(UserRepository::class);
            $user = $userRepository->findByEmail($email);

            // if (!Hash::check($request->password, $user->password, [])) {
            //     throw new \Exception('Error in Login');
            // }

            $tokenResult = $this->authService->createToken($user);

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }
}
