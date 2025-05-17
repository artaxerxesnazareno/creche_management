@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <div>
            <h1 class="h2">Responsáveis</h1>
            <p class="text-muted">Gerencie o cadastro de responsáveis</p>
        </div>
        <a href="{{ route('responsaveis.create') }}" class="btn btn-primary">
            <i class="bi bi-plus me-1"></i> Novo Responsável
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Lista de Responsáveis</h5>
            <p class="card-subtitle text-muted">Visualize e gerencie todos os responsáveis cadastrados</p>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Buscar responsável...">
                    </div>
                </div>
                <div class="col-md-4 d-flex justify-content-md-end mt-3 mt-md-0">
                    <button class="btn btn-outline-secondary">Filtrar</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Crianças</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $responsaveis = [
                            ['id' => 1, 'nome' => 'Maria Silva', 'telefone' => '(11) 98765-4321', 'email' => 'maria.silva@email.com', 'criancas' => 'Ana Silva'],
                            ['id' => 2, 'nome' => 'Carlos Santos', 'telefone' => '(11) 91234-5678', 'email' => 'carlos.santos@email.com', 'criancas' => 'João Santos'],
                            ['id' => 3, 'nome' => 'Juliana Oliveira', 'telefone' => '(11) 99876-5432', 'email' => 'juliana.oliveira@email.com', 'criancas' => 'Pedro Oliveira'],
                            ['id' => 4, 'nome' => 'Roberto Costa', 'telefone' => '(11) 98765-1234', 'email' => 'roberto.costa@email.com', 'criancas' => 'Mariana Costa'],
                            ['id' => 5, 'nome' => 'Fernanda Pereira', 'telefone' => '(11) 97654-3210', 'email' => 'fernanda.pereira@email.com', 'criancas' => 'Lucas Pereira'],
                            ['id' => 6, 'nome' => 'Marcelo Souza', 'telefone' => '(11) 96543-2109', 'email' => 'marcelo.souza@email.com', 'criancas' => 'Beatriz Souza'],
                            ['id' => 7, 'nome' => 'Patrícia Lima', 'telefone' => '(11) 95432-1098', 'email' => 'patricia.lima@email.com', 'criancas' => 'Gabriel Lima'],
                            ['id' => 8, 'nome' => 'Eduardo Martins', 'telefone' => '(11) 94321-0987', 'email' => 'eduardo.martins@email.com', 'criancas' => 'Sofia Martins'],
                        ];
                        @endphp

                        @foreach($responsaveis as $responsavel)
                        <tr>
                            <td>{{ $responsavel['nome'] }}</td>
                            <td>{{ $responsavel['telefone'] }}</td>
                            <td>{{ $responsavel['email'] }}</td>
                            <td>{{ $responsavel['criancas'] }}</td>
                            <td class="text-end">
                                <a href="{{ route('responsaveis.show', $responsavel['id']) }}" class="btn btn-sm btn-outline-primary">
                                    Ver detalhes
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
