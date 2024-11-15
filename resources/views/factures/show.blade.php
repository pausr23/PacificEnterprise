@extends('dishes.layout')

@section('content')

<div class="grid lg:grid-cols-[20%,80%] lg:pl-6 pl-20">

    <!-- Menú lateral -->
    <div class="mr-5">
        @include('components.sidebar-link')
    </div>

    <div>

        <div class="flex items-start ml-20 mb-8">
            @if(session('success'))
                <div class="mt-6 alert alert-success bg-green-600 text-white p-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
        </div>


        <!-- Botón de Regreso -->
        <a class="font-main  xxs:ml-6 text-white w-[30%] secondary-color hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg px-5 py-2.5 text-center"
        href="{{ route('factures.history') }}">
            Atrás
        </a>

        <!-- Detalles de la Orden -->
        <div class="grid container py-8 rounded-xl secondary-color mx-auto lg:w-[30%] xxs:w-[90%] text-center text-white mt-5 xxs:my-6">
            <div class="mt-4 text-white">
                @foreach ([
                    'Número de órden' => $order->invoice_number,
                    'Método de pago' => $order->payment_method_name,
                    'Nota' => $order->note,
                    'Total' => $order->total
                ] as $label => $value)
                    <p class="text-lg mb-3 border-b border-gray-500 pb-2 mx-auto w-3/4">
                        <strong>{{ $label }}:</strong> {{ $value }}
                    </p>
                @endforeach
            </div>
        </div>


    </div>

</div>

@endsection
