@extends('dashboard.layout')

@section('content')

<div class="grid lg:grid-cols-[20%,80%] md:pl-6 pl-10">

    <div class="md:mr-5">
        @include('components.sidebar-link')
    </div>

    <div>
        <div class="md:grid md:grid-cols-2">
            <form class="2xl:my-2" action="{{ route('principal.show') }}" method="POST">
                @csrf
                <label class="font-main text-white mr-4 text-md lg:text-sm 2xl:text-lg" for="date">Selecciona una fecha:</label>
                <input class="rounded-lg 2xl:text-base text-base lg:text-sm mr-4 py-1 px-3 mt-2 2xl:py-2 secondary-color text-white" type="date" name="date" value="{{ old('date', $selectedDate) }}" required>
                <button class="transition duration-150 ease-out hover:ease-in bg-zinc-700 hover:-translate-y-1 hover:scale-110 hover:bg-zinc-500 secondary-color rounded-lg mt-2 text-white 2xl:text-base text-sm lg:px-3 px-4 py-3 lg:py-1 2xl:py-2 font-semibold" type="submit">Buscar por Día</button>
            </form>

            <div class="my-3 2xl:my-6 flex items-center">
                <label class="switch">
                    <input type="checkbox" id="toggleSwitch">
                    <span class="slider round w-14 md:ml-3"></span>
                
                </label>

                <span class="font-main text-white md:ml-9 2xl:text-lg text-sm">Mostrar Gráficos</span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4 xxs:mr-7">
            <div id="earningsView" class="secondary-color mb-4 md:mb-0 rounded-md p-8 w-[92%]">
                <img id="earningsImage" class="w-12 rounded-full bg-gray-300 p-2 mb-12" src="https://img.icons8.com/isometric-line/50/stack-of-money.png" alt="Ganancias">
                <p id="earningsLabel" class="text-white font-main 2xl:text-xs font-light mb-2">Ganancias del día</p>
                <p id="earningsTotal" class="text-white font-main text-3xl">₡{{ number_format($totalEarnings) }}</p>
            </div>

            <div class="mb-4 md:mb-0" id="earningsChartContainer" style="display: none;">
                <canvas id="earningsChart"></canvas>
            </div>

            <div id="ordersView" class="secondary-color rounded-md mb-4 md:mb-0 w-[92%] p-8">
                <img id="ordersImage" class="w-12 rounded-full bg-gray-300 p-2 mb-12" src="https://img.icons8.com/ios/50/1A1A1A/order-completed--v2.png" alt="Pedidos">
                <p id="ordersLabel" class="text-white font-main 2xl:text-xs font-light mb-2">Cantidad de pedidos</p>
                <p id="ordersTotal" class="text-white font-main text-3xl">{{ $invoiceCount }}</p>
            </div>

            <div id="ordersChartContainer" style="display: none;">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/charts.js') }}"></script>

        <div class="grid h-auto lg:grid-cols-[30%,65%] mt-10 2xl:mr-0 mr-16 md:mr-10">
            <div class="border grid lg:mr-8 text-white lg:mb-4 mb-8 border-gray-300 rounded-md p-5 lg:p-4 xxs:p-1">
                <div class="lg:flex lg:items-start lg:justify-between xxs:grid xxs:grid-cols-1">
                    <h1 class="font-main 2xl:text-lg text-lg lg:text-sm">Pedidos de hoy</h1>
                    <a class="underline opacity-60 lg:justify-self-end 2xl:text-lg text-base lg:text-sm" href="{{ route('factures.history') }}">Ver historial</a>
                </div>
                @foreach($recentInvoices as $invoice)
                    <div class="flex items-center mb-4 md:mb-0 mt-2">
                        <img class="secondary-color rounded-md ml-2 lg:w-10 xxs:w-8 p-1" src="https://img.icons8.com/sf-regular-filled/48/FFFFFF/bank-card-back-side.png" alt="card">
                        <div class="grid">
                            <p class="ml-2 2xl:text-lg text-xs">Orden #{{ $invoice->invoice_number }}</p>
                            <p class="ml-2 2xl:text-base text-sm">${{ $invoice->total }}</p>
                        </div>
                    </div>
                @endforeach

                @if($recentInvoices->isEmpty())
                    <p class="font-semibold text-base lg:text-sm 2xl:text-base">No hay pedidos recientes.</p>
                @endif
            </div>

            <div class="swiper" style="overflow: hidden; position: relative; max-width: 100%; margin: 0 auto;">
                <div class="mb-4 swiper-wrapper">
                    @foreach($events as $event)
                        <div class="swiper-slide h-auto" style="width: auto; flex: 0 0 auto;">
                            <a href="{{ route('events.show', $event->id) }}" class="block">
                                <div class="shadow-md rounded-[2rem] overflow-hidden relative mb-6 md:mb-0">
                                    <img src="{{ $event->image_path }}" alt="{{ $event->title }}" class="w-full xxs:mb-6 mb-0 xxs:h-[50vw] lg:h-[16vw] 2xl:h-[20vw] object-cover">
                                    <div class="absolute inset-0 flex flex-col justify-end p-6 bg-gradient-to-t from-black/70 to-transparent">
                                        <h2 class="text-white md:text-3xl text-2xl font-bold mb-2">{{ $event->title }}</h2>
                                        <p class="text-white md:mb-4">Fecha: <span class="ml-2">{{ $event->event_date }}</span></p>
                                        <p class="text-white">{{ $event->description }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <button class="swiper-button-next swiper-button-white" style="position: absolute; top: 50%; transform: translateY(-50%); right: 10px; z-index: 10; cursor: pointer;"></button>
                <button class="swiper-button-prev swiper-button-white" style="position: absolute; top: 50%; transform: translateY(-50%); left: 10px; z-index: 10; cursor: pointer;"></button>
                <div class="swiper-pagination swiper-pagination-white"></div>
            </div>
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
    </div>
        @endsection
