@extends('dishes.layout')

@section('content')

    <div class="grid grid-cols-[20%,60%] xxs:grid-cols-1 gap-16">
        <img class="w-80 ml-10 mb-10 xxs:w-60 xxs:ml-1 xxs:-mb-6 xxs:hidden" src="https://i.ibb.co/KX69vv5/Pacific-Enterprise.png" alt="Pacific-Enterprise" border="0">
        
        <div class="content-end mb-14 xxs:mt-4">
            <a class="ml-10 font-bold flex items-center justify-center xxs:ml-4 py-2 w-24 secondary-color text-white rounded-xl text-center hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-100" href="{{ route('admin.profile') }}">
                Atrás
            </a>
        </div>
    </div>

    @if(session('warning'))
        <div class="bg-yellow-200 text-black font-semibold p-4 rounded-lg mb-6 w-[50%] mx-auto text-center">
            {{ session('warning') }}
        </div>
    @endif

    <div>
        <div class="grid grid-cols-2">
            <div class="grid content-end">
                <a class="mx-auto xxs:ml-4 font-bold flex items-center justify-center py-3 w-60 secondary-color text-white rounded-xl text-center hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-100 xxs:text-sm" href="{{ route('information.create') }}">
                    Agregar Información
                </a>
            </div>
        </div>

        <div class="md:w-[70%] w-[95%] mx-auto grid gap-16 md:gap-4 xxs:gap-0">
            <div class="py-10 rounded-lg">
                <table class="w-full rounded-lg">
                    <thead class="rounded-lg text-white font-main font-bold secondary-color">
                        <tr>
                            <th scope="col" class="lg:px-12 sm:px-3 py-3 md:px-3 xxs:px-0.5 xxs:text-xs">Nombre</th>
                            <th scope="col" class="lg:px-12 sm:px-3 py-3 md:px-3 xxs:px-0.5 xxs:text-xs hidden md:block">Correo</th>
                            <th scope="col" class="lg:px-12 sm:px-3 py-3 md:px-3 xxs:px-0.5 xxs:text-xs">Número</th>
                            <th scope="col" class="lg:px-12 sm:px-3 py-3 md:px-3 xxs:px-0.5 xxs:text-xs">Dirección</th>
                            <th scope="col" class="lg:px-12 sm:px-3 py-3 md:px-3 xxs:px-0.5 xxs:text-xs hidden md:block">Nota</th>
                            <th scope="col" class="lg:px-12 sm:px-3 py-3 md:px-3 xxs:px-0.5 xxs:text-xs">Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($information as $info)
                        <tr class="border-b text-white text-center border-neutral-200 dark:border-white/10 md:px-3 xxs:px-0.5 xxs:text-xs">
                            <td>{{ $info->name }}</td>
                            <td class="hidden md:block">{{ $info->email }}</td>
                            <td>
                                {{ substr($info->number, 0, 4) }}-{{ substr($info->number, 4) }}
                            </td>
                            <td>{{ $info->address }}</td>
                            <td class="hidden py-6 md:block">{{ $info->note }}</td>
                            <td class="py-6">
                                <a class="bg-cyan-200 rounded-lg text-black font-semibold px-4 py-2 me-2 hover:bg-cyan-500 focus:ring-4 focus:outline-none focus:ring-cyan-200 xxs:w-[2.8rem] xxs:text-[0.6rem] xxs:block xxs:px-0 lg:text-base sm:text-sm sm:block lg:inline" href="{{ route('information.show', $info->id) }}">
                                    Ver más
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
