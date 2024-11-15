@extends('events.layout')

@section('content')

<div class="grid lg:grid-cols-[20%,80%] lg:pl-6 pl-20">

    <!-- Menú lateral -->
    <div class="mr-5">
        @include('components.sidebar-link')
    </div>

    <div class="container w-full xxs:mt-8 ">
        <div class="w-[78vw] mb-4">
            <a class="my-6 xxs:mb-8 lg:ml-0 xxs:ml-[-3%] font-bold flex items-center justify-center h-12 w-48 xxs:w-60 secondary-color xxs:text-xs text-white rounded-xl text-center hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-100"
                href="{{ route('events.create') }}">
                Agregar un evento
            </a>
            <div class="grid lg:grid-cols-4 md:grid-cols-3 xxs:grid-cols-1 lg:ml-0  xxs:ml-[-2rem] xxs:gap-6 gap-4 w-full">
            @foreach($events as $event)
                <div class="border w-full min-h-[18rem] bg-[#2D2D2D] border-none rounded-[2rem]">
                    <div class="flex h-40 w-full overflow-hidden relative">
                        <img src="{{ $event->image_path }}" alt="{{ $event->title }}"
                            class="absolute top-0 left-0 w-full h-full object-cover rounded-t-[2rem]">
                    </div>
                    <div class="mx-[5%] my-[2%]">
                        <h2 class="font-bold text-white">{{ $event->title }}</h2>
                        <p class="font-bold text-[#B4C1C7]">Fecha: {{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}</p>
                        <a href="{{ route('events.show', $event->id) }}"
                        class="text-white font-bold mt-[1rem] w-full bg-[#7ECACA] rounded-[2rem] py-2 text-center block">Ver más</a>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
