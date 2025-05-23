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
            ->select('users.*', 'user_entities.state_id', 'user_entities.institution_id', 'user_entities.sector_id', 'user_entities.bahagian_id')
            ->paginate(20);
        $roles = Role::pluck('name', 'id');

        return view('superAdmin.user.index', compact('bahagians', 'states', 'institutions', 'sectors', 'users', 'roles', 'username'));
    }

    public function store(Request $request)
    {
        // dd($request->password);
        $validatedData = $request->validate([
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
            // Hash the password properly using Laravel's built-in function
            $hashedPassword = Hash::make($validatedData['password']);
    
            // Default avatar path
            $defaultAvatar = 'default_pic.jpg';
    
            // Create user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $hashedPassword, // Properly hashed password
                'avatar' => $defaultAvatar,
            ]);
    
            // Assign role
            $user->syncRoles($validatedData['roles']);
    
            // Create user entity record
            $user->userEntity()->create([
                'state_id' => $validatedData['state_id'],
                'institution_id' => $validatedData['institution_id'],
                'sector_id' => $validatedData['sector_id'],
                'bahagian_id' => $validatedData['bahagian_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            Log::info("User created successfully: " . $user->email);
    
            return redirect('/users')->with('success', 'Pengguna Baharu Berjaya Dicipta.');
        } catch (\Exception $e) {
            Log::error("Failed to create user: " . $e->getMessage());
    
            return redirect()->back()->with('danger', 'Tidak Berjaya Mencipta User. Sila Cuba Lagi.');
        }    
    }

    public function update(Request $request, $id)
    {
        // Log::info("Entering update method for user ID: " . $id); 

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
            // Log::info("Updating user with ID: " . $id);
    
            // Update user details
            $user->name = $request->name;
            $user->email = $request->email;
    
            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }            
    
            // Sync roles
            $user->syncRoles($request->roles);
    
            // Save user details
            $user->save();
            // Log::info("User updated successfully: " . $user->id);
    
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
    
            return redirect('/users')->with('success', 'Pengguna Berjaya Dikemaskini.');
        } catch (\Exception $e) {
            // Log::error("Failed to update user: " . $e->getMessage());
    
            return redirect()->back()->with('danger', 'Pengguna Tidak Berjaya Dikemaskini. Sila Cuba Lagi.');
        }
    }    

    public function destroy($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->userEntity()->delete();
            $user->delete();

            return redirect('/users')->with('success', 'Pengguna Berjaya Dipadam.');
        } catch (Exception $e) {
            Log::error("Failed to delete user: " . $e->getMessage());

            return redirect()->back()->with('danger', 'Pengguna Tidak Berjaya Dipadam. Sila Cuba Lagi.');
        }
    }
}
