    <header class="flex items-center justify-between p-6 bg-white shadow-md fixed top-0 left-0 right-0 z-50">

        <div class="auth flex gap-6 items-center justify-between">
            @guest
                <button
                    class="px-4 py-2 bg-indigo-600 rounded-lg shadow-lg hover:bg-indigo-700 transition-colors duration-300">
                    <a href="{{ route('auth.register') }}" class="text-white hover:text-indigo-200">انشاء حساب</a>
                </button>
                <button class="px-4 py-2  bg-white rounded-lg shadow-lg hover:bg-indigo-200 transition-colors duration-300">
                    <a href="{{ route('auth.login') }}" class="text-indigo-600 hover:text-indigo-700"> تسجيل دخول</a>
                </button>
            @endguest
                @auth
                    <div class="flex items-center gap-4">
                        <button class= "bg-red-400 px-4 py-2 rounded-lg shadow-lg hover:bg-red-500 transition-colors duration-300">
                            <a href="{{ route('logout') }}" class="text-white hover:text-gray-200">
                                تسجيل خروج
                            </a>
                        </button>
                        <img src="{{ Storage::url(auth()->user()->image) }}" class="w-10 h-10 rounded-full object-cover border-2 border-indigo-100">
                    </div>
                @endauth



        </div>
        <div class="logo flex items-center gap-2">
            <a href="{{ route('student.home') }}" class="flex items-center gap-2">
                <span class="text-xl font-bold text-indigo-600">E Learning Platform </span>
                <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo" class="w-12 h-12 object-contain">
            </a>
        </div>
    </header>
