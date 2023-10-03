@extends('layouts.app', ['title' => 'Fornecedores'])

@section('content')
    <form action="{{isset($supplier) ? route('suppliers.update', $supplier->id) : route('suppliers.store')}}" method="POST" class="grid grid-cols-2 gap-3">
        @csrf
        @isset($supplier)
            @method('PUT')
        @endisset
        {{--    NOME    --}}
        <div class="mb-2">
            <label for="name" class="block mb-1 font-medium leading-6 text-gray-700">Nome <span class="text-red-500 font-bold">*</span></label>
            <input value="{{isset($supplier) ? $supplier->name : old('name')}}" type="text" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="name" name="name">
        </div>
        {{--    CNPJ    --}}
        <div class="mb-2">
            <label for="cnpj" class="block mb-1 font-medium leading-6 text-gray-700">CNPJ</label>
            <input value="{{isset($supplier) ? \App\Helpers\Helper::maskCNPJ($supplier->cnpj) : old('cnpj')}}" type="text" oninput="maskCNPJ(this)" placeholder="00.000.000/0000-00" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="cnpj" name="cnpj">
        </div>
        {{--    EMAIL    --}}
        <div class="mb-2">
            <label for="email" class="block mb-1 font-medium leading-6 text-gray-700">Email</label>
            <input value="{{isset($supplier) ? $supplier->email : old('email')}}" type="email" placeholder="fulano@google.com" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="email" name="email">
        </div>
        {{--    TELEFONE    --}}
        <div class="mb-2">
            <label for="phone" class="block mb-1 font-medium leading-6 text-gray-700">Telefone</label>
            <input value="{{isset($supplier) ? \App\Helpers\Helper::maskPhone($supplier->phone) : old('phone')}}" type="text" oninput="maskPhone(this)" placeholder="(00) 00000-0000" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="phone" name="phone">
        </div>
        {{--    SITE    --}}
        <div class="mb-2">
            <label for="site" class="block mb-1 font-medium leading-6 text-gray-700">Site</label>
            <input value="{{isset($supplier) ? $supplier->site : old('site')}}" type="text" placeholder="www.google.com" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="site" name="site">
        </div>
        {{--    ENDEREÇO    --}}
        <div class="mb-2">
            <label for="address" class="block mb-1 font-medium leading-6 text-gray-700">Endereço</label>
            <input value="{{isset($supplier) ? $supplier->address : old('address')}}" type="text" placeholder="Digite o endereço do cliente (Rua, N°- Bairro, Cidade - Estado)" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="address" name="address">
        </div>

        <span class="text-gray-400 text-sm">Itens com <span class="text-red-300 font-bold">*</span> são obrigatórios.</span>

        {{--    BOTÕES DE AÇÃO    --}}
        <div class="col-span-2 flex justify-between mt-3">
            <a class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" href="{{ route('suppliers.index') }}">Voltar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Salvar</button>
        </div>
    </form>
@endsection

@push('js')
    <script>
        function maskCNPJ(element) {
            element.value = element.value.substring(0, 18);
            element.value = element.value.replace(/\D/g, "")
                .replace(/(\d{2})(\d)/, "$1.$2")
                .replace(/(\d{3})(\d)/, "$1.$2")
                .replace(/(\d{3})(\d)/, "$1/$2")
                .replace(/(\d{4})(\d)/, "$1-$2")
                .replace(/(-\d{2})\d+?$/, "$1")
        }

        function maskPhone(element) {
            element.value = element.value.replace(/\D/g, "")
                .replace(/(\d{2})(\d)/, "($1) $2")
                .replace(/(\d{4})(\d)/, "$1-$2")
                .replace(/(\d{4})-(\d)(\d{4})/, "$1$2-$3")
                .replace(/(-\d{4})\d+?$/, "$1")
        }
    </script>
@endpush
