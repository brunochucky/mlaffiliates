<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {


        $messages = [
            'cellphone.phone' => 'Please provide a valid cellphone number.',
        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'affiliate_code' => ['nullable', 'string', 'max:255'],  // Validation for affiliate code
            'cellphone' => ['required', 'phone:AUTO'],  // Validation for cellphone, make required
        ], $messages);

        // Find the referrer based on the affiliate code
        $referrer = User::where('unique_rid', $request->affiliate_code)->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'affiliate_code' => $request->affiliate_code,  // Storing affiliate code
            'cellphone' => $request->cellphone,            // Storing cellphone
            'referrer_id' => $referrer ? $referrer->id : null,  // Store the referrer_id if available
        ]);

        // Check if an affiliate code was provided and find the referring user
        if ($request->affiliate_code) {
            if ($referrer) {
                // Increment the referrals count for the referrer
                $referrer->increment('referrals_count');
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
