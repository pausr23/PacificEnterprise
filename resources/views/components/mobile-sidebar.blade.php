<img class="w-44 xxs:w-32 lg:hidden" src="https://i.ibb.co/KX69vv5/Pacific-Enterprise.png" alt="Pacific-Enterprise Logo">

<button class="ml-4 lg:hidden py-4 z-40 h-8 cursor-pointer block mb-3 items-center justify-start" onclick="toggleMenu()" aria-label="Abrir menú">    
    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <line x1="4" y1="6" x2="20" y2="6" />
        <line x1="4" y1="12" x2="20" y2="12" />
        <line x1="4" y1="18" x2="20" y2="18" />
    </svg>
</button>

<div id="mobile-sidebar-menu"
    class="fixed top-0 left-0 w-full h-screen transform -translate-x-full transition-transform duration-300 lg:hidden z-10 flex ">
    <div class="w-1/2 h-full bg-[#16161A] overflow-y-auto">
    <img class="mt-10 w-44 xxs:w-32 lg:hidden" src="https://i.ibb.co/KX69vv5/Pacific-Enterprise.png" alt="Pacific-Enterprise Logo">
        <button class="mr-4 mt-3 pl-2 flex items-center justify-start py-4 z-40 h-8 cursor-pointer" onclick="toggleMenu()" aria-label="Toggle menu">
        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
    <line x1="6" y1="6" x2="18" y2="18" />
    <line x1="6" y1="18" x2="18" y2="6" />
</svg>

    </svg>
        </button>

        <div class="pl-2 pt-6 text-white font-light text-sm font-main">
            <a class=" py-3 mb-4 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] hidden rounded-lg"
                href="{{ route('dashboard.principal') }}">Panel Principal</a>
            <a class="py-3 mb-4 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] hidden rounded-lg"
                href="{{ route('factures.ordering') }}">Punto de Venta</a>
            <a class="py-3 mb-4 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] hidden rounded-lg"
                href="{{ route('factures.order') }}">Órdenes</a>
            <a class="py-3 mb-4 pl-2 hidden rounded-lg hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035]"
                href="{{ route('factures.history') }}">Historial de Ventas</a>

            @if(Auth::check() && Auth::user()->job_titles_id == 1)
                <a class="py-3 mb-4 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                href="{{ route('dishes.index') }}">Productos</a>
                <a class="py-3 mb-4 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                href="{{ route('dishes.inventory') }}">Inventario</a>
                <a class="py-3 mb-4 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                href="{{ route('suppliers.index') }}">Proveedores</a>
                <a class="py-3 mb-3 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                    href="{{ route('events.index') }}">Eventos</a>
            @endif

            <a href="{{ route('admin.profile') }}" class="flex items-center cursor-pointer lg:m-2 sm:ml-0">
                <img class="w-12 h-12"
                    src="https://img.icons8.com/?size=100&id=492ILERveW8G&format=png&color=000000" alt="">
                <div class="lg:ml-2">
                    <p class="text-sm font-semibold ml-1">{{ auth()->user()->name }}</p>
                    <p class="text-xs">@ {{ auth()->user()->username }}</p>
                </div>
            </a>
            
        </div>
    </div>
    <div class="w-1/2 h-full bg-black opacity-50"></div>
    <script src="{{ asset('js/toggleMenu.js') }}"></script>
</div>
