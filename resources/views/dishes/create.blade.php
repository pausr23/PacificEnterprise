@extends('dishes.layout')

@section('content')
<div class="grid lg:grid-cols-[20%,80%] lg:pl-6 pl-20">

    <!-- Menú lateral -->
    <div class="mr-5">
        @include('components.sidebar-link')
    </div>

    <div class="lg:mt-8 mt-12">

            <div class="flex justify-center items-center mb-10 lg:-mr-0 sm:-mr-16">
                <div class="grid grid-cols-2 xxs:grid-cols-1 lg:gap-96 sm:gap-10 xxs:gap-4 xxs:mt-4">
                    <h1 class="text-2xl font-bold text-white font-main lg:ml-0 sm:ml-7 xxs:text-lg xxs:align-center xxs:mb-2">Añade un nuevo producto</h1>
                    <a class="font-main text-white w-[50%] secondary-color hover:bg-cyan-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5 text-center xxs:mt-4 xxs:justify-self-center" href="{{ route('dishes.index') }}">Atrás</a>
                </div>
            </div>

            @include('dishes.partials.error-messages')

            <form action="{{ route('dishes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="pl-20 grid grid-cols-[50%,50%] md:-ml-0 sm:-ml-6 xxs:grid-cols-1 xxs:justify-items-center xxs:gap-y-1 xxs:px-2">
                    @include('dishes.partials.dish-form')
                </div>

                <div class="flex justify-end xxs:justify-center xxs:ml-16 pr-20 mt-5">
                    <button type="submit" class="font-main text-white w-full lg:w-[9%] md:[12%] sm:w-[16%] max-w-[300px] secondary-color hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg px-5 py-2.5 md:pr-4 md:-pl-4 text-center lg:mr-60 md:mr-0 sm:mr-1 mb-10">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const subcategoriesData = @json($subcategories);

        function filterSubcategories() {
            const categoryId = document.getElementById('dishes_categories_id').value;
            const subcategorySelect = document.getElementById('subcategories_id');
            subcategorySelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';

            const filteredSubcategories = subcategoriesData.filter(subcategory => {
                return subcategory.dishes_categories_id == categoryId;
            });

            if (filteredSubcategories.length === 0) {
                subcategorySelect.innerHTML = '<option value="">No hay subcategorías disponibles</option>';
            } else {
                filteredSubcategories.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    subcategorySelect.appendChild(option);
                });
            }
        }

        // Agregar validación de precios
        document.querySelector('form').addEventListener('submit', function(event) {
            const purchasePrice = parseFloat(document.querySelector('input[name="purchase_price"]').value);
            const salePrice = parseFloat(document.querySelector('input[name="sale_price"]').value);

            if (salePrice < purchasePrice) {
                event.preventDefault();  // Evita el envío del formulario
                alert('El precio de venta no puede ser menor al precio de compra.');
            }
        });
    </script>
@endsection
