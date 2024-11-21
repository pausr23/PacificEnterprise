<div class="md:mr-5 hidden lg:block">
    <img class="2xl:mb-4 w-44 2xl:w-60 sm:ml-0" src="https://i.ibb.co/KX69vv5/Pacific-Enterprise.png"
        alt="Pacific-Enterprise">

        <div id="sidebar-menu" class="hidden lg:grid pl-2 pt-6 text-white font-light text-xs 2xl:text-sm font-main">
            <a class="py-3 mb-3 2xl:mb-5 pl-2  hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                href="{{ route('dashboard.principal') }}">Panel Principal</a>
            <a class="py-3 mb-3 2xl:mb-5 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                href="{{ route('factures.ordering') }}">Punto de Venta</a>
            <a class="py-3 mb-3 2xl:mb-5 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                href="{{ route('factures.order') }}">Órdenes</a>
            <a class="py-3 mb-3 2xl:mb-5 pl-2 block rounded-lg hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035]"
                href="{{ route('factures.history') }}">Historial de Ventas</a>
            <a class="py-3 mb-3 2xl:mb-5 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                href="{{ route('dishes.inventory') }}">Inventario</a>

            @if(Auth::check() && Auth::user()->job_titles_id == 1)
                <a class="py-3 mb-3 2xl:mb-5 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                    href="{{ route('dishes.index') }}">Productos</a>
                <a class="py-3 mb-3 2xl:mb-5 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                    href="{{ route('suppliers.index') }}">Proveedores</a>
                
            @endif
            <a class="py-3 mb-1 2xl:mb-3 pl-2 hover:bg-[#323035] focus:bg-[#323035] active:bg-[#323035] block rounded-lg"
                href="{{ route('events.index') }}">Eventos</a>

            <a href="{{ route('admin.profile') }}" class="flex items-center cursor-pointer lg:m-2 sm:ml-0 ">
                <img class="2xl:w-16 2xl:h-16 w-12 h-12"
                    src="https://img.icons8.com/?size=100&id=492ILERveW8G&format=png&color=000000" alt="">
                <div class="lg:ml-2">
                    <p class="2xl:text-base text-sm font-semibold ml-1">{{ auth()->user()->name }}</p>
                    <p class="2xl:text-sm text-xs">@ {{ auth()->user()->username }}</p>
                </div>
            </a>
        </div>
</div>
