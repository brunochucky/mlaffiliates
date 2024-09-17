@php
$emailHash = md5(Auth::user()->email);
$registrationLink = route('register') . '?uid=' . $emailHash;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-bold text-xl">{{ __('User Indication Reports') }}</h2>

                    <!-- Existing Table for Direct Referrals -->
                    <div class="bg-white rounded my-6">
                        <h3 class="font-bold">{{ __('Direct Referrals') }}</h3>
                        <table class="min-w-full table table-auto border-2">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-2 text-left">{{ __('User') }}</th>
                                    <th class="py-2 px-4 border-2 text-left">{{ __('Email') }}</th>
                                    <th class="py-2 px-4 border-2 text-left">{{ __('Indications') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr class="even:bg-gray-100 odd:bg-white">
                                    <td class="py-2 px-4 border-2">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-2">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-2">{{ $user->referrals_count }}</td> <!-- Assuming referrals relationship -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links for Direct Referrals -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>

                    <!-- New Table for Multi-Level Referrals -->
                    <div class="bg-white rounded my-6 mt-12">
                        <h3 class="font-bold">{{ __('Multi-Level Referrals (Up to 4 Levels)') }}</h3>
                        @php
                        $totalGains = 0; // Initialize total gains variable
                        @endphp

                        <table class="min-w-full table table-auto border-2">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-2 text-left">{{ __('User') }}</th>
                                    <th class="py-2 px-4 border-2 text-left">{{ __('Email') }}</th>
                                    <th class="py-2 px-4 border-2 text-left">{{ __('Level') }}</th>
                                    <th class="py-2 px-4 border-2 text-left">{{ __('Estimated Gains') }}</th> <!-- New column for gains -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($multiLevelUsers as $user)
                                <tr class="even:bg-gray-100 odd:bg-white">
                                    <td class="py-2 px-4 border-2">{{ $user->name }}</td>
                                    <td class="py-2 px-4 border-2">{{ $user->email }}</td>
                                    <td class="py-2 px-4 border-2">
                                        @php
                                        $level = null;
                                        $gains = 0;

                                        // Determine the referral level and calculate gains
                                        if (in_array($user->id, $directUsers->toArray())) {
                                        $level = 1;
                                        $gains = 500;
                                        } elseif (in_array($user->id, $level2Users->toArray())) {
                                        $level = 2;
                                        $gains = 250;
                                        } elseif (in_array($user->id, $level3Users->toArray())) {
                                        $level = 3;
                                        $gains = 150;
                                        } elseif (in_array($user->id, $level4Users->toArray())) {
                                        $level = 4;
                                        $gains = 100;
                                        }

                                        // Accumulate the total gains
                                        $totalGains += $gains;
                                        @endphp
                                        {{ $level }}
                                    </td>
                                    <td class="py-2 px-4 border-2">{{ __('$') }}{{ number_format($gains, 2) }}</td> <!-- Display the calculated gains -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Display Total Estimated Gains below the table -->
                        <div class="mt-4 text-right">
                            <span class="font-bold text-lg">{{ __('Total Estimated Gains') }}: {{ __('$') }}{{ number_format($totalGains, 2) }}</span>
                        </div>


                    </div>

                    <!-- Pagination Links for Multi-Level Referrals -->
                    <div class="mt-4">
                        {{ $multiLevelUsers->links() }} <!-- Pagination for multi-level referrals -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>