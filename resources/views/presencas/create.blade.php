<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Registrar Presenças') }}
            </h2>
            <a href="{{ route('presencas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Voltar') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('presencas.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <label for="data" class="block text-sm font-medium text-gray-700">Data</label>
                                    <input type="date" name="data" id="data" value="{{ $data }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                                <div>
                                    <button type="button" id="marcar-todos" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Marcar todos como presentes
                                    </button>
                                    <button type="button" id="desmarcar-todos" class="ml-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Marcar todos como ausentes
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if ($turmas->count() > 0)
                            @foreach ($turmas as $turma)
                                @if ($turma->criancas->count() > 0)
                                    <div class="mb-8">
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $turma->nome }}</h3>
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Nome
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Idade
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Presença
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Observações
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($turma->criancas as $crianca)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="flex items-center">
                                                                    @if ($crianca->foto)
                                                                        <div class="flex-shrink-0 h-10 w-10 mr-3">
                                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $crianca->foto) }}" alt="{{ $crianca->nome }}">
                                                                        </div>
                                                                    @else
                                                                        <div class="flex-shrink-0 h-10 w-10 mr-3 bg-gray-200 rounded-full flex items-center justify-center">
                                                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                            </svg>
                                                                        </div>
                                                                    @endif
                                                                    <div>
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            {{ $crianca->nome }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm text-gray-900">{{ $crianca->idade }} anos</div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="flex items-center space-x-4">
                                                                    <div class="flex items-center">
                                                                        <input id="presente-{{ $crianca->id }}" name="presencas[{{ $crianca->id }}]" value="presente" type="radio" class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500" checked>
                                                                        <label for="presente-{{ $crianca->id }}" class="ml-2 block text-sm text-gray-900">
                                                                            Presente
                                                                        </label>
                                                                    </div>
                                                                    <div class="flex items-center">
                                                                        <input id="ausente-{{ $crianca->id }}" name="presencas[{{ $crianca->id }}]" value="ausente" type="radio" class="h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500">
                                                                        <label for="ausente-{{ $crianca->id }}" class="ml-2 block text-sm text-gray-900">
                                                                            Ausente
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <input type="text" name="observacoes[{{ $crianca->id }}]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Observações">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Salvar Presenças') }}
                                </button>
                            </div>
                        @else
                            <div class="text-center py-10">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma turma encontrada</h3>
                                <p class="mt-1 text-sm text-gray-500">Não há turmas cadastradas ou nenhuma criança matriculada.</p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const marcarTodos = document.getElementById('marcar-todos');
            const desmarcarTodos = document.getElementById('desmarcar-todos');

            marcarTodos.addEventListener('click', function() {
                document.querySelectorAll('input[value="presente"]').forEach(function(radio) {
                    radio.checked = true;
                });
            });

            desmarcarTodos.addEventListener('click', function() {
                document.querySelectorAll('input[value="ausente"]').forEach(function(radio) {
                    radio.checked = true;
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
