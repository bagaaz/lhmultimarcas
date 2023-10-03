@extends('layouts.app', ['title' => __('Dashboard')])

@section('content')
    {{--  Filters List  --}}
    <div class="flex flex-wrap justify-end mb-2">
        <div class="relative h-10 w-40 mr-5">
            <select id="period" name="period" onchange="filterPeriod()" class="peer h-full w-full rounded-[7px] border border-blue-gray-200 border-t-transparent bg-transparent px-3 py-2.5 font-sans text-sm font-normal text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 empty:!bg-red-500 focus:border-2 focus:border-pink-500 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50">
                <option value="24h" {{ old('period', $period) == '24h' ? 'selected' : '' }}>Hoje</option>
                <option value="7d"  {{ old('period', $period) == '7d' ? 'selected' : '' }}>Últimos 7 dias</option>
                <option value="1m"  {{ old('period', $period) == '1m' ? 'selected' : '' }}>Este mês</option>
                <option value="1y"  {{ old('period', $period) == '1y' ? 'selected' : '' }}>Este ano</option>
                <option value="all"  {{ old('period', $period) == 'all' ? 'selected' : '' }}>Desde o início</option>
            </select>
            <label class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none text-[11px] font-normal leading-tight text-blue-gray-400 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-pink-500 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:border-pink-500 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:border-pink-500 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                Selecione um período
            </label>
        </div>
    </div>

    {{--  Status Cards  --}}
    <div class="flex flex-wrap">

        {{--    Card One    --}}
        <div class="mt-4 w-full lg:w-6/12 xl:w-3/12 px-5 mb-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-3 xl:mb-0 shadow-lg">
                <div class="flex-auto p-4">
                    <div class="flex flex-wrap">
                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                            <h5 class="text-blueGray-400 uppercase font-bold text-xs">VALOR DO ESTOQUE</h5>
                            <span class="font-semibold text-xl text-blueGray-700">{{ $data['stock_value'] }}</span>
                        </div>
                        <div class="relative w-auto pl-4 flex-initial">
                            <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-red-500">
                                @svg('heroicon-o-archive-box', 'h-6 w-6')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--    Card Two    --}}
        <div class=" mt-4 w-full lg:w-6/12 xl:w-3/12 px-5">
            <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-4 xl:mb-0 shadow-lg">
                <div class="flex-auto p-4">
                    <div class="flex flex-wrap">
                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                            <h5 class="text-blueGray-400 uppercase font-bold text-xs">QNTD. DE VENDAS</h5>
                            <span class="font-semibold text-xl text-blueGray-700">{{ $data['sales_quantity'] }}</span>
                        </div>
                        <div class="relative w-auto pl-4 flex-initial">
                            <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-pink-500">
                                @svg('heroicon-o-shopping-bag', 'h-6 w-6')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--    Card Three    --}}
        <div class="mt-4 w-full lg:w-6/12 xl:w-3/12 px-5">
            <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                <div class="flex-auto p-4">
                    <div class="flex flex-wrap">
                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                            <h5 class="text-blueGray-400 uppercase font-bold text-xs">VALOR VENDIDO</h5>
                            <span class="font-semibold text-xl text-blueGray-700">{{ $data['sales_value'] }}</span>
                        </div>
                        <div class="relative w-auto pl-4 flex-initial">
                            <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-sky-500">
                                @svg('heroicon-o-currency-dollar', 'h-6 w-6')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--    Card Four    --}}
        <div class="mt-4 w-full lg:w-6/12 xl:w-3/12 px-5">
            <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                <div class="flex-auto p-4">
                    <div class="flex flex-wrap">
                        <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                            <h5 class="text-blueGray-400 uppercase font-bold text-xs">LUCRO</h5>
                            <span class="font-semibold text-xl text-blueGray-700">{{ $data['sales_liquid_value'] }}</span>
                        </div>
                        <div class="relative w-auto pl-4 flex-initial">
                            <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-emerald-500">
                                @svg('heroicon-o-banknotes', 'h-6 w-6')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        function filterPeriod() {
            const period = document.getElementById('period').value;
            window.location.href = window.location.pathname + '?period=' + period;
        }
    </script>
@endpush
