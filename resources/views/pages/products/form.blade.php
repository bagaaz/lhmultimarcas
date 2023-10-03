@extends('layouts.app', ['title' => 'Produtos'])

@section('content')
    <form action="{{isset($product) ? route('products.update', $product->id) : route('products.store')}}" method="POST" class="grid grid-cols-2 gap-3">
        @csrf
        @isset($product)
            @method('PUT')
        @endisset
        {{--    NOME    --}}
        <div class="mb-2">
            <label for="name" class="block mb-1 font-medium leading-6 text-gray-700">Nome <span class="text-red-500 font-bold">*</span></label>
            <input value="{{isset($product) ? $product->name : old('name')}}" type="text" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="name" name="name">
        </div>
        {{--    QUANTIDADE    --}}
        <div class="mb-2">
            <label for="quantity" class="block mb-1 font-medium leading-6 text-gray-700">Quantidade <span class="text-red-500 font-bold">*</span></label>
            <input value="{{isset($product) ? $product->quantity : old('quantity')}}" type="number" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="quantity" name="quantity">
        </div>
        {{--    DESCRIÇÃO    --}}
        <div class="col-span-2 mb-2">
            <label for="description" class="block mb-1 font-medium leading-6 text-gray-700">Descrição</label>
            <textarea class="block w-full resize-none rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="description" name="description" rows="6">{{isset($product) ? $product->description : old('description')}}</textarea>
        </div>
        {{--    CATEGORIA    --}}
        <div class="mb-2">
            <label for="category_id" class="block mb-1 font-medium leading-6 text-gray-700">Categoria <span class="text-red-500 font-bold">*</span></label>
            <div class="flex">
                <select class="block w-full bg-transparent rounded-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="category_id" name="category_id"
                        onchange="showActionsButtons(this, this.value, this.options[this.selectedIndex].text, '/products/categories')">
                    <option value="">Selecione uma categoria...</option>
                    @foreach($relations['categories'] as $category)
                        <option value="{{ $category->id }}" {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <div id="actions" class="flex">
                    <button onclick="showModal('Criar Categoria', '/products/categories')" class="block bg-green-400 hover:bg-green-700 text-white font-bold py-1.5 px-3 ml-2 rounded" type="button">
                        +
                    </button>
                </div>
            </div>
        </div>
        {{--    MARCA    --}}
        <div class="mb-2">
            <label for="brand_id" class="block mb-1 font-medium leading-6 text-gray-700">Marca <span class="text-red-500 font-bold">*</span></label>
            <div class="flex">
                <select class="block w-full bg-transparent rounded-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="brand_id" name="brand_id"
                        onchange="showActionsButtons(this, this.value, this.options[this.selectedIndex].text, '/products/brands')">
                    <option value="">Selecione uma marca...</option>
                    @foreach($relations['brands'] as $brand)
                        <option value="{{ $brand->id }}" {{ isset($product) && $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
                <div id="actions" class="flex">
                    <button onclick="showModal('Criar Marca', '/products/brands')" class="block bg-green-400 hover:bg-green-700 text-white font-bold py-1.5 px-3 ml-2 rounded" type="button">
                        +
                    </button>
                </div>
            </div>
        </div>
        {{--    COR    --}}
        <div class="mb-2">
            <label for="color_id" class="block mb-1 font-medium leading-6 text-gray-700">Cor <span class="text-red-500 font-bold">*</span></label>
            <div class="flex">
                <select class="block w-full bg-transparent rounded-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="color_id" name="color_id"
                        onchange="showActionsButtons(this, this.value, this.options[this.selectedIndex].text, '/products/colors')">
                    <option value="">Selecione uma cor...</option>
                    @foreach($relations['colors'] as $color)
                        <option value="{{ $color->id }}" {{ isset($product) && $product->color_id == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                    @endforeach
                </select>
                <div id="actions" class="flex">
                    <button onclick="showModal('Criar Cor', '/products/colors')" class="block bg-green-400 hover:bg-green-700 text-white font-bold py-1.5 px-3 ml-2 rounded" type="button">
                        +
                    </button>
                </div>
            </div>
        </div>
        {{--    TAMANHO    --}}
        <div class="mb-2">
            <label for="size_id" class="block mb-1 font-medium leading-6 text-gray-700">Tamanho <span class="text-red-500 font-bold">*</span></label>
            <div class="flex">
                <select class="block w-full bg-transparent rounded-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="size_id" name="size_id"
                        onchange="showActionsButtons(this, this.value, this.options[this.selectedIndex].text, '/products/sizes')">
                    <option value="">Selecione um tamanho...</option>
                    @foreach($relations['sizes'] as $size)
                        <option value="{{ $size->id }}" {{ isset($product) && $product->size_id == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                    @endforeach
                </select>
                <div id="actions" class="flex">
                    <button onclick="showModal('Criar Tamanho', '/products/sizes')" class="block bg-green-400 hover:bg-green-700 text-white font-bold py-1.5 px-3 ml-2 rounded" type="button">
                        +
                    </button>
                </div>
            </div>
        </div>
        <span class="text-gray-400 text-sm">Itens com <span class="text-red-300 font-bold">*</span> são obrigatórios.</span>

        {{--    BOTÕES DE AÇÃO    --}}
        <div class="col-span-2 flex justify-between mt-3">
            <a class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" href="{{ route('products.index') }}">Voltar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Salvar</button>
        </div>
    </form>


{{--  MODAL  --}}
    <div id="modal" tabindex="-1" class="fixed min-h-screen z-50 hidden justify-center items-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 max-h-full bg-black bg-opacity-50">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="title-modal" class="text-xl font-medium text-gray-900 dark:text-white">
                        {{-- Aqui vai o Título --}}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Fechar modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form id="form-modal" action="" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="block mb-1 font-medium leading-6 text-gray-900">Nome</label>
                            <input type="text" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-1 focus:ring-inset focus:ring-indigo-300 sm:text-sm sm:leading-6" id="name" name="name">
                        </div>

                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="btn-modal" data-modal-hide="small-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Salvar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('csrf_token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('js')
<script>
    const modal = document.querySelector('#modal')
    const modalHide = document.querySelector('[data-modal-hide]')
    const btnModal = document.querySelector('#btn-modal')

    //To send the form inside the modal
    btnModal.addEventListener('click', () => {
        const form = document.querySelector('#form-modal')
        form.submit()
    })

    //To hide the modal
    modalHide.addEventListener('click', () => {
        modal.classList.add('hidden')
        modal.classList.remove('flex')
    })

    function showModal(title, link, id = '', name = null) {
        const modal = document.querySelector('#modal')
        const modalTitle = document.querySelector('#title-modal')
        const modalForm = document.querySelector('#form-modal')

        modalTitle.innerHTML = title
        modalForm.action = link
        if (id !== '') {
            console.log(id)
            modalForm.innerHTML += `<input type="hidden" name="id" value="${id}">`
            modalForm.querySelector('#name').value = name
        }

        if (modal.classList.contains('hidden')) {
            modal.classList.add('flex')
            modal.classList.remove('hidden')
        }
    }

    function showActionsButtons(element, id, name, url)
    {
        const parent = element.parentNode
        const actions = parent.querySelector('#actions')

        if (id === '') {
            actions.innerHTML = `
                <button onclick="showModal('Criar Tamanho', '${url}')" class="block bg-green-400 hover:bg-green-700 text-white font-bold py-1.5 px-3 ml-2 rounded" type="button">
                    +
                </button>
            `
        } else {
            actions.innerHTML = `
                <button onclick="showModal('Editar Tamanho', '${url}', '${id}', '${name}')" class="block bg-yellow-400 hover:bg-yellow-700 text-white font-bold py-1.5 px-3 ml-2 rounded" type="button">
                    E
                </button>
                <button onclick="deleteItem('${url}/${id}')" class="block bg-red-400 hover:bg-red-700 text-white font-bold py-1.5 px-3 ml-2 rounded" type="button">
                    D
                </button>
            `
        }
    }

    function deleteItem(url) {
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
</script>
@endpush
