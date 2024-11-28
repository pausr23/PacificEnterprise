@extends('suppliers.layout')

@section('content')
<div class="grid lg:grid-cols-[20%,80%] lg:pl-6">

    <!-- Menú lateral -->
    <div class="mr-5">
        @include('components.sidebar-link')
    </div>

    <div class="container lg:mt-8 mt-12">
 
        <div class="flex justify-center items-center mb-10">
            <div class="grid grid-cols-2 xxs:grid-cols-1 xxs:gap-1 gap-64 xxs:mt-4">
                <h1 class="text-2xl xxs:text-lg font-bold text-white font-main xxs:align-center">
                    Edita la información del proveedor
                </h1>
                <a class="font-main text-white lg:w-[30%] md:w-[50%] lg:h-auto md:h-auto secondary-color hover:bg-cyan-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 xxs:mt-4 text-center"
                href="{{ route('suppliers.index') }}">Atrás</a>
            </div>
        </div>

        {{-- Mostrar los mensajes de error --}}
        @if ($errors->any())
            <div class="bg-red-300 text-red-800 border border-red-600 rounded-lg p-2 mb-2 lg:w-[70%] w-[20%]" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- First Column --}}
            <div class="grid">
                @include('components.input-suppliersEdit', [
                    'label' => 'Nombre',
                    'name' => 'name',
                    'value' => old('name', $supplier->name),  
                    'placeholder' => 'Nombre del proveedor'
                ])

            </div>

            <div class="flex lg:justify-end xxs:justify-center mt-5 pr-20 xxs:px-3 xxs:ml-1">
                <button type="submit" class="font-main text-white w-full lg:w-[12%] md:w-full sm:w-full max-w-[300px] secondary-color hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg px-5 py-2.5 md:pr-4 md:-pl-4 text-center lg:mr-60 md:mr-0 sm:mr-1 mb-10">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
