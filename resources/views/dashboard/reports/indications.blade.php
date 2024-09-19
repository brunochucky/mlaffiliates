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

                    <!-- Include Direct Referrals Partial -->
                    @include('partials.direct-referrals')

                    <!-- Include Multi-Level Referrals Partial -->
                    @include('partials.multilevel-referrals')

                    <!-- Include Converted Users Partial -->
                    @include('partials.converted-users', ['convertedUsers' => $convertedUsers])




                </div>
            </div>
        </div>
    </div>
</x-app-layout>
