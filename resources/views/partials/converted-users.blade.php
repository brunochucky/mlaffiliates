<div class="bg-white rounded my-6">
    <h3 class="font-bold">{{ __('Converted Users') }}</h3>

    @php
        $totalConvertedGains = 0; // Initialize the total gains for converted users
    @endphp

    <table class="min-w-full table table-auto border-2">
        <thead>
            <tr>
                <th class="py-2 px-4 border-2 text-left">{{ __('User') }}</th>
                <th class="py-2 px-4 border-2 text-left">{{ __('Email') }}</th>
                <th class="py-2 px-4 border-2 text-left">{{ __('Converted On') }}</th>
                <th class="py-2 px-4 border-2 text-left">{{ __('Estimated Gains') }}</th> <!-- Column for gains -->
            </tr>
        </thead>
        <tbody>
            @foreach ($convertedUsers as $user)
                @php
                    $level = null;
                    $gains = 0;

                    // Determine the level and corresponding gains
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

                    // Accumulate the total gains for converted users
                    $totalConvertedGains += $gains;
                @endphp
                <tr class="even:bg-gray-100 odd:bg-white">
                    <td class="py-2 px-4 border-2">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-2">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-2">{{ $user->updated_at->format('d-m-Y') }}</td>
                    <td class="py-2 px-4 border-2">{{ __('$') }}{{ number_format($gains, 2) }}</td>
                    <!-- Display the calculated gain -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Display Total Gains for Converted Users -->
    <div class="mt-4 text-right">
        <span class="font-bold text-lg">{{ __('Total Received') }}:
            {{ __('$') }}{{ number_format($totalConvertedGains, 2) }}</span>
    </div>

    <!-- Pagination for Converted Users -->
    <div class="mt-4">
        {{ $convertedUsers->links() }}
    </div>
</div>
