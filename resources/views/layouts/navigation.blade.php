<!-- Sidebar -->
<div id="sidebar" class="w-64 bg-gray-800 fixed h-full flex-shrink-0 transition-all duration-300">
    <div class="p-4 flex items-center justify-between">
        <!-- Toggle icon and text/logo -->
        <div class="flex items-center">
            <i id="homeIcon" class="fas fa-home mr-3"></i>
            <a href="{{ route('dashboard') }}" id="brandName" class="text-xl font-bold">Beranda</a>
        </div>
        <button id="toggleSidebar" class="text-gray-300 focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-6 space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700 {{ request()->is('dashboard') ? 'bg-gray-700' : '' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>
            <span class="sidebar-text">Dashboard</span>
        </a>

        <!-- Dropdown Section -->
        <div x-data="{ open: {{ request()->is('master/*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-box mr-3"></i>
                <span class="sidebar-text">Master</span>
                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas ml-auto"></i>
            </button>
            <!-- Dropdown Content -->
            <div x-show="open" class="pl-8 space-y-2">
                @if(auth()->user()->level === 'admin') <!-- Only show this link for admin level -->
                    <a href="{{ route('users.index') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 {{ request()->is('master/users') ? 'bg-gray-700' : '' }}">
                        Data Account
                    </a> 
                @endif
                <a href="{{ route('posciu.indexciu.data') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 {{ request()->is('master/posciu/indexciu') ? 'bg-gray-700' : '' }}">
                    Data PosCIU
                </a>
                <a href="{{ route('posciu.indexresponse.data') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 {{ request()->is('master/posciu/response') ? 'bg-gray-700' : '' }}">
                    Data Response
                </a>
            </div>
        </div>

        <!-- Dropdown Section -->
        <div x-data="{ open: {{ request()->is('orders/*') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="w-full flex items-center py-2 px-4 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-upload mr-3"></i>
                <span class="sidebar-text">Orders</span>
                <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas ml-auto"></i>
            </button>
            <!-- Dropdown Content -->
            <div x-show="open" class="pl-8 space-y-2">
                <a href="{{ route('get.order.form') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 {{ request()->is('orders/get-order') ? 'bg-gray-700' : '' }}">
                    Posting Order to CIU
                </a>
                <a href="{{ route('void.order.form') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 {{ request()->is('orders/get-void') ? 'bg-gray-700' : '' }}">
                    Posting Order Void 
                </a>
               
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf
            <button type="submit" class="flex items-center w-full py-2 px-4 text-gray-300 hover:bg-gray-700">
                <i class="fas fa-sign-out-alt mr-3"></i>
                <span class="sidebar-text">Logout</span>
            </button>
        </form>
    </nav>
</div>
