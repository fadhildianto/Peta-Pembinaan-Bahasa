<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Menu -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex">
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.kegiatan.index') }}">
                            Kegiatan
                        </x-nav-link>

                        <x-nav-link href="{{ route('admin.lokasi.index') }}">
                            Lokasi
                        </x-nav-link>
                    @else
                        <x-nav-link href="{{ route('peta.index') }}">
                            Peta
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- RIGHT (USER MENU) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative">
                    <button onclick="document.getElementById('dropdown').classList.toggle('hidden')" 
                        class="px-3 py-2 bg-gray-200 rounded">
                        {{ Auth::user()->name }}
                    </button>

                    <div id="dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white border rounded shadow">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
                            Profile
                        </a>

                        <!-- LOGOUT FIX -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- MOBILE BUTTON -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2">
                    Menu
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="sm:hidden px-4 pb-4">

        @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="block py-2">Dashboard</a>
            <a href="{{ route('admin.kegiatan.index') }}" class="block py-2">Kegiatan</a>
            <a href="{{ route('admin.lokasi.index') }}" class="block py-2">Lokasi</a>
        @else
            <a href="{{ route('peta.index') }}" class="block py-2">Peta</a>
        @endif

        <div class="border-t mt-3 pt-3">
            <div class="mb-2 font-semibold">{{ Auth::user()->name }}</div>

            <a href="{{ route('profile.edit') }}" class="block py-2">Profile</a>

            <!-- LOGOUT MOBILE FIX -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left py-2">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
