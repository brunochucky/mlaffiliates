<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>

                <div class="card-body p-6">
                    <ul class="list-group list-unstyled">
                        <li class="list-group-item">
                            &#8226; <a href="{{ route('admin.users') }}">Manage Users</a>
                        </li>
                        <li class="list-group-item">
                            &#8226; <a href="{{ route('admin.settings') }}">Site Settings</a>
                        </li>
                        <li class="list-group-item">
                            &#8226; <a href="{{ route('admin.reports') }}">View Reports</a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>