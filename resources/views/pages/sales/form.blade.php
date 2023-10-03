@extends('layouts.app', ['title' => 'Vendas - Pedidos'])

@section('content')
    <form action="{{isset($sale) ? route('sales.update', ['id' => $sale->id]) : route('sales.store')}}" method="POST" class="grid grid-cols-2 gap-3">
        @csrf
        @isset($sale)
            @method('PUT')
        @endisset

        {{--    CLIENT   --}}
        <div class="mb-2">
            <label for="client_id" class="block mb-1 font-medium leading-6 text-gray-700">Cliente <span class="text-red-500 font-bold">*</span></label>
            <select id="client_id" name="client_id" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" data-old-choice="{{isset($sale) ? $sale->client_id : ''}}"></select>
        </div>

        {{--    PAYMENT METHOD   --}}
        <div class="mb-2">
            <label for="payment_method_id" class="block mb-1 font-medium leading-6 text-gray-700">Método de pagamento <span class="text-red-500 font-bold">*</span></label>
            <select id="payment_method_id" name="payment_method_id" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" data-old-choice="{{isset($sale) ? $sale->payment_method_id : ''}}"></select>
        </div>

        @isset($sale)
        {{--   ORDER ITENS   --}}
        <div class="col-span-2 mb-2 border-b border-t border-neutral-300">
            @if(isset($saleItems) && count($saleItems) > 0)
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Produto</th>
                        <th scope="col" class="px-6 py-3">Quantidade</th>
                        <th scope="col" class="px-6 py-3">Preço</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($saleItems as $saleItem)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">{{ $saleItem->id }}</td>
                            <td class="px-6 py-4">{{ $saleItem->product->name }}</td>
                            <td class="px-6 py-4">{{ $saleItem->quantity}}</td>
                            <td class="px-6 py-4">{{ \App\Helpers\Helper::maskMoney($saleItem->unity_price) }}</td>
                            <td scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">{{ \App\Helpers\Helper::maskMoney($saleItem->order_item_total) }}</td>
                            <td class="px-6 py-4 flex items-center">
                                <a onclick='deleteOrderItem("{{ route('sales.items.destroy', ['sale_id' => $saleItem->sale_id, 'sale_item_id' => $saleItem->id]) }}")' class="p-2 ml-1 text-sm font-medium text-white bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                                    @svg('heroicon-o-trash', 'h-5 w-5')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2" class="px-6 py-4"><span onclick="openModal()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">Adicionar item</span></td>
                    </tr>
                    </tfoot>
                </table>
            @else
                <p class="w-full text-center text-neutral-400 mb-3">Nenhum item cadastrado.</p>
                <div class="col-span-2">
                    <span onclick="openModal()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">Adicionar item</span>
                </div>
            @endif
        </div>

        @if(isset($saleItems[0]))
            @if($sale->payment_method_id == 2)
            <div>
                <a href="{{ route('sales.installments.index', ['sale_id' => $sale->id]) }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Ver parcelas
                </a>
            </div>
            @endif
        <table class="min-w-full col-start-2">
            <tr>
                <td class="border px-4 py-2">Subtotal</td>
                <td id="table_sale_subtotal" class="border px-4 py-2 text-right text-gray-500">{{ \App\Helpers\Helper::maskMoney($saleItems[0]->order_total) }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2">Taxa</td>
                <td id="table_sale_tax" class="border px-4 py-2 text-right text-red-300">{{ \App\Helpers\Helper::maskMoney($saleItems[0]->order_total * $sale->paymentMethod->tax) }}</td>
            </tr>
            <tr>
                <td class="border px-4 py-2">Desconto</td>
                <td class="border px-4 py-2 text-right text-gray-700">
                    <input oninput="maskMoney(this)" onfocusout="updateTableSaleData()" value="{{isset($sale) ? $sale->discount : old('discount')}}" type="text" class="w-full text-gray-700 text-right ring-0 placeholder:text-gray-400 focus:ring-0 focus:outline-none" id="discount" name="discount">
                </td>
            </tr>
            <tr>
                <td class="border px-4 py-2 font-bold">Total</td>
                <td id="table_sale_total" class="border px-4 py-2 font-bold text-right text-green-400"></td>
            </tr>
        </table>
       @endif
        @endisset

        {{--    BOTÕES DE AÇÃO    --}}
        <div class="col-span-2 flex justify-between mt-3">
            <a class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" href="{{ route('sales.index') }}">Voltar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">{{isset($sale) ? 'Salvar' : 'Avançar'}}</button>
        </div>
    </form>

    @isset($sale)
    {{--  MODAL  --}}
    <div id="modal" tabindex="-1" class="fixed min-h-screen z-50 hidden justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 max-h-full bg-black bg-opacity-50">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="title-modal" class="text-xl font-medium text-gray-900 dark:text-white">
                        Adicionar item
                    </h3>
                    <button onclick="closeModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Fechar modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form id="form-modal" action="{{ route('sales.items.create', $sale->id) }}" method="POST" class="flex flex-wrap">
                        @csrf
                        <div class="w-full mb-2">
                            <div class="mb-2">
                                <label for="product_id" class="block mb-1 font-medium leading-6 text-gray-700">Produto</label>
                                <select id="product_id" name="product_id" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6"></select>
                            </div>
                        </div>
                        <div class="w-1/2 pr-1 mb-2">
                            <label for="quantity" class="block mb-1 font-medium leading-6 text-gray-900">Quantidade</label>
                            <input type="number" value="0" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="quantity" name="quantity">
                        </div>
                        <div class="w-1/2 pl-1 mb-2">
                            <label for="unity_price" class="block mb-1 font-medium leading-6 text-gray-900">Preço</label>
                            <input type="text" oninput="maskMoney(this)" value="R$" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="unity_price" name="unity_price">
                        </div>

                        <span class="text-gray-400 text-sm">Itens com <span class="text-red-300 font-bold">*</span> são obrigatórios.</span>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="btn-modal" data-modal-hide="modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    @endisset
@endsection

@push('csrf_token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('js')
    <script>
        const btnModal = document.querySelector('#btn-modal')
        btnModal.addEventListener('click', () => {
            const form = document.querySelector('#form-modal')
            form.submit()
        })

        function closeModal() {
            const modal = document.getElementById('modal');

            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function openModal() {
            const modal = document.getElementById('modal');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function maskMoney(element) {
            let value = element.value;
            value = value.replace(/\D/g, "");
            value = value.replace(/(\d)(\d{2})$/, "$1,$2");
            value = value.replace(/(?=(\d{3})+(\D))\B/g, ".");
            value = 'R$ ' + value;
            element.value = value;
        }

        function deleteOrderItem(url) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    window.location.reload()
                })
        }

        function updateTableSaleData() {
            const tableSaleSubtotal = document.querySelector('#table_sale_subtotal')
            const tableSaleTax = document.querySelector('#table_sale_tax')
            const tableSaleDiscount = document.querySelector('#discount')
            const tableSaleTotal = document.querySelector('#table_sale_total')

            const subtotal = parseFloat(tableSaleSubtotal.innerText.replace('R$ ', '').replace('.', '').replace(',', '.'))
            const tax = parseFloat(tableSaleTax.innerText.replace('R$ ', '').replace('.', '').replace(',', '.'))
            const discount = parseFloat(tableSaleDiscount.value.replace('R$ ', '').replace('.', '').replace(',', '.'))

            const total = (subtotal + tax) - discount

            tableSaleTotal.innerText = 'R$ ' + total.toFixed(2).replace('.', ',')
        }

        updateTableSaleData()
    </script>
@endpush
