@extends('dishes.layout')

@section('content')

<div class="grid lg:grid-cols-[20%,80%] md:pl-6 pl-12">

    
    <!-- Menú lateral -->
    <div class="mr-5">
        @include('components.sidebar-link')
    </div>

    <div class="grid lg:grid-cols-[65%,30%] lg:ml-0 md:ml-[3%] xxs:grid-cols-1">

        <div>
            <div class="grid lg:grid-cols-[65%,30%] lg:gap-x-4">
                <input class="pl-4 mt-6 lg:mt-0 secondary-color rounded text-sm font-light h-8 text-left text-white 2xl:w-[95%] w-[87%]"
                    id="dish" type="text" name="dish" placeholder="Nombre de item" oninput="filterDishes()" />
                    <button id="show-all-btn" class="text-white text-sm 2xl:text-base transition duration-150 ease-out hover:ease-in font-semibold p-2 lg:p-0 mt-8 lg:mt-0 lg:place-self-end lg:mr-6 rounded-md w-48 2xl:w-56 lg:h-8 bg-zinc-700 hover:-translate-y-1 hover:scale-110 hover:bg-zinc-500">
                        Mostrar todos los productos
                    </button>
            </div>

            <div class="grid grid-cols-2 gap-3 2xl:gap-y-3 gap-y-3 lg:gap-y-0 mr-12 mt-8">
                @foreach($categories as $category)
                    <div class="bg-[#FFFF9F] 2xl:h-full lg:h-[80%] h-full rounded-md category-button transition-colors duration-200 hover:bg-[#CDA0CB] focus:bg-[#CDA0CB] cursor-pointer"
                        tabindex="0" data-id="{{ $category->id }}" role="button">
                        <img class="2xl:mb-4 mb-2 ml-5 mt-3 lg:w-6 w-8 2xl:w-8" width="50" height="50"
                            src="https://img.icons8.com/ios-filled/50/street-food--v2.png" alt="street-food--v2" />
                        <h1 class="font-bold 2xl:text-base text-base lg:text-sm ml-5">{{ $category->name }}</h1>
                        <h2 class="text-xs ml-5 mb-7 2xl:mb-3">{{ $category->registeredDishes->count() }} productos</h2>
                    </div>
                @endforeach
            </div>

            <select id="subcategory-select"
                class="text-white font-main my-8 font-semibold 2xl:mt-5 mt-5 lg:mt-0 text-xl bg-transparent rounded focus:outline-none">
                <option value="" disabled selected>Subcategoría</option>
            </select>

            <div id="dishes-list" class="grid xxs:grid-cols-2 grid-cols-3 lg:grid-cols-4 gap-x-2 2xl:gap-3 mr-12 md:my-auto products-container h-[30vh] 2xl:h-[49vh] overflow-y-auto">
                @foreach($dishes as $dish)
                    <div class="product-item text-white 2xl:h-full h-[90%] font-main secondary-color rounded-lg pl-3"
                        data-dish-id="{{ $dish->id }}"
                        data-category-id="{{ $dish->dishes_categories_id }}"
                        data-subcategory-id="{{ $dish->subcategories_id }}"
                        data-dish-price="{{ $dish->sale_price }}"
                        data-dish-title="{{ strtolower($dish->title) }}"
                        data-max-units="{{ $dish->units }}"
                        style="border-left: 6px solid #8FC08B;">
                        <div class="flex flex-col h-full 2xl:justify-between">
                            <div>
                                <p class="2xl:text-xs text-[0.6rem] font-extralight mt-2 mb-3 flex items-center">
                                    {{ $dish->subcategory->name }}
                                    <span id="units-{{ $dish->id }}" class="text-gray-300 2xl:ml-2">(Unidades: {{ $dish->units }})</span>
                                </p>
                                <h2 class="font-bold text-xs 2xl:text-sm mb-1">{{ $dish->title }}</h2>
                                <p class="font-extralight text-xs 2xl:text-sm mb-3">₡{{ number_format($dish->sale_price, 2) }}</p>
                            </div>

                            <div class="flex items-center 2xl:mb-4 mb-6">
                                <button id="add-btn-{{ $dish->id }}"
                                    class="rounded w-6 border-2 border-white hover:scale-105 focus:outline-none inline-flex items-center justify-center"
                                    onclick="addProduct('{{ $dish->id }}')">
                                    <img class="2xl:w-full 2xl:h-full w-[85%]" width="50" height="50"
                                        src="https://img.icons8.com/ios-filled/50/FFFFFF/plus-math.png" alt="plus-math" />
                                </button>

                                <span id="quantity-{{ $dish->id }}" class="text-xs mx-2 font-light">0</span>

                                <button id="remove-btn-{{ $dish->id }}"
                                    class="rounded w-6 border-2 border-white hover:scale-105 focus:outline-none inline-flex items-center justify-center"
                                    onclick="removeProduct('{{ $dish->id }}')" disabled>
                                    <img class="2xl:w-full 2xl:h-full w-[85%]" width="50" height="50"
                                        src="https://img.icons8.com/ios-filled/50/FFFFFF/minus-math.png" alt="minus-math" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <script src="{{ asset('js/filterDishes.js') }}"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const categories = @json($categories);
                    const subcategorySelect = document.getElementById('subcategory-select');
                    const products = document.querySelectorAll('.product-item');
                    const showAllButton = document.getElementById('show-all-btn');


                    const initialBorderColor = '#8FC08B';
                    const colors = ['#FFFF9F', '#CDA0CB', '#B0E1DF', '#F19DB4'];

                    document.querySelectorAll('.category-button').forEach(function (categoryDiv, index) {
                        const color = colors[index % colors.length];
                        categoryDiv.style.backgroundColor = color;

                        categoryDiv.addEventListener('click', function () {
                            const categoryId = this.getAttribute('data-id');
                            const selectedCategory = categories.find(category => category.id == categoryId);

                            updateSubcategoryMenu(selectedCategory);

                            applyBorderColorToProducts(color);

                            filterProductsByCategory(categoryId);
                        });
                    });

                    showAllButton.addEventListener('click', function () {
                        subcategorySelect.value = '';
                        products.forEach(function (product) {
                            product.style.display = 'block';
                        });

                        applyBorderColorToProducts(initialBorderColor);
                    });

                    function applyBorderColorToProducts(color) {
                        products.forEach(function (product) {
                            product.style.borderLeft = `6px solid ${color}`;
                        });
                    }

                    subcategorySelect.addEventListener('change', function () {
                        const selectedSubcategoryId = this.value;
                        filterProductsBySubcategory(selectedSubcategoryId);
                    });

                    function updateSubcategoryMenu(selectedCategory) {
                        subcategorySelect.innerHTML = '';

                        if (selectedCategory) {
                            const categoryOption = document.createElement('option');
                            categoryOption.value = "";
                            categoryOption.textContent = selectedCategory.name;
                            categoryOption.disabled = true;
                            categoryOption.selected = true;
                            subcategorySelect.appendChild(categoryOption);

                            if (selectedCategory.subcategories.length > 0) {
                                selectedCategory.subcategories.forEach(function (subcategory) {
                                    const option = document.createElement('option');
                                    option.value = subcategory.id;
                                    option.textContent = subcategory.name;
                                    subcategorySelect.appendChild(option);
                                });
                            } else {
                                const noSubcategoriesOption = document.createElement('option');
                                noSubcategoriesOption.value = "";
                                noSubcategoriesOption.textContent = "No hay subcategorías disponibles";
                                subcategorySelect.appendChild(noSubcategoriesOption);
                            }
                        } else {
                            const defaultOption = document.createElement('option');
                            defaultOption.value = "";
                            defaultOption.textContent = "Subcategoría";
                            defaultOption.disabled = true;
                            defaultOption.selected = true;
                            subcategorySelect.appendChild(defaultOption);
                        }
                    }

                    function applyBorderColorToProducts(color) {
                        products.forEach(function (product) {
                            product.style.borderLeft = `6px solid ${color}`;
                        });
                    }

                    function filterProductsByCategory(categoryId) {
                        products.forEach(function (product) {
                            const productCategoryId = product.getAttribute('data-category-id');
                            if (productCategoryId === categoryId) {
                                product.style.display = 'block';
                            } else {
                                product.style.display = 'none';
                            }
                        });

                        subcategorySelect.value = '';
                    }

                    function filterProductsBySubcategory(subcategoryId) {
                        products.forEach(function (product) {
                            const productSubcategoryId = product.getAttribute('data-subcategory-id');
                            if (subcategoryId === '' || productSubcategoryId === subcategoryId) {
                                product.style.display = 'block';
                            } else {
                                product.style.display = 'none';
                            }
                        });
                    }
                });
            </script>

        <script>
            const addedProducts = {};

            function addProduct(dishId) {
                const quantityElement = document.querySelector(`#quantity-${dishId}`);
                const unitsElement = document.querySelector(`#units-${dishId}`);
                const addButton = document.querySelector(`#add-btn-${dishId}`);
                const removeButton = document.querySelector(`#remove-btn-${dishId}`);
                const maxUnits = parseInt(document.querySelector(`.product-item[data-dish-id="${dishId}"]`).getAttribute('data-max-units')) || 0;

                let currentAdded = addedProducts[dishId] || 0;
                let availableUnits = maxUnits - currentAdded;

                if (maxUnits === 0) {
                    alert("Este producto no tiene unidades disponibles.");
                    addButton.disabled = true;
                    return;
                }

                if (availableUnits <= 0) {
                    alert("No hay más unidades disponibles para agregar.");
                    addButton.disabled = true;
                    return;
                }
                currentAdded += 1;
                addedProducts[dishId] = currentAdded;

                quantityElement.textContent = currentAdded;
                unitsElement.textContent = `(Unidades: ${maxUnits - currentAdded})`;

                removeButton.disabled = false;

                if (currentAdded >= maxUnits) {
                    addButton.disabled = true;
                }
            }

            function removeProduct(dishId) {
                const quantityElement = document.querySelector(`#quantity-${dishId}`);
                const unitsElement = document.querySelector(`#units-${dishId}`);
                const addButton = document.querySelector(`#add-btn-${dishId}`);
                const removeButton = document.querySelector(`#remove-btn-${dishId}`);
                const maxUnits = parseInt(document.querySelector(`.product-item[data-dish-id="${dishId}"]`).getAttribute('data-max-units')) || 0;

                let currentAdded = addedProducts[dishId] || 0;

                if (currentAdded > 0) {
                    currentAdded -= 1;
                    addedProducts[dishId] = currentAdded;


                    quantityElement.textContent = currentAdded;
                    unitsElement.textContent = `(Unidades: ${maxUnits - currentAdded})`;

                    addButton.disabled = false;

                    if (currentAdded === 0) {
                        removeButton.disabled = true;
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                const products = document.querySelectorAll('.product-item');
                products.forEach(product => {
                    const dishId = product.getAttribute('data-dish-id');
                    const addButton = document.querySelector(`#add-btn-${dishId}`);
                    const maxUnits = parseInt(product.getAttribute('data-max-units')) || 0;

                    if (maxUnits === 0) {
                        addButton.disabled = true;
                    }
                });
            });
        </script>

        </div>

        <div>
            <div class="secondary-color lg:mt-0 lg:mb-0 mt-10 mb-8 lg:mx-0 lg:w-full w-[90%] overflow-hidden h-[90vh] flex flex-col lg:my-0 lg:ml-0 md:ml-4 xxs:my-8 md:my-8">
                <h2 class="text-white font-main font-semibold text-lg pt-4 text-center">Facturación</h2>
                <div id="billing-list" class="grid products-container gap-4 mt-5 mb-5 overflow-y-auto max-h-[60vh] px-4"></div>
                <hr class="border-b-1 border-white mt-2" />

                <div class="grid grid-cols-2">
                    <h2 class="text-white font-main font-semibold 2xl:text-lg ml-5 mt-5">Total</h2>
                    <h3 id="total-amount" class="text-white text-xs font-semibold ml-5 mt-6 text-center font-main">₡0
                    </h3>
                </div>

                <form method="POST" action="{{ route('factures.invoice') }}" id="order-form">
                    @csrf
                    <input type="hidden" name="addedItems" id="addedItemsInput" value='[]'>
                    <input type="hidden" name="payment_method_id" id="paymentMethodInput" value="">

                    <div class="grid grid-cols-1 mb-2">
                        <label class="text-gray-400 text-xs 2xl:text-sm ml-5 font-main my-3 2xl:my-5 ">Notas:</label>
                        <textarea class="secondary-color border border-gray-300 2xl:text-sm text-xs rounded-lg block p-2 text-white mx-auto w-[80%] 2xl:w-[90%] h-12 2xl:h-20"
                        name="note"
                        placeholder="Notas adicionales"></textarea>
                    </div>

                    <h2 class="text-gray-400 text-xs 2xl:text-sm ml-5 font-main mt-5">Método de Pago:</h2>
                    <div class="flex justify-around p-4">
                        <div class="group">
                            <button type="button"
                                class="payment-method border border-white rounded-lg transition-colors duration-200 hover:border-white-500 focus:border-green-500 p-2"
                                data-value="1">
                                <img class="2xl:w-8 w-7" src="https://img.icons8.com/sf-black-filled/64/FFFFFF/banknotes.png"
                                    alt="banknotes" />
                            </button>
                            <h2 class="text-white text-xs text-center mt-1 font-main">Efectivo</h2>
                        </div>

                        <div class="group">
                            <button type="button"
                                class="payment-method border border-white rounded-lg transition-colors duration-200 hover:border-white-500 focus:border-green-500 p-2"
                                data-value="2">
                                <img class="2xl:w-8 w-7" src="https://img.icons8.com/ios-filled/50/FFFFFF/credit-card-front.png"
                                    alt="credit-card-front" />
                            </button>
                            <h2 class="text-white text-xs text-center mt-1 font-main">Tarjeta</h2>
                        </div>

                        <div class="group">
                            <button type="button"
                                class="payment-method border border-white rounded-lg transition-colors duration-200 hover:border-white-500 focus:border-green-500 p-2"
                                data-value="3">
                                <img class="2xl:w-8 w-7" src="https://img.icons8.com/ios-filled/50/FFFFFF/mobile-payment.png"
                                    alt="mobile-payment" />
                            </button>
                            <h2 class="text-white text-xs text-center mt-1 font-main">Sinpe</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 mt-2 2xl:mt-5" id="payment-amount-section" style="display: none;">
                        <label class="text-gray-400 text-xs 2xl:text-sm ml-5 2xl:mt-2 font-main">Monto recibido:</label>
                        <input id="customer-payment" type="number"
                            class="secondary-color border border-gray-300 text-xs 2xl:text-sm rounded-lg block p-1 2xl:p-2 text-white w-[80%] 2xl:w-36"
                            placeholder="Monto" />
                    </div>

                    <div class="grid grid-cols-2 2xl:mt-5 mt-2" id="change-section" style="display: none;">
                        <label class="text-gray-400 text-xs 2xl:text-sm ml-5 mt-2 font-main">Cambio:</label>
                        <h3 id="change-amount" class="text-white text-xs font-semibold ml-5 mt-2 text-center font-main">
                            ₡0</h3>
                    </div>

                    <div id="voucher-section" class="grid grid-cols-1 mb-2" style="display: none;">
                        <label id="voucher-label" for="voucher-number" class="text-gray-400 text-xs 2xl:text-sm ml-8 font-main ">Número de Comprobante:</label>
                        <input type="text" id="voucher-number" name="voucher_number"
                            class="secondary-color border border-gray-300 2xl:text-sm text-xs rounded-lg my-2 2xl:my-5 block p-1 2xl:p-2 text-white w-[80%] 2xl:w-36 mx-auto"
                            placeholder="Número" />
                    </div>

                    <div class="flex justify-center">
                        <button type="submit"
                            class="bg-white rounded-md w-56 h-8 mt-5 mb-5 hover:bg-gray-200 active:bg-gray-300 transition duration-150">
                            <h1 class="font-main font-semibold text-md">Facturar</h1>
                        </button>
                    </div>
                </form>

                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let billing = {};


                    function updateChange() {
                        const total = parseFloat(document.getElementById('total-amount').innerText.replace('₡', '')) || 0;
                        const payment = parseFloat(document.getElementById('customer-payment').value) || 0;
                        const change = payment - total;

                        const changeElement = document.getElementById('change-amount');
                        changeElement.innerText = `₡${change.toFixed(2)}`;

                        if (change < 0) {
                            changeElement.innerText = `₡0`;
                        }
                    }

                    document.getElementById('customer-payment').addEventListener('input', updateChange);

                    function updateQuantity(dishId, change) {
                        if (!billing[dishId]) {
                            const productElement = document.querySelector(`.product-item[data-dish-id='${dishId}']`);
                            if (productElement) {
                                const price = parseFloat(productElement.getAttribute('data-dish-price')) || 0;

                                billing[dishId] = {
                                    quantity: 0,
                                    title: productElement.querySelector('h2').innerText,
                                    price: price
                                };
                            }
                        }

                        billing[dishId].quantity += change;

                        if (billing[dishId].quantity < 0) {
                            billing[dishId].quantity = 0;
                        }

                        renderBilling();
                    }

                    function renderBilling() {
                        const billingList = document.getElementById('billing-list');
                        billingList.innerHTML = '';

                        let total = 0;

                        for (const id in billing) {
                            if (billing[id].quantity > 0) {
                                const itemTotal = billing[id].quantity * billing[id].price;
                                total += itemTotal;

                                const itemDiv = document.createElement('div');
                                itemDiv.className = 'grid grid-cols-3 text-white font-main text-xs gap-x-5 mb-1 2xl:mb-2';

                                itemDiv.innerHTML = `
                                    <div class="flex justify-center items-center">
                                        <h2 class="text-center">${billing[id].quantity}</h2>
                                    </div>

                                    <div class="flex justify-start items-center min-w-[100px] max-w-[200px] flex-wrap">
                                        <h2 class="text-left text-ellipsis overflow-hidden whitespace-normal" title="${billing[id].title}">
                                            ${billing[id].title}
                                        </h2>
                                    </div>
                                    <div class="flex justify-center items-center">
                                        <h2 class="text-center">₡${itemTotal.toFixed(2)}</h2>
                                    </div>
                            `;
                                billingList.appendChild(itemDiv);
                            }
                        }

                        document.getElementById('total-amount').innerText = `₡${total.toFixed(2)}`;

                        updateChange();
                    }

                    document.querySelectorAll('.product-item button:nth-of-type(1)').forEach(button => {
                        button.addEventListener('click', function () {
                            const dishId = this.closest('.product-item').dataset.dishId;
                            updateQuantity(dishId, 1);
                        });
                    });

                    document.querySelectorAll('.product-item button:nth-of-type(2)').forEach(button => {
                        button.addEventListener('click', function () {
                            const dishId = this.closest('.product-item').dataset.dishId;
                            updateQuantity(dishId, -1);
                        });
                    });

                    document.querySelectorAll('.payment-method').forEach(button => {
                        button.addEventListener('click', function () {
                            const methodId = this.dataset.value;
                            document.getElementById('paymentMethodInput').value = methodId;

                            // Muestra u oculta la sección de pago para efectivo
                            document.getElementById('payment-amount-section').style.display = methodId === "1" ? 'grid' : 'none';
                            document.getElementById('change-section').style.display = methodId === "1" ? 'grid' : 'none';

                        });
                    });

                    // Configura el formulario antes de enviar
                    document.getElementById('order-form').onsubmit = function (event) {
                        const addedItems = Object.keys(billing).map(id => ({ id, quantity: billing[id].quantity })).filter(item => item.quantity > 0);
                        document.getElementById('addedItemsInput').value = JSON.stringify(addedItems);

                        // Verificar si hay productos añadidos
                        const paymentMethod = document.getElementById('paymentMethodInput').value;
                        // Verificar si hay productos añadidos
                        if (addedItems.length === 0) {
                            event.preventDefault();  // Evita el envío del formulario
                            alert('Por favor, agregue al menos un producto antes de facturar.');
                            return;
                        }

                        if (!paymentMethod) {
                            event.preventDefault();  // Evita el envío del formulario
                            alert('Por favor, seleccione un método de pago antes de facturar.');
                            return;
                        }

                        const voucherNumber = document.getElementById('voucher-number').value;

                        // Verificar si el método de pago es Tarjeta (2) o Sinpe (3) y si el número de voucher está vacío
                        if ((paymentMethod === "2" || paymentMethod === "3") && !voucherNumber) {
                            event.preventDefault();  // Evita el envío del formulario
                            alert('El número de voucher/comprobante es obligatorio para el método de pago seleccionado.');
                            return;
                        }

                        // Verificación de pago en efectivo (si es necesario)
                        if (paymentMethod === "1") { // Efectivo
                            const total = parseFloat(document.getElementById('total-amount').innerText.replace('₡', '')) || 0;
                            const payment = parseFloat(document.getElementById('customer-payment').value) || 0;

                            if (payment < total) {
                                event.preventDefault();  // Evita el envío del formulario
                                alert(`El monto recibido es insuficiente. El total es de ₡${total}.`);
                            }
                        }
                    };

                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const paymentMethodButtons = document.querySelectorAll('.payment-method');
                    const voucherSection = document.getElementById('voucher-section');
                    const voucherLabel = document.getElementById('voucher-label');
                    const paymentMethodInput = document.getElementById('paymentMethodInput');
                    
                    paymentMethodButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const paymentMethod = this.getAttribute('data-value');
                            
                            // Actualizar el input hidden para el método de pago
                            paymentMethodInput.value = paymentMethod;
                            
                            // Mostrar o esconder el campo de voucher según el método de pago
                            if (paymentMethod === '2') { // Tarjeta
                                voucherSection.style.display = 'block';
                                voucherLabel.textContent = 'Número de Voucher';
                            } else if (paymentMethod === '3') { // Sinpe
                                voucherSection.style.display = 'block';
                                voucherLabel.textContent = 'Número de Comprobante';
                            } else { // Efectivo
                                voucherSection.style.display = 'none';
                                document.getElementById('voucher-number').value = ''; // Resetear el campo si es efectivo
                            }
                        });
                    });
                });
            </script>

        </div>

    </div>
@endsection