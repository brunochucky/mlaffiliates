<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full table-auto border-2">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-2 text-left">{{ __('Field') }}</th>
                                <th class="py-2 px-4 border-2 text-left">{{ __('Value') }}</th>
                                <th class="py-2 px-4 border-2 text-left">{{ __('Control') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-2">{{ __('Name') }}</td>
                                <td class="py-2 px-4 border-2">{{ $user->name }}</td>
                                <td class="py-2 px-4 border-2"></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-2">{{ __('Email') }}</td>
                                <td class="py-2 px-4 border-2">{{ $user->email }}</td>
                                <td class="py-2 px-4 border-2"></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-2">{{ __('Cellphone') }}</td>
                                <td class="py-2 px-4 border-2">{{ $user->cellphone ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border-2"></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-2">{{ __('Affiliate Code') }}</td>
                                <td class="py-2 px-4 border-2">{{ $user->affiliate_code ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border-2"></td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-2">{{ __('Conversion Status') }}</td>
                                <td class="py-2 px-4 border-2">
                                    @if ($user->conversion)
                                    <span class="text-green-500">{{ __('Converted') }}</span>
                                    @else
                                    <span class="text-red-500">{{ __('Not Converted') }}</span>
                                    @endif
                                </td>
                                <td class="py-2 px-4 border-2">
                                    @if ($user->conversion)
                                    <!-- Undo Convert link if the user is converted -->
                                    <a href="{{ route('admin.users.undoConvert', $user->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        {{ __('Undo') }}
                                    </a>
                                    @else
                                    <!-- Convert User link if the user is not converted -->
                                    <a href="{{ route('admin.users.convert', $user->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        {{ __('Convert') }}
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('admin.users') }}"
                            class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                            {{ __('Back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>