.<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
            <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <br>
                   <!-- Button for Stock Page -->
                   <a href="{{ route('stock.index') }}" class="btn-stock-page">Go to Stock Page</a>
                
            </div>

            <!-- Add Three Boxes Below -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <!-- Box 1 -->
                <div class="bg-blue-100 border border-blue-300 rounded-lg p-6 shadow">
                    <h3 class="text-lg font-semibold text-blue-700">TOTAL VALUE OF STOCK</h3>

                    <!-- <p>Content for Box 1.</p> -->
                </div>

                <!-- Box 2 -->
                <div class="bg-green-100 border border-green-300 rounded-lg p-6 shadow">
                    <h3 class="text-lg font-semibold text-green-700">TOP PERFORMING STOCK</h3>
                    
    
    

                    <!-- <p>Content for Box 2.</p> -->
                </div>

                <!-- Box 3 -->
                <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-6 shadow">
                    <h3 class="text-lg font-semibold text-yellow-700">PORTFOLIO DISTRIBUTION OF STOCK</h3>
                    <!-- <p>Content for Box 3.</p> -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>