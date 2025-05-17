@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <div>
            <h1 class="h2">Crianças</h1>
            <p class="text-muted">Gerencie o cadastro de crianças da creche</p>
        </div>
        <a href="{{ route('criancas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus me-1"></i> Nova Criança
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Lista de Crianças</h5>
            <p class="card-subtitle text-muted">Visualize e gerencie todas as crianças cadastradas</p>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Buscar criança...">
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
                            <th>Idade</th>
                            <th>Turma</th>
                            <th>Responsável</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $criancas = [
                            ['id' => 1, 'nome' => 'Ana Silva', 'idade' => '3 anos', 'turma' => 'Maternal II', 'responsavel' => 'Maria Silva'],
                            ['id' => 2, 'nome' => 'João Santos', 'idade' => '4 anos', 'turma' => 'Jardim I', 'responsavel' => 'Carlos Santos'],
                            ['id' => 3, 'nome' => 'Pedro Oliveira', 'idade' => '2 anos', 'turma' => 'Maternal I', 'responsavel' => 'Juliana Oliveira'],
                            ['id' => 4, 'nome' => 'Mariana Costa', 'idade' => '5 anos', 'turma' => 'Jardim II', 'responsavel' => 'Roberto Costa'],
                            ['id' => 5, 'nome' => 'Lucas Pereira', 'idade' => '3 anos', 'turma' => 'Maternal II', 'responsavel' => 'Fernanda Pereira'],
                            ['id' => 6, 'nome' => 'Beatriz Souza', 'idade' => '4 anos', 'turma' => 'Jardim I', 'responsavel' => 'Marcelo Souza'],
                            ['id' => 7, 'nome' => 'Gabriel Lima', 'idade' => '2 anos', 'turma' => 'Maternal I', 'responsavel' => 'Patrícia Lima'],
                            ['id' => 8, 'nome' => 'Sofia Martins', 'idade' => '5 anos', 'turma' => 'Jardim II', 'responsavel' => 'Eduardo Martins'],
                        ];
                        @endphp

                        @foreach($criancas as $crianca)
                        <tr>
                            <td>{{ $crianca['nome'] }}</td>
                            <td>{{ $crianca['idade'] }}</td>
                            <td>{{ $crianca['turma'] }}</td>
                            <td>{{ $crianca['responsavel'] }}</td>
                            <td class="text-end">
                                <a href="{{ route('criancas.show', $crianca['id']) }}" class="btn btn-sm btn-outline-primary">
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
