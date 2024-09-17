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
                                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-3">Total Users</h3>
                            </div>

                            <div class="card-body">
                                <p>There are currently <strong>{{ $totalUsers }}</strong> users registered in the system.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>