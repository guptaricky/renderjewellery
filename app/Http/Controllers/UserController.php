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
        $roleFilter = $request->query('role', '');  // Default to empty if not present
        $searchtext = $request->query('searchtext', '');  // Default to empty if not present

        $authUser = Auth::user();  // Get the currently logged-in user

        // Build base query for roles
        $rolesQuery = Role::query();
        if ($authUser->hasRole('Admin')) {
            $rolesQuery->whereNotIn('name', ['SuperAdmin', 'Admin']);
        }
        if ($authUser->hasRole('SuperAdmin')) {
            $rolesQuery->where('name', '!=', 'SuperAdmin');
        }
        $roles = $rolesQuery->get();  // Fetch the roles

        // Build the base query for users
        $usersQuery = User::with('roles', 'plan');

        // Filter out the logged-in user or SuperAdmins/Admins based on roles
        if ($authUser->hasRole('SuperAdmin')) {
            $usersQuery->where('id', '!=', $authUser->id);  // Exclude SuperAdmin itself
        }

        if ($authUser->hasRole('Admin')) {
            $usersQuery->whereDoesntHave('roles', function ($roleQuery) {
                $roleQuery->whereIn('name', ['SuperAdmin', 'Admin']);
            });  // Exclude SuperAdmins and Admins for Admin users
        }

        // Apply role filter if selected
        if ($roleFilter !== '') {
            $usersQuery->whereHas('roles', function ($roleQuery) use ($roleFilter) {
                $roleQuery->where('name', $roleFilter);
            });
        }

        // Apply search text filter if entered
        if ($searchtext !== '') {
            $usersQuery->where(function ($query) use ($searchtext) {
                $query->where('name', 'like', '%' . $searchtext . '%')
                    ->orWhere('email', 'like', '%' . $searchtext . '%');
            });
        }

        // Execute the query to get filtered users
        $users = $usersQuery->get();

        // Pass the data to the view
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

        $uploaded_designes = Product::with('productdesign')
        ->where('user_id', $id)
        ->orderBy('created_at','desc')
        ->get();

        $purchased_designes = Orders::with('items')
        ->where('user_id', $id)
        ->orderBy('created_at','desc')
        ->get();

         // dd($uploaded_designes);
         $design_count = Product::where('user_id', $id)
         ->sum('design_count');

        // $createdProducts = Product::where('user_id', $id)
        //     ->withCount(['orderItems as purchased_quantity' => function ($query) {
        //         $query->select(DB::raw('SUM(quantity)'));
        //     }])
        //     ->get();

        // dd($createdProducts);
        $design_count = Product::where('user_id', $id)
        ->sum('design_count');

        if (!$user) {
            return back()->withErrors('User not found.');
        }

        $uploaded_designes = array_merge($uploaded_designes->toArray(),$purchased_designes->toArray());
        // dd($uploaded_designes);
        return view('users/details', [
            'user' => $user,
            'uploaded_designes' => $uploaded_designes,
            // 'purchased_designes' => $purchased_designes,
            'design_count' => $design_count
        ]);
    }

    public function designDetails($id, $upload_id)
    {
        $user = User::with('roles', 'plan')
            ->where('id', $id)
            ->first();

        $uploaded_designes = Product::where('user_id', $id)->where('id', $upload_id)
        ->orderBy('created_at','desc')
        ->first();

        // dd($uploaded_designes);

        $designes = ProductDesign::where('product_id', $upload_id)
        ->orderBy('created_at','desc')
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
