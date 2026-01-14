<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

class RoleController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $perPage = $request->get('per_page' . 10);
        $role = Role::orderBy('created_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse($role, 'Role list retrieved successfully');
    }


    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        return $this->successResponse($role, 'Role retrieved successfully');
    }
}
