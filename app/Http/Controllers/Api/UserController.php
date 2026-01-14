<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $user = User::orderBy('created_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse($user, 'User list retrieved successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return $this->successResponse($user, 'User created successfully', 201);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->errorResponse('User not found', 401);
        }
        return $this->successResponse($user, 'User retrieved successfully');
    }

    public function changeRole(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->errorResponse('User not found', 401);
        }

        $request->validate([
            'role_id' => ['required', Rule::exists('roles', 'id')],
        ]);

        $user->role_id = $request->role_id;
        $user->save();

        return $this->successResponse($user, 'User role updated successfully', 201);
    }
}
