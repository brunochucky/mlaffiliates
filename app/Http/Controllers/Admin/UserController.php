<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Check if the user is an administrator
        if (Auth::check() && Auth::user()->role === 'administrator') {
            // Fetch total user count
            $totalUsers = User::count();

            // Fetch users with pagination (e.g., 10 users per page)
            $users = User::paginate(5);

            // Pass total user count and users list to the view
            return view('admin.users', [
                'totalUsers' => $totalUsers,
                'users' => $users,
            ]);
        }

        // Redirect with an access denied message if the user is not an admin
        return redirect('/')->with('error', 'Access Denied');
    }

    public function show($id)
    {
        if (Auth::check() && Auth::user()->role === 'administrator') {
            // Find the user by ID or throw a 404 if not found
            $user = User::findOrFail($id);

            // Pass the user to the view
            return view('admin.users.show', compact('user'));
        }

        // Redirect with an access denied message if the user is not an admin
        return redirect('/')->with('error', 'Access Denied');
    }

    public function convert($id)
    {

        if (Auth::check() && Auth::user()->role === 'administrator') {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Check if the user is not already converted
            if (!$user->conversion) {
                // Update the user's conversion status to true (1)
                $user->conversion = true;
                $user->save();

                // Optionally, add a success message
                return redirect()->route('admin.users.show', $user->id)->with('success', 'User successfully converted.');
            }

            // If the user is already converted, redirect back with a message
            return redirect()->route('admin.users.show', $user->id)->with('error', 'User is already converted.');
        }


        // Redirect with an access denied message if the user is not an admin
        return redirect('/')->with('error', 'Access Denied');
    }

    public function undoConvert($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Check if the user is converted
        if ($user->conversion) {
            // Update the user's conversion status to false (0)
            $user->conversion = false;
            $user->save();

            // Optionally, add a success message
            return redirect()->route('admin.users.show', $user->id)->with('success', 'User conversion undone successfully.');
        }

        // If the user is not converted, return an error message
        return redirect()->route('admin.users.show', $user->id)->with('error', 'User is not converted.');
    }
}
