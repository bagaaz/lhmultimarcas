@extends('layouts.app', ['title' => __('Sales')])

@section('content')
    <div>
        {{--    Actions    --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <a href="{{ route('sales.create') }}" class="flex py-2 pl-1 pr-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    @svg('heroicon-m-plus-small', 'h-5 w-5') Novo
                </a>
            </div>

            <div>
                <form class="flex items-center" method="GET" action="{{ route('sales.index') }}">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            @svg('heroicon-m-magnifying-glass', 'h-5 w-5 text-gray-400')
                        </div>
                        <input type="text" id="search" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2" placeholder="Search ...">
                    </div>
                    <button type="submit" class="p-2 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        @svg('heroicon-m-magnifying-glass', 'h-5 w-5 text-white')
                    </button>
                </form>
            </div>
        </div>

        {{--    Table    --}}
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">Cliente</th>
                <th scope="col" class="px-6 py-3">Método de Pagamento</th>
                <th scope="col" class="px-6 py-3">Qntd. Produtos</th>
                <th scope="col" class="px-6 py-3">Desconto</th>
                <th scope="col" class="px-6 py-3">Total</th>
                <th scope="col" class="px-6 py-3">Data</th>
                <th scope="col" class="px-6 py-3"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr ondblclick="openEdit('{{ route('sales.edit', $sale->id) }}')" class="bg-white border-b">
                    <td class="px-6 py-4">{{ $sale->id }}</td>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $sale->client->name }}</th>
                    <td class="px-6 py-4">{{ $sale->paymentMethod->name }}</td>
                    <td class="px-6 py-4">{{ $sale->products_count }}</td>
                    <td class="px-6 py-4">{{ $sale->discount}}</td>
                    <td class="px-6 py-4">{{ $sale->order_total_value }}</td>
                    <td class="px-6 py-4">{{ \App\Helpers\Helper::maskDate($sale->updated_at) }}</td>
                    <td class="px-6 py-4 flex items-center">
                        <a href="{{ route('sales.edit', $sale->id) }}" class="py-2 pl-2 pr-1.5 mr-1 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            @svg('heroicon-o-pencil-square', 'h-5 w-5')
                        </a>
                        <a href="{{ route('sales.destroy', $sale->id) }}" class="p-2 ml-1 text-sm font-medium text-white bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                            @svg('heroicon-o-trash', 'h-5 w-5')
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{--    Paginate    --}}
        <div>
            {{ $sales->links() }}
        </div>
    </div>
@endsection

@push('js')
    <script>
        function openEdit(url) {
            window.location.href = url
        }
    </script>
@endpush
