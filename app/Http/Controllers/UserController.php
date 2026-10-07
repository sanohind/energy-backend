<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'users' => UserResource::collection(
                User::query()->orderBy('name')->get()
            )->resolve(),
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['is_active'] = $data['is_active'] ?? true;

        $user = User::query()->create($data);

        return response()->json([
            'user' => UserResource::make($user)->resolve(),
        ], 201);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();

        if ($request->user()->is($user)) {
            if (array_key_exists('role', $data) && $data['role'] !== User::ROLE_ADMIN) {
                return response()->json([
                    'message' => 'You cannot change your own role.',
                ], 422);
            }

            if (array_key_exists('is_active', $data) && ! $data['is_active']) {
                return response()->json([
                    'message' => 'You cannot deactivate your own account.',
                ], 422);
            }
        }

        if (array_key_exists('password', $data) && blank($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json([
            'user' => UserResource::make($user->fresh())->resolve(),
        ]);
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        if ($request->user()->is($user)) {
            return response()->json([
                'message' => 'You cannot delete your own account.',
            ], 422);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'message' => 'User deleted.',
        ]);
    }
}
