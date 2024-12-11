<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Product;
use App\Models\ProductDesign;
use App\Models\User;
use App\Models\Role;
use App\Models\Plans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function userList(Request $request)
    {
        $roleFilter = $request->query('role', '');
        $planFilter = $request->query('plan', '');
        $searchtext = $request->query('searchtext', '');

        $authUser = Auth::user();  // Get the currently logged-in user

        // Fetch roles and plans
        $rolesQuery = Role::query();
        if ($authUser->hasRole('Admin')) {
            $rolesQuery->whereNotIn('name', ['SuperAdmin', 'Admin']);
        }
        if ($authUser->hasRole('SuperAdmin')) {
            $rolesQuery->where('name', '!=', 'SuperAdmin');
        }
        $roles = $rolesQuery->get();

        $plans = Plans::all();

        // Base query for users
        $usersQuery = User::with('roles', 'plan');

        if ($authUser->hasRole('SuperAdmin')) {
            $usersQuery->where('id', '!=', $authUser->id);  // Exclude SuperAdmin itself
        }

        if ($authUser->hasRole('Admin')) {
            $usersQuery->whereDoesntHave('roles', function ($roleQuery) {
                $roleQuery->whereIn('name', ['SuperAdmin', 'Admin']);
            });  // Exclude SuperAdmins and Admins for Admin users
        }

        // Apply role and plan filters if they are set
        if ($roleFilter !== '') {
            $usersQuery->whereHas('roles', function ($roleQuery) use ($roleFilter) {
                $roleQuery->where('name', $roleFilter);
            });
        }

        if ($planFilter !== '') {
            $usersQuery->whereHas('plan', function ($planQuery) use ($planFilter) {
                $planQuery->where('name', $planFilter);
            });
        }

        // Apply search filter
        if ($searchtext !== '') {
            $usersQuery->where(function ($query) use ($searchtext) {
                $query->where('name', 'like', '%' . $searchtext . '%')
                    ->orWhere('email', 'like', '%' . $searchtext . '%');
            });
        }

        // Fetch filtered users
        $users = $usersQuery->get();

        // If the request is AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'users' => $users,
                'roles' => $roles,
                'plans' => $plans,
                'roleFilter' => $roleFilter,
                'planFilter' => $planFilter,
                'searchtext' => $searchtext,
            ]);
        }

        // Otherwise, return the view
        return view('users.usersList', [
            'users' => $users,
            'roles' => $roles,
            'plans' => $plans,
            'roleFilter' => $roleFilter,
            'planFilter' => $planFilter,
            'searchtext' => $searchtext,
        ]);
    }

    public function search(Request $request)
    {
        // If the request is an AJAX request, return the users as JSON
        if ($request->ajax()) {
            return $this->userList($request);  // Call userList and pass the request to it
        }

        // If it's not an AJAX request, proceed as usual (return a view or something else)
        return view('users.usersList');
    }

    public function userDetails($id)
    {
        $user = User::with('roles', 'plan')
            ->where('id', $id)
            ->first();

        $uploaded_designes = Product::with('productdesign')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $purchased_designes = Orders::with('items')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();


        // $product_count = Product::withCount('product')->where('user_id', $id)
        // ->sum('design_count');

        $purchased_count = Orders::where('user_id', $id)
            ->sum('order_number');

        if (!$user) {
            return back()->withErrors('User not found.');
        }

        $uploaded_designes = array_merge($uploaded_designes->toArray(), $purchased_designes->toArray());
        // dd($uploaded_designes);
        return view('users/details', [
            'user' => $user,
            'uploaded_designes' => $uploaded_designes,
            // 'product_count' => $product_count,
            'purchased_count' => $purchased_count
        ]);
    }

    public function designDetails($id, $upload_id)
    {
        $user = User::with('roles', 'plan')
            ->where('id', $id)
            ->first();

        $uploaded_designes = Product::where('user_id', $id)->where('id', $upload_id)
            ->orderBy('created_at', 'desc')
            ->first();

        // dd($uploaded_designes);

        $designes = ProductDesign::where('product_id', $upload_id)
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
    public function updateRoles(Request $request, User $user)
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
