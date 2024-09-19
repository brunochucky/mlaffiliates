<!-- Partial for Direct Referrals (Level 1) -->
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
                    <td class="py-2 px-4 border-2">{{ $user->referrals_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination Links for Direct Referrals -->
<div class="mt-4">
    {{ $users->links() }}
</div>
