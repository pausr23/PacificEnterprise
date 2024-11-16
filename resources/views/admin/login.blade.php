@extends('admin.layout')

@section('content')
<!-- Main Container -->
<div class="h-screen bg-gradient-to-r from-purple-800 via-purple-600 to-purple-400 relative overflow-hidden">

    <div class="grid md:grid-cols-2 h-screen place-items-center">

        <!-- Left Image Section -->
        <img class="mx-auto w-[65%] hidden md:block transition-transform duration-500 ease-in-out transform hover:scale-105"
            src="https://i.ibb.co/KX69vv5/Pacific-Enterprise.png" alt="Pacific-Enterprise" />

        <!-- Right Login Section -->
        <div class="md:grid place-items-center secondary-color w-full h-full px-4">

            <!-- Mobile Image -->
            <img class="mx-auto my-10 block md:hidden w-[50%] transition-transform duration-500 ease-in-out transform hover:scale-110 mb-24"
                src="https://i.ibb.co/KX69vv5/Pacific-Enterprise.png" alt="Pacific-Enterprise" />

            <div>
                <!-- Login Header -->
                <h1
                    class="text-white text-center font-main font-bold text-2xl sm:text-4xl tracking-wide mb-8 animate-bounce">
                    Loginnnnnnn
                </h1>

                <!-- Login Form -->
                <form class="grid gap-6" action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf

                    <!-- Username Input -->
                    <div class="relative">
                        <input
                            class="w-full pl-10 text-base sm:text-lg text-[#CDA0CB] bg-transparent border-b-2 border-[#CDA0CB] placeholder:text-[#bc96ba] focus:outline-none focus:border-purple-400 focus:scale-105 transition-transform duration-300"
                            placeholder="Username" type="text" name="username" required>
                        <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 w-6 h-6 text-purple-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 21v-2a4 4 0 00-8 0v2M12 11a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </div>

                    <!-- Password Input -->
                    <div class="relative">
                        <input
                            class="w-full pl-10 text-base sm:text-lg text-[#CDA0CB] bg-transparent border-b-2 border-[#CDA0CB] placeholder:text-[#bc96ba] focus:outline-none focus:border-purple-400 focus:scale-105 transition-transform duration-300"
                            placeholder="Password" type="password" name="password" required>
                        <!-- Candado SVG -->
                        <svg class="absolute left-2 top-1/2 transform -translate-y-1/2 w-6 h-6 text-purple-400"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2h-1V7a5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3v3H9V7a3 3 0 0 1 3-3zm-6 8h12v8H6v-8z" />
                        </svg>
                    </div>


                    <!-- Submit Button -->
                    <button type="submit"
                        class="text-center bg-[#CDA0CB] hover:bg-[#bc96ba] active:bg-[#b080a8] transition-all duration-300 w-full text-sm sm:text-lg font-main font-semibold py-2 rounded-2xl shadow-md hover:shadow-lg transform hover:scale-105">
                        Login
                    </button>
                </form>

                <!-- Error Message -->
                @if ($errors->has('login_error'))
                    <div class="text-red-500 mt-4 text-center">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif
            </div>

            <!-- Loading Spinner -->
            <div id="spinner" class="hidden justify-center items-center mt-4">
                <div class="w-8 h-8 border-4 border-t-transparent border-purple-400 rounded-full animate-spin"></div>
            </div>
        </div>
    </div>
</div>

<!-- Spinner Script -->
<script>
    document.querySelector('form').addEventListener('submit', function () {
        document.getElementById('spinner').classList.remove('hidden');
    });
</script>
@endsection