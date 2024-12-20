@extends('events.layout')
@section('content')


    @if ($errors->any())
        <div class=" bg-red-300 text-red-800 border border-red-600 rounded-lg p-2 mb-2 lg:w-[70%] w-[20%]">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<div class="grid lg:grid-cols-[20%,80%] lg:pl-6">

    <!-- Menú lateral -->
    <div class="mr-5">
        @include('components.sidebar-link')
    </div>

    <div>
        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="pl-20 grid grid-cols-[50%,50%] xxs:grid-cols-1 xxs:justify-items-center xxs:pl-4 xxs:ml-[-4%] mt-10">

                <div class="grid">

                    <h1 class="text-2xl font-bold text-white font-main xxs:my-4 xxs:ml-[28%]">Editar Evento</h1>

                    <div class="grid mb-2 lg:mt-10">
                        <label class="block mb-2 font-medium text-white font-main" for="title">Título</label>
                        <input class="secondary-color border border-gray-300 text-sm rounded-lg block w-80 p-2.5 text-white"
                            type="text" name="title" id="title" placeholder="Título del evento" value="{{ old('title', $event->title) }}" required>
                    </div>

                    <div class="grid mb-2">
                        <label class="block mb-2 font-medium text-white font-main" for="event_date">Fecha del Evento</label>
                        <input class="secondary-color border border-gray-300 text-sm rounded-lg block w-80 p-2.5 text-white"
                            type="date" name="event_date" id="event_date" placeholder="Fecha del evento" value="{{ old('event_date', $event->event_date) }}" required>
                    </div>

                    <div class="grid mb-2">
                        <label class="block mb-2 font-medium text-white font-main" for="description">Descripción</label>
                        <textarea
                            id="description"
                            class="secondary-color border border-gray-300 text-sm rounded-lg block w-80 p-2.5 text-white"
                            name="description" cols="30" rows="3"
                            placeholder="Descripción del evento">{{ old('description', $event->description) }}</textarea>
                    </div>

                </div>

                <!-- Sección 2 -->
                <div>

                    <div class="grid mb-2 lg:mt-10">
                        <label for="image" class="block mb-2 font-medium text-white font-main">Imagen</label>
                        <input type="file" accept=".jpg, .png" id="image"
                            class="text-white secondary-color border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[61%] p-2.5"
                            name="image">
                        
                    </div>
                    <div class="flex mt-6 xxs:justify-center">
                        <button type="submit"
                            class="font-main text-white w-[30%] secondary-color hover:bg-cyan-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-4 py-2 mr-2 xxs:text-xs text-center">Actualizar
                            Evento</button>

                        <a class="font-main text-white w-[30%] secondary-color hover:bg-cyan-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-4 py-2 xxs:py-5 xxs:text-sm text-center"
                            href="{{ route('events.index') }}">Atrás</a>

                    </div>

                </div>

            </div>
        </form>
    </div>
</div>
@endsection
