@extends('layouts.app', ['title' => 'Vendas - Parcelas'])

@section('content')
    <div class="grid justify-items-stretch mb-4">
        <a href="{{ route('sales.index') }}" class="justify-self-start bg-transparent hover:bg-zinc-500 text-zinc-700 font-semibold hover:text-white py-2 px-4 border border-zinc-500 hover:border-transparent rounded">Voltar</a>
        <h4 class="font-bold justify-self-center text-lg">Parcelas</h4>
    </div>
    <div>
        {{--    Parcelas    --}}
        <div class="px-2 py-3 border rounded">
            <span class="font-bold">1</span>
            <div class="grid">
                <span>Valor:</span>
                <span class="font-bold">R$ 35,25</span>
            </div>
            <div class="grid">
                <span>Vencimento:</span>
                <span class="font-bold">10/10/2020</span>
            </div>
            <div class="grid">
                <span>Pagamento:</span>
                <span class="font-bold">Concluído</span>
            </div>
        </div>
    </div>
@endsection
