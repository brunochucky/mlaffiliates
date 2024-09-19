<!-- Partial for Multi-Level Referrals -->
<div class="bg-white rounded my-0 mt-12">
    <h3 class="font-bold">{{ __('Multi-Level Referrals (Up to 4 Levels)') }}</h3>
    @php
        $totalGains = 0; // Initialize total gains variable
        $nestedUserIds = []; // Array to track nested user IDs
    @endphp

    <table class="min-w-full table table-auto border-0">
        <thead>
            <tr>
                <th class="py-2 px-4 border-2 text-left">{{ __('User') }}</th>
                <th class="py-2 px-4 border-2 text-left">{{ __('Email') }}</th>
                <th class="py-2 px-4 border-2 text-left">{{ __('Level') }}</th>
                <th class="py-2 px-4 border-2 text-left">{{ __('Estimated Gains') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($multiLevelUsers as $user)
                @php
                    // Skip users who have no referrals and have already been listed as nested
                    $isExcluded = in_array($user->id, $nestedUserIds) && $user->referrals->count() == 0;
                @endphp

                @php
                    $level = null;
                    $gains = 0;

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

                @if (!$isExcluded)
                    <!-- Only show users who are not excluded -->

                    <tr class="even:bg-gray-100 odd:bg-white">
                        <td class="py-2 px-4 border-2">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-2">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-2">{{ $level }}</td>
                        <td class="py-2 px-4 border-2">{{ __('$') }}{{ number_format($gains, 2) }}</td>
                    </tr>

                    <!-- Nested Referrals Table (if any referrals) -->
                    @if ($user->referrals->count() > 0)
                        @php
                            // Track user IDs of referrals so we don't list them again in the main list
                            foreach ($user->referrals as $referral) {
                                $nestedUserIds[] = $referral->id;
                            }
                        @endphp
                        <tr>
                            <td colspan="4">
                                <div class="bg-green-100 rounded mb-10 p-4">
                                    <h4 class="font-bold p-2">{{ __('Referrals from') }}: {{ $user->name }}</h4>
                                    <table class="min-w-full table table-auto">
                                        <tbody>
                                            @foreach ($user->referrals as $referral)
                                                @php
                                                    // Calculate the level and corresponding gains for the referral
                                                    $currentLevel = $level + 1;
                                                    $gains_nested = 0;

                                                    if ($currentLevel == 2) {
                                                        $gains_nested = 250;
                                                    } elseif ($currentLevel == 3) {
                                                        $gains_nested = 150;
                                                    } elseif ($currentLevel == 4) {
                                                        $gains_nested = 100;
                                                    }
                                                @endphp
                                                <tr class="even:bg-gray-100 odd:bg-white">
                                                    <td class="py-2 px-4 border-0">{{ $referral->name }}</td>
                                                    <td class="py-2 px-4 border-0">{{ $referral->email }}</td>
                                                    <td class="py-2 px-4 border-0">{{ $currentLevel }}</td>
                                                    <td class="py-2 px-4 border-0">
                                                        {{ __('$') }}{{ number_format($gains_nested, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Display Total Estimated Gains below the table -->
    <div class="mt-0 text-right">
        <span class="font-bold text-lg">{{ __('Total Estimated Gains') }}:
            {{ __('$') }}{{ number_format($totalGains, 2) }}</span>
    </div>
</div>

<!-- Pagination Links for Multi-Level Referrals -->
<div class="mt-4">
    {{ $multiLevelUsers->links() }} <!-- Pagination for multi-level referrals -->
</div>
