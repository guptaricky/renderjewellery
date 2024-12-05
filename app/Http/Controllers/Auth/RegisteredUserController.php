<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Role::whereNotin('name' , ['Admin','SuperAdmin'])->orderBy('created_at','DESC')->get();
        return view('auth.register',['roles' => $roles]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'integer', 'max:10'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'plan_id' => 1,
            'password' => Hash::make($request->password),
        ]);

        $roleUser = RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $request->role,
        ]);

        $getUserName = Role::where('id', $request->role)->select('name')->first();

        event(new Registered($user));

        Auth::login($user);

        if(in_array($getUserName->name, ['Admin', 'SuperAdmin'])){
            return redirect(route('adminDashboard', absolute: false));
        }
        else{
            return redirect(route('userDashboard', absolute: false));
        }
        
    }
}
