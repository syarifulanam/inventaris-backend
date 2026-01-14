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

        return response()->json(['status' => 'success', 'user' => $user]);
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json(['status' => 'success', 'user' => $user]);
    }

    public function changeRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role_id' => ['required', Rule::exists('roles', 'id')],
        ]);

        $role = Role::findOrFail($request->role_id);
        $validRoles = ['Admin', 'Seller', 'Pelanggan'];
        if (!in_array($role->name, $validRoles)) {
            return response()->json([
                'message' => 'Role tidak valid. Hanya boleh Admin, Seller, atau Pelanggan.'
            ], 422);
        }

        $user->role_id = $role->id;
        $user->save();

        return response()->json([
            'message' => 'Role user berhasil diubah',
            'user' => $user->fresh()
        ]);
    }
}
