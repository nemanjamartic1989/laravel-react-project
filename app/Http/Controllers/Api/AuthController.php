<?php

namespace App\Http\Controllers\Api;

use App\Domain\User\Repositories\UserRepository;
use App\Domain\User\DTO\RegisterUserDataDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected UserRepository $repository)
    {}

    /**
     * Login
     * @param LoginRequest $request
     * @return void
     */
    public function login(LoginRequest $request): Response
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return response([
                'message' => 'Provided email address or password is incorrect!'
            ], 422);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'token'));
    }

    /**
     * Register
     * @param RegisterRequest $request
     * @return void
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = new RegisterUserDataDTO($request->validated());
        $user = $this->repository->createUser($dto);

        $token = $user->createToken('main')->plainTextToken;

        return response()->json(compact('user', 'token'));
    }

    /**
     * Logout
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function logout(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response('', 404);
    }
}