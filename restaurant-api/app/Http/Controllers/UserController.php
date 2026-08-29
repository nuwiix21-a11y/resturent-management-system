<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,staff',
        ]);
        
        $data['password'] = null; // Staff have no password
        $user = User::create($data);

        // Send welcome email with username
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\WelcomeStaffMail($user, null));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send welcome email: ' . $e->getMessage());
        }

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'sometimes|string|max:100',
            'username' => 'sometimes|string|max:50|unique:users,username,' . $user->id,
            'email'    => 'sometimes|email|unique:users,email,' . $user->id,
            'role'     => 'sometimes|in:admin,staff',
        ]);
        $user->update($data);
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        if ($user->id === request()->user()->id) {
            return response()->json(['message' => 'Cannot delete your own account.'], 403);
        }
        $user->tokens()->delete();
        $user->delete();
        return response()->json(['message' => 'User removed.']);
    }
}
