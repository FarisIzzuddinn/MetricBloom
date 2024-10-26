<?php
namespace App\Http\Controllers;

use Log;
use App\Models\User;
use App\Models\State;
use App\Models\Sector;
use App\Models\Institution;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan senarai pengguna dengan fungsi carian dan penapis peranan
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $states = State::All();
        $institutions = Institution::all();
        $sectors = Sector::all();
       
        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($role, function ($query, $role) {
                return $query->whereHas('roles', function ($query) use ($role) {
                    $query->where('name', $role);
                });
            })
            ->get();
            
        $roles = Role::all()->pluck('name'); // Dapatkan senarai peranan untuk dropdown

        return view('superAdmin.user.index', [
            'users' => $users,
            'roles' => $roles,
            'username' => Auth::user(),
            'states' => $states,
            'institutions' => $institutions,
            'sectors' => $sectors
        ]);
    }

    // Menampilkan borang untuk membuat pengguna baharu
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $states = State::All();
        $institutions = Institution::all();
        $sectors = Sector::all();
        return view('superAdmin.user.create', [
            'roles' => $roles,
            'states' => $states, 
            'institutions' => $institutions,
            'sectors' => $sectors
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required',
            'state_id' => 'nullable|exists:states,id', // Validate state_id
            'institution_id' => 'nullable|exists:institutions,id', // Validate institution_id
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=> Hash::make($request->password),
            'state_id' => $request->state_id, // Store state_id
            'institution_id' => $request->institution_id, // Store institution_id
        ]);
    
        $user->syncRoles($request->roles);
    
        return redirect('/users')->with("status", "User created successfully with roles");
    }
    
    // Menampilkan borang untuk mengedit pengguna
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $states = State::all(); // Fetch states
        $institutions = Institution::all();
        $sectors = Sector::all();
        $username  = Auth::User();
        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('superAdmin.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'states' => $states, 
            'institutions' => $institutions,
            'sectors' => $sectors,
            'username' => $username
        ]);
    }

    // Mengemaskini maklumat pengguna
    public function update(Request $request, $id)
    {
        // Validate the request, including the institution_id
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'nullable|array',
            'state_id' => 'nullable|exists:states,id', 
            'institutions_id' => 'nullable|exists:institutions,id', 
            'sector_id' => 'nullable|exists:sectors,id', 
        ]);

        // Find the user by ID
        $user = User::findOrFail($id); 

        // Update the user's data
        $user->name = $request->name;

        // If a new password is entered, hash and update it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update state, institution, and sector IDs
        $user->state_id = $request->state_id; 
        $user->institution_id = $request->institutions_id; 
        $user->sector_id = $request->sector_id; 

        // Sync roles
        $user->syncRoles($request->roles); 

        // Save the changes
        $user->save();

        // Redirect with a success message
        return redirect('users')->with('status', 'User updated successfully');
    }


    public function renumberItems()
    {
        $items = User::orderBy('created_at')->get();
        foreach ($items as $index => $item) {
            $item->update(['position' => $index + 1]);
        }
    }

    // Memadam pengguna dari pangkalan data
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $this->renumberItems();
        $user->delete();

        return redirect('/users')->with("status", "User deleted successfully");
    }

    public function getInstitutions($stateId)
    {
        // Fetch institutions based on the state ID
        $institutions = Institution::where('state_id', $stateId)->get();
        return response()->json($institutions);
    }
}
