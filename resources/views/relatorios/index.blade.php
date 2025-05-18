@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Relatórios</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Relatório de Crianças</h2>
                    <p class="text-sm text-gray-500 mb-4">Gere relatórios de crianças por turma, idade ou outros filtros.</p>
                    <a href="{{ route('relatorios.criancas') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Gerar Relatório
                    </a>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Relatório de Pagamentos</h2>
                    <p class="text-sm text-gray-500 mb-4">Visualize relatórios de pagamentos, mensalidades em atraso e receitas.</p>
                    <a href="{{ route('relatorios.pagamentos') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Gerar Relatório
                    </a>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Relatório de Frequência</h2>
                    <p class="text-sm text-gray-500 mb-4">Acompanhe a frequência das crianças por período, turma ou individual.</p>
                    <a href="{{ route('relatorios.frequencia') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Gerar Relatório
                    </a>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Relatório de Matrículas</h2>
                    <p class="text-sm text-gray-500 mb-4">Visualize dados sobre matrículas ativas, pendentes e canceladas.</p>
                    <a href="{{ route('relatorios.matriculas') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-  }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Gerar Relatório
                    </a>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Relatório de Responsáveis</h2>
                    <p class="text-sm text-gray-500 mb-4">Acesse informações sobre os responsáveis cadastrados no sistema.</p>
                    <a href="{{ route('relatorios.responsaveis') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Gerar Relatório
                    </a>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Exportar Dados</h2>
                    <p class="text-sm text-gray-500 mb-4">Exporte dados do sistema para planilhas Excel ou CSV.</p>
                    <a href="{{ route('relatorios.exportar') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Exportar Dados
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
