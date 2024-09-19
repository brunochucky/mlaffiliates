<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-4">
                            <div class="card-header">
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    {{ __('Total Users') }}</h3>
                            </div>

                            <div class="card-body">
                                <p>{{ __('There are currently') }} <strong>{{ $totalUsers }}</strong>
                                    {{ __('users registered in the system') }}.</p>
                            </div>
                        </div>

                        <!-- Users Table with Pagination -->
                        <div class="card p-4 mt-4">
                            <div class="card-header">
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-3">
                                    {{ __('User List') }}</h3>
                            </div>

                            <div class="card-body">
                                <table class="min-w-full table table-auto border-2">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-2 text-left">{{ __('Name') }}</th>
                                            <th class="py-2 px-4 border-2 text-left">{{ __('Email') }}</th>
                                            <th class="py-2 px-4 border-2 text-left">{{ __('Conversion') }}</th>
                                            <th class="py-2 px-4 border-2 text-left">{{ __('Control') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr class="even:bg-gray-100 odd:bg-white">
                                                <td class="py-2 px-4 border-2">{{ $user->name }}</td>
                                                <td class="py-2 px-4 border-2">{{ $user->email }}</td>
                                                <td class="py-2 px-4 border-2">
                                                    @if ($user->conversion)
                                                        <span class="text-green-500">{{ __('Converted') }}</span>
                                                    @else
                                                        <span class="text-red-500">{{ __('Not Converted') }}</span>
                                                    @endif
                                                </td>
                                                <td class="py-2 px-4 border-2">
                                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900">
                                                        {{ __('View User') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Pagination Links -->
                                <div class="mt-4">
                                    {{ $users->links() }} <!-- Laravel pagination links -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
