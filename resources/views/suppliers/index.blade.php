@extends('suppliers.layout')

@section('content')

<div class="grid lg:grid-cols-[20%,80%] pl-10 lg:pl-6">
    
    <div class="mr-5">
        @include('components.sidebar-link')
    </div>

    <div>
        <div class="grid grid-cols-[70%,20%] mt-8 lg:mt-0 lg:ml-0 xxs:ml-[9%] xxs:grid-cols-1 xxs:gap-y-4">
            @include('components.search-suppliersIndex', ['action' => route('suppliers.index')])

            <div class="content-end xxs:content-center">
                <a href="{{ route('suppliers.create') }}" class="font-bold flex items-center justify-center h-12 lg:w-48 sm:w-40 xxs:w-60 lg:text-base sm:text-xs xxs:text-xs secondary-color text-white rounded-xl text-center hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-100">
                    Agregar un proveedor
                </a>
            </div>
        </div>

        <div class="grid mt-10 lg:grid-cols-3 md:grid-cols-2 xxs:w-94 xxs:mr-10 xxs:mb-2">
            @if($suppliers->isEmpty())
                <div class="col-span-3 text-center mt-10">
                    <p class="text-white font-main text-lg">No hay registro de proveedores.</p>
                </div>
            @else
                @foreach ($suppliers as $supplier)
                    @include('components.card-suppliersIndex', ['supplier' => $supplier])
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection
