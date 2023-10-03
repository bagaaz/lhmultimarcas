<div class="flex flex-col align-center justify-between h-full">
    <div class="w-full">
        <div class="w-full text-center pb-5 border-b border-neutral-400">
            <h1 class="font-bold text-white text-xl">LH Multimarcas</h1>
        </div>

        <nav class="mt-3">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">@svg('heroicon-m-squares-2x2', 'h-5 w-5 mr-3') Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">@svg('heroicon-m-shopping-bag', 'h-5 w-5 mr-3') Produtos</a>
                </li>
                <li>
                    <a href="{{ route('sales.index') }}" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">@svg('heroicon-m-shopping-cart', 'h-5 w-5 mr-3') Vendas</a>
                <li>
                    <a href="{{ route('suppliers.index') }}" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">@svg('heroicon-s-clipboard-document-list', 'h-5 w-5 mr-3') Fornecedores</a>
                <li>
                    <a href="{{ route('clients.index') }}" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">@svg('heroicon-m-users', 'h-5 w-5 mr-3') Clientes</a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="w-full text-center">
        <a href="{{ route('logout') }}" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">@svg('heroicon-m-chevron-left', 'h-5 w-5 mr-3') Sair</a>
    </div>
</div>
