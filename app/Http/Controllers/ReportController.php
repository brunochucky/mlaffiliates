<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show user indication reports.
     */
    public function showIndicationReports()
    {
        // Get the currently authenticated user
        $currentUser = auth()->user();

        // Generate the hash based on the current user's email (or use a different attribute if needed)
        $hash = md5($currentUser->email);

        // Fetch direct referrals using affiliate_code
        $users = User::where('affiliate_code', $hash)->paginate(10, ['*'], 'users_page'); // Direct referrals with pagination

        // Fetch multi-level referrals
        $directUsers = User::where('affiliate_code', $hash)->pluck('id'); // Level 1
        $level2Users = User::whereIn('referrer_id', $directUsers)->pluck('id'); // Level 2
        $level3Users = User::whereIn('referrer_id', $level2Users)->pluck('id'); // Level 3
        $level4Users = User::whereIn('referrer_id', $level3Users)->pluck('id'); // Level 4

        // Combine all multi-level referrals into a single list for display
        $multiLevelUsers = User::whereIn('id', $directUsers->merge($level2Users)->merge($level3Users)->merge($level4Users))->paginate(10, ['*'], 'multi_page');

        // Fetch converted users from direct or multi-level referrals
        $convertedUsers = User::where('conversion', true)
            ->where(function ($query) use ($directUsers, $level2Users, $level3Users, $level4Users) {
                $query->whereIn('id', $directUsers)
                    ->orWhereIn('id', $level2Users)
                    ->orWhereIn('id', $level3Users)
                    ->orWhereIn('id', $level4Users);
            })->paginate(10, ['*'], 'converted_page');

        // Return the view with all necessary variables
        return view('dashboard.reports.indications', compact('users', 'multiLevelUsers', 'directUsers', 'level2Users', 'level3Users', 'level4Users', 'convertedUsers'));
    }
}
