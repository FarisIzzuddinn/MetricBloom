<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\State;
use App\Models\Sector;
use App\Models\Bahagian;
use App\Models\Institution;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super admin')->only(['create', 'store', 'update', 'destroy']);
    }

    public function index()
    {
        $username = Auth::user();

        $states = State::all();
        $institutions = Institution::all();
        $sectors = Sector::all();
        $bahagians = Bahagian::all();
        $users = User::with(['roles'])
            ->leftJoin('user_entities', 'users.id', '=', 'user_entities.user_id')
            ->select('users.*', 'user_entities.state_id', 'user_entities.institution_id', 'user_entities.sector_id')
            ->paginate(25);
        $roles = Role::pluck('name');

        return view('superAdmin.user.index', compact('bahagians', 'states', 'institutions', 'sectors', 'users', 'roles', 'username'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'required|string',
            'state_id' => 'nullable|exists:states,id',
            'institution_id' => 'nullable|exists:institutions,id',
            'sector_id' => 'nullable|exists:sectors,id',
            'bahagian_id' => 'nullable|exists:bahagian,id',
        ]);

        try {
            $salt = bin2hex(random_bytes(16));
            $hashedPassword = hash('sha512', $salt . $request->password);

            for ($i = 0; $i < 10000; $i++) {
                $hashedPassword = hash('sha512', $hashedPassword);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $hashedPassword,
                'salt' => $salt,
            ]);

            $user->syncRoles($request->roles);

            $user->userEntity()->create([
                'state_id' => $request->state_id,
                'institution_id' => $request->institution_id,
                'sector_id' => $request->sector_id,
                'bahagian_id' => $request->bahagian_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect('/users')->with([
                'status' => 'User created successfully with roles.',
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to create user: " . $e->getMessage());

            return redirect()->back()->with([
                'status' => 'Failed to create user. Please try again.',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        Log::info("Entering update method for user ID: " . $id); 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'roles' => 'required|string',
            'state_id' => 'nullable|exists:states,id',
            'institution_id' => 'nullable|exists:institutions,id',
            'sector_id' => 'nullable|exists:sectors,id',
            'bahagian_id' => 'nullable|exists:bahagian,id',
        ]);
    
        try {
            $user = User::findOrFail($id);
            Log::info("Updating user with ID: " . $id);
    
            // Update user details
            $user->name = $request->name;
            $user->email = $request->email;
    
            // Update password if provided
            if ($request->filled('password')) {
                $salt = bin2hex(random_bytes(16));
                $hashedPassword = hash('sha512', $salt . $request->password);
    
                for ($i = 0; $i < 10000; $i++) {
                    $hashedPassword = hash('sha512', $hashedPassword);
                }
    
                $user->password = $hashedPassword;
                $user->salt = $salt;
            }
    
            // Sync roles
            $user->syncRoles($request->roles);
    
            // Save user details
            $user->save();
            Log::info("User updated successfully: " . $user->id);
    
            // Update or create user entity
            $user->userEntity()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'state_id' => $request->state_id,
                    'institution_id' => $request->institution_id,
                    'sector_id' => $request->sector_id,
                    'bahagian_id' => $request->bahagian_id,
                    'updated_at' => now(),
                ]
            );
    
            return redirect('/users')->with([
                'status' => 'User updated successfully.',
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to update user: " . $e->getMessage());
    
            return redirect()->back()->with([
                'status' => 'Failed to update user. Please try again.',
                'alert-type' => 'danger',
            ]);
        }
    }    

    public function destroy($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->userEntity()->delete();
            $user->delete();

            return redirect('/users')->with([
                'status' => 'User deleted successfully.',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            Log::error("Failed to delete user: " . $e->getMessage());

            return redirect()->back()->with([
                'status' => 'Failed to delete user. Please try again.',
                'alert-type' => 'danger',
            ]);
        }
    }
}
