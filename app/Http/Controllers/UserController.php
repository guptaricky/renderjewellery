<?php

namespace App\Http\Controllers;

use App\Models\Designs;
use App\Models\DesignUpload;
use App\Models\User;
use App\Models\Role;
use App\Models\Plans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userList(Request $request)
    {
        $roleFilter = $request->query('role', '');  // Default to empty if not present
        $searchtext = $request->query('searchtext', '');  // Default to empty if not present

        $authUser = Auth::user();

        $users = User::with('roles', 'plan')
            ->when($authUser->hasRole('SuperAdmin') || $authUser->hasRole('Admin'), function ($query) use ($authUser, $roleFilter, $searchtext) {
                if ($authUser->hasRole('SuperAdmin')) {
                    $query->where('id', '!=', $authUser->id);
                }

                if ($authUser->hasRole('Admin')) {
                    $query->whereDoesntHave('roles', function ($roleQuery) {
                        $roleQuery->whereIn('name', ['SuperAdmin', 'Admin']);
                    });
                }

                if ($roleFilter != '') {
                    $query->whereHas('roles', function ($roleQuery) use ($roleFilter) {
                        $roleQuery->where('name', $roleFilter);
                    });
                }

                if ($searchtext != '') {
                    $query->where(function ($query) use ($searchtext) {
                        $query->where('name', 'like', '%' . $searchtext . '%')
                            ->orWhere('email', 'like', '%' . $searchtext . '%');
                    });
                }
            })
            ->get();

        $roles = Role::all(); // Fetch all roles
        return view('users.usersList', [
            'users' => $users,
            'roles' => $roles,  // Pass roles to the view
            'roleFilter' => $roleFilter,
            'searchtext' => $searchtext
        ]);
    }

    public function userDetails($id)
    {
        $user = User::with('roles', 'plan')
            ->where('id', $id)
            ->first();

        $uploaded_designes = DesignUpload::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $design_count = DesignUpload::where('user_id', $id)
            ->sum('design_count');

        if (!$user) {
            return back()->withErrors('User not found.');
        }

        return view('users/details', [
            'user' => $user,
            'uploaded_designes' => $uploaded_designes,
            'design_count' => $design_count
        ]);
    }

    public function designDetails($id, $upload_id)
    {
        $user = User::with('roles', 'plan')
            ->where('id', $id)
            ->first();

        $uploaded_designes = DesignUpload::where('user_id', $id)->where('id', $upload_id)
            ->orderBy('created_at', 'desc')
            ->first();

        // dd($uploaded_designes);

        $designes = Designs::where('design_upload_id', $upload_id)
            ->orderBy('created_at', 'desc')
            ->get();


        if (!$user) {
            return back()->withErrors('User not found.');
        }

        return view('users/designDetails', [
            'user' => $user,
            'uploaded_designes' => $uploaded_designes,
            'designes' => $designes
        ]);
    }

    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|min:2',
            'email' => 'required|min:2',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('user.create')->withInput()->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->code;
        $user->isActive = 1;

        $user->save();
        return redirect()->route('plan.create')->with('success', 'Plan created successfully');
    }

    public function updateActive($id, Request $request)
    {
        $company = User::findOrFail($id);
        $company->isActive = $request->input('isActive');
        $company->save();

        return response()->json(['message' => 'Active status updated successfully', 'success' => true]);
    }
    // Show the form to edit roles for a specific user
    public function edit(User $user)
    {
        $roles = Role::all(); // Get all roles
        return view('users.edit_role', compact('user', 'roles'));
    }

    // Update the user's roles
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array',
        ]);

        // Fetch role IDs based on the role names
        $roleIds = Role::whereIn('name', $request->roles)->pluck('id')->toArray();

        $user->syncRoles($roleIds);

        return redirect()->route('admin.users.index')->with('success', 'User roles updated successfully!');
    }
}
