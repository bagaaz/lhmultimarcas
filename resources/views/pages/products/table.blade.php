@extends('layouts.app', ['title' => __('Products')])

@section('content')
    <div>
        {{--    Actions    --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <a href="{{ route('products.create') }}" class="flex py-2 pl-1 pr-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    @svg('heroicon-m-plus-small', 'h-5 w-5') Novo
                </a>
            </div>

            <div>
                <form class="flex items-center" method="GET" action="{{ route('products.index') }}">
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
                    <th scope="col" class="px-6 py-3">Nome</th>
                    <th scope="col" class="px-6 py-3">Cor</th>
                    <th scope="col" class="px-6 py-3">Tamanho</th>
                    <th scope="col" class="px-6 py-3">Marca</th>
                    <th scope="col" class="px-6 py-3">Categoria</th>
                    <th scope="col" class="px-6 py-3">Quantidade</th>
                    <th scope="col" class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr ondblclick="openEdit('{{ route('products.edit', $product->id) }}')" class="bg-white border-b">
                        <td class="px-6 py-4">{{ $product->id }}</td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $product->name }}</th>
                        <td class="px-6 py-4">{{ $product->color->name }}</td>
                        <td class="px-6 py-4">{{ $product->size->name }}</td>
                        <td class="px-6 py-4">{{ $product->brand->name }}</td>
                        <td class="px-6 py-4">{{ $product->category->name }}</td>
                        <td class="px-6 py-4">{{ $product->quantity }}</td>
                        <td class="px-6 py-4 flex items-center">
                            <a href="{{ route('products.edit', $product->id) }}" class="py-2 pl-2 pr-1.5 mr-1 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                @svg('heroicon-o-pencil-square', 'h-5 w-5')
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Você tem certeza?');" style="display:inline;">
                                @csrf  <!-- Token de segurança -->
                                @method('DELETE')  <!-- Especifica o método HTTP DELETE -->
                                <button type="submit" class="p-2 ml-1 text-sm font-medium text-white bg-red-700 rounded-lg border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                                    @svg('heroicon-o-trash', 'h-5 w-5')
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{--    Paginate    --}}
        <div>
            {{ $products->links() }}
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
